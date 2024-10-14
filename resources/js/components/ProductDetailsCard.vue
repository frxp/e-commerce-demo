<script setup>
    import { usePriceConversion } from "../composables/usePriceConversion.js";
    import axios from "axios";
    import { onMounted, ref } from "vue";
    import { useRoute } from "vue-router";
    import { useGtag } from "vue-gtag-next";

    const gtag = useGtag();
    const route = useRoute();
    const productId = route.params.id;

    const product = ref(null);
    const isLoading = ref(true);
    const errorMessage = ref("");
    const isPurchased = ref(false);

    onMounted(async () => {
        try {
            const response = await axios.get(`/api/products/${productId}`);
            product.value = response.data;
        } catch (error) {
            if (error.response && error.response.status === 404) {
                errorMessage.value = "Product not found.";
            } else {
                console.error("Error fetching product details:", error);
                errorMessage.value = "Failed to load product details.";
            }
        } finally {
            isLoading.value = false;
        }
    });

    function getClientId() {
        return new Promise((resolve) => {
            gtag.query(
                "get",
                window.GA_MEASUREMENT_ID,
                "client_id",
                (clientID) => {
                    resolve(clientID);
                },
            );
        });
    }

    async function purchaseProduct() {
        try {
            const clientId = await getClientId();

            await axios.post(`/api/products/${productId}/purchase`, {
                client_id: clientId,
            });

            isPurchased.value = true;
            product.value.sales += 1;
        } catch (error) {
            console.error("Error purchasing product:", error);
        }
    }
</script>

<template>
    <div
        class="flex flex-col items-center rounded-lg bg-white p-4 text-center shadow-md"
        style="width: 350px"
    >
        <div
            v-if="isLoading"
            class="mt-8 text-gray-500"
        >
            Loading product details...
        </div>

        <div
            v-else-if="errorMessage"
            class="mt-8 text-red-500"
        >
            {{ errorMessage }}
        </div>

        <div
            v-else
            class="flex flex-col items-center"
        >
            <h2 class="text-xl font-semibold text-blue-400">
                {{ product.name }}
            </h2>

            <p class="text-gray-700">
                ${{ usePriceConversion(product.price) }}
            </p>

            <p class="mt-2 text-gray-600">
                {{ product.description }}
            </p>

            <p class="mt-2 text-gray-600">Sales: {{ product.sales }}</p>

            <button
                :disabled="isPurchased"
                :class="[
                    'mt-4 rounded px-4 py-2 text-white focus:outline-none',
                    isPurchased
                        ? 'bg-green-600'
                        : 'bg-green-500 hover:bg-green-600',
                ]"
                style="width: 320px"
                @click="purchaseProduct"
            >
                {{ isPurchased ? "Purchased" : "Purchase" }}
            </button>
        </div>
    </div>
</template>
