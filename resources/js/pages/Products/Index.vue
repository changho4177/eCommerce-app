<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { ShoppingCart } from 'lucide-vue-next';

const props = defineProps<{
    products: any[];
    filters: { search: string };
}>();

const search = ref(props.filters.search || '');

const searchProducts = () => {
    router.get('/products', { search: search.value }, { preserveState: true, replace: true });
};

const addToCart = (productId: number) => {
    router.post('/cart', { product_id: productId, quantity: 1 }, {
        preserveScroll: true
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="[{ title: 'Catalogue', href: '/products' }]">
        <Head title="Catalogue" />
        
        <div class="px-4 py-6 md:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Catalogue</h1>
                <input 
                    type="text" 
                    v-model="search" 
                    @input="searchProducts" 
                    placeholder="Search products..." 
                    class="border border-neutral-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary w-64"
                />
            </div>

            <div v-if="products.length === 0" class="text-neutral-500">
                No products found.
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div v-for="product in products" :key="product.id" class="border rounded-lg overflow-hidden flex flex-col items-start bg-white dark:bg-neutral-800 shadow-sm">
                    <img :src="product.image_url" :alt="product.name" class="w-full h-48 object-cover" v-if="product.image_url" />
                    <div class="p-4 flex-1 flex flex-col justify-between w-full">
                        <div>
                            <h2 class="text-lg font-semibold">{{ product.name }}</h2>
                            <p class="text-neutral-500 text-sm mt-1 line-clamp-2" :title="product.description">{{ product.description }}</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between w-full">
                            <span class="text-lg font-bold">${{ product.price }}</span>
                            <button @click="addToCart(product.id)" class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition" title="Add to Cart">
                                <ShoppingCart class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
