import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "ProductList",
        component: () => import("./Pages/ProductListPage.vue"),
    },
    {
        path: "/product/:id",
        name: "ProductDetails",
        component: () => import("./Pages/ProductDetailsPage.vue"),
        props: true,
    },
    {
        path: "/:catchAll(.*)*",
        name: "NotFound",
        component: () => import("./Pages/NotFoundPage.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
