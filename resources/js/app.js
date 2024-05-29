import './bootstrap';
import { createApp } from 'vue';
import VueAxios from 'vue-axios';
import App from './App.vue';
import axios from 'axios';
import router from './router/index.js';
import PrimeVue from "primevue/config";
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primeicons/primeicons.css'
import Button from 'primevue/button';

const app = createApp(App);

app.component('Button', Button);


app.use(router)
        .use(VueAxios, axios)
            .mount('#app');
