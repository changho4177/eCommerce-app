<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Trash2, Plus, Minus } from 'lucide-vue-next';

defineProps<{
    cartItems: any[];
    total: number;
}>();

const updateQuantity = (cartItemId: number, quantity: number) => {
    if (quantity < 1) return;
    router.put(`/cart/${cartItemId}`, { quantity }, { preserveScroll: true });
};

const removeItem = (cartItemId: number) => {
    if (confirm('Are you sure you want to remove this item?')) {
        router.delete(`/cart/${cartItemId}`, { preserveScroll: true });
    }
};

const checkout = () => {
    router.post('/orders');
};
</script>

<template>
    <AppLayout :breadcrumbs="[{ title: 'Cart', href: '/cart' }]">
        <Head title="Shopping Cart" />
        
        <div class="px-4 py-6 md:px-8">
            <h1 class="text-2xl font-bold mb-6">Shopping Cart</h1>

            <div v-if="cartItems.length === 0" class="flex items-center justify-center min-h-[50vh] text-neutral-200 dark:text-neutral-800 text-4xl font-bold select-none">
                Your cart is empty.
            </div>

            <div v-else>
                <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm border mb-6">
                    <ul class="divide-y divide-gray-200 dark:divide-neutral-700">
                        <li v-for="item in cartItems" :key="item.id" class="p-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img :src="item.product.image_url" :alt="item.product.name" class="w-16 h-16 object-cover rounded" v-if="item.product.image_url" />
                                <div>
                                    <h3 class="text-lg font-semibold">{{ item.product.name }}</h3>
                                    <p class="text-neutral-500">${{ item.product.price }} each</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center border rounded-md">
                                    <button @click="updateQuantity(item.id, item.quantity - 1)" class="px-3 py-1 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-neutral-700 rounded-l-md"><Minus class="w-4 h-4" /></button>
                                    <span class="px-4 py-1 text-center min-w-12">{{ item.quantity }}</span>
                                    <button @click="updateQuantity(item.id, item.quantity + 1)" class="px-3 py-1 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-neutral-700 rounded-r-md"><Plus class="w-4 h-4" /></button>
                                </div>
                                <div class="font-bold w-20 text-right text-lg">
                                    ${{ (item.quantity * item.product.price).toFixed(2) }}
                                </div>
                                <button @click="removeItem(item.id)" class="text-red-500 hover:text-red-700 p-2" title="Remove">
                                    <Trash2 class="w-5 h-5" />
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="flex justify-between items-center bg-gray-50 dark:bg-neutral-900 p-6 rounded-lg border">
                    <div>
                        <p class="text-lg text-gray-600 dark:text-gray-400">Total Amount</p>
                        <p class="text-3xl font-bold">${{ total.toFixed(2) }}</p>
                    </div>
                    <button @click="checkout" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
