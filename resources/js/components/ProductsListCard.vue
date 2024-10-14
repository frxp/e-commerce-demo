<script setup>
    import { usePriceConversion } from "../composables/usePriceConversion.js";
    import { ref, watch } from "vue";

    const props = defineProps({
        product: {
            type: Object,
            required: true,
        },
    });

    const isInCart = ref(false);
    const isPurchased = ref(false);

    const emit = defineEmits(['add-to-cart']);

    function addToCart(event) {
        event.stopPropagation();
        isInCart.value = true;
        emit('add-to-cart', props.product);
    }

    watch(
        () => props.product.isPurchased,
        (newVal) => {
            if (newVal) {
                markAsPurchased();
            }
        }
    );

    function markAsPurchased() {
        isInCart.value = false;
        isPurchased.value = true;
    }
</script>

<template>
    <div
        class="flex flex-col items-center rounded-lg bg-white p-4 shadow-md hover:shadow-xl"
        style="width: 200px"
    >
        <h2 class="text-xl font-semibold text-blue-400">
            {{ product.name }}
        </h2>

        <p class="text-gray-700">${{ usePriceConversion(product.price) }}</p>

        <button
            v-if="!isPurchased"
            :disabled="isInCart"
            :class="[
                    'mt-4 rounded p-1 text-white focus:outline-none',
                    isInCart
                        ? 'bg-green-500'
                        : 'bg-orange-400 hover:bg-orange-500',
                ]"
            style="width: 160px"
            @click="addToCart"
        >
            {{ isInCart ? "In cart" : "Add to cart" }}
        </button>

        <button
            v-if="isPurchased"
            class="mt-4 rounded p-1 text-white bg-green-500"
            style="width: 160px"
            disabled
        >
            Purchased
        </button>

        <router-link
            :to="{ name: 'ProductDetails', params: { id: product.id } }"
        >
            <button
                class="mt-2 rounded p-1 text-white bg-blue-400 hover:bg-blue-500"
                style="width: 160px"
            >
                View details
            </button>
        </router-link>
    </div>
</template>
