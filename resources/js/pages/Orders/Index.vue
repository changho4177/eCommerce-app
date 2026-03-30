<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Package } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

defineProps<{
    orders: any[];
}>();

</script>

<template>
    <AppLayout :breadcrumbs="[{ title: 'Orders', href: '/orders' }]">
        <Head title="My Orders" />
        
        <div class="px-4 py-6 md:px-8">
            <h1 class="text-2xl font-bold mb-6">Order History</h1>

            <div v-if="orders.length === 0" class="flex items-center justify-center min-h-[50vh] text-neutral-200 dark:text-neutral-800 text-4xl font-bold select-none">
                You have no orders yet.
            </div>

            <div v-else class="space-y-6">
                <div v-for="order in orders" :key="order.id" class="border rounded-lg bg-white dark:bg-neutral-800 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 dark:bg-neutral-900 px-6 py-4 border-b flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Order #{{ order.id }}</p>
                            <p class="font-semibold text-lg">{{ new Date(order.created_at).toLocaleDateString() }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-xl">${{ order.total_amount }}</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-semibold mb-4 flex items-center gap-2"><Package class="w-5 h-5"/> Items</h4>
                        <ul class="divide-y">
                            <li v-for="item in order.items" :key="item.id" class="py-3 flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <img :src="item?.product?.image_url" :alt="item?.product?.name" class="w-12 h-12 rounded object-cover" v-if="item?.product?.image_url" />
                                    <div>
                                        <p class="font-medium">{{ item?.product?.name || 'Unknown Product' }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ item.quantity }} x ${{ item.price }}</p>
                                    </div>
                                </div>
                                <div class="font-semibold">
                                    ${{ (item.quantity * item.price).toFixed(2) }}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
