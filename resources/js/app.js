import './bootstrap';
import { createApp } from 'vue';
import VueAxios from 'vue-axios';
import App from './App.vue';
import axios from 'axios';
import router from './router/index.js';


const app = createApp(App);

app.use(router)
        .use(VueAxios, axios)
            .mount('#app');
