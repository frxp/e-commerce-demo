<script setup>
    import { useRouter } from "vue-router";
    import ProductDetailsCard from "../components/ProductDetailsCard.vue";

    const router = useRouter();
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pb-8">
        <h1 class="my-8 text-3xl font-bold">Product Details Page</h1>

        <ProductDetailsCard />

        <button
            class="mt-8 text-blue-500 hover:underline focus:outline-none"
            @click="router.push({ name: 'ProductList' })"
        >
            &larr; Back to Products List
        </button>
    </div>
</template>
