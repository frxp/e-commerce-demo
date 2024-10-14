<script setup>
    import { onMounted } from "vue";
    import { useRouter } from "vue-router";
    import { useGtag } from "vue-gtag-next";
    import ProductDetailsCard from "../components/ProductDetailsCard.vue";

    const router = useRouter();
    const gtag = useGtag();

    onMounted(() => {
        gtag.pageview({
            page_path: router.currentRoute.value.fullPath,
            page_title: "Product Details",
        });
    });
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
