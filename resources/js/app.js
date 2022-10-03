import './bootstrap';
import 'ant-design-vue/dist/antd.css';

import { createApp } from "vue/dist/vue.esm-bundler";
import Welcome from "./Welcome.vue"
import Products from "./Products/Products.vue"
import Categories from "./Categories/Categories.vue"
import Antd from "ant-design-vue";

const app = createApp({
    components: {
        'welcome': Welcome,
        'products': Products,
        'categories': Categories
    }
})

app.use(Antd).mount("#app");
