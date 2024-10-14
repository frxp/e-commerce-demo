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

export default createRouter({
    history: createWebHistory(),
    routes,
});
