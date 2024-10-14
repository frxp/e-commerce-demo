import "./bootstrap";
import { createApp } from "vue";
import router from "./router";
import VueGtag from "vue-gtag-next";
import App from "./App.vue";

const app = createApp(App);

app.use(VueGtag, {
    property: {
        id: window.GA_MEASUREMENT_ID,
        params: {
            debug_mode: true,
            send_page_view: false,
        },
    },
});

app.use(router).mount("#app");
