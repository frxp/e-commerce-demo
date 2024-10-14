<script setup></script>

<template>
    <div class="flex h-screen flex-col items-center justify-center bg-gray-300">
        <h1 class="text-xl font-bold">404</h1>
        <p class="mb-6 text-xl">Page not found</p>

        <div>
            <router-link :to="{ name: 'Home' }">
                <button class="rounded bg-gray-500 p-4">Go to Home page</button>
            </router-link>
        </div>
    </div>
</template>
