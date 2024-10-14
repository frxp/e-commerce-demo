<script setup>
    import { ref, onMounted } from "vue";
    import axios from "axios";
    import ProductsListCard from "../components/ProductsListCard.vue";

    const products = ref([]);
    const cart = ref([]);

    onMounted(async () => {
        try {
            const response = await axios.get("/api/products");
            products.value = response.data;
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    });

    function addToCart(product) {
        const existingProduct = cart.value.find(p => p.id === product.id);
        if (!existingProduct) {
            cart.value.push({ ...product });
        }
    }

    async function purchaseProducts() {
        try {
            const productIds = cart.value.map(item => item.id);

            await axios.post('/api/products/purchase', {
                ids: productIds
            });

            cart.value.forEach(purchasedProduct => {
                const productComponent = products.value.find(p => p.id === purchasedProduct.id);
                if (productComponent) {
                    productComponent.isPurchased = true;
                }
            });

            cart.value = [];
        } catch (error) {
            console.error("Error purchasing products:", error);
        }
    }
</script>

<template>
    <div class="flex min-h-screen flex-row bg-gray-100">
        <div class="flex-1 flex flex-col items-center pb-8">
            <h1 class="my-8 text-3xl font-bold">Products List Page</h1>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div
                    v-for="product in products"
                    :key="product.id"
                >
                    <ProductsListCard
                        :product="product"
                        @add-to-cart="addToCart"
                    />
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center w-1/4 bg-white shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Products Cart</h2>
            <ul>
                <li
                    v-for="item in cart"
                    :key="item.id"
                    class="flex justify-between items-center mb-4"
                >
                    <span class="text-lg font-semibold text-blue-400">
                        {{ item.name }}
                    </span>
                </li>
            </ul>

            <p
                v-if="cart.length === 0"
                class="text-gray-500"
            >
                Cart is empty
            </p>

            <button
                v-if="cart.length > 0"
                class="mt-2 w-full rounded px-4 py-2 bg-green-500 text-white hover:bg-green-600"
                @click="purchaseProducts"
            >
                Purchase
            </button>
        </div>
    </div>
</template>
