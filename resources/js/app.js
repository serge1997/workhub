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
import Dropdown from 'primevue/dropdown';
import InputText from 'primevue/inputtext';
import Menu from 'primevue/menu';
import SidebarComponent from './components/SidebarComponent.vue';

const app = createApp(App);

app.component('Button', Button);
app.component('Dropdown', Dropdown);
app.component('InputText', InputText);
app.component('SidebarComponent', SidebarComponent);
app.component('Menu', Menu);


app.use(router)
        .use(VueAxios, axios)
            .use(PrimeVue)
                .mount('#app');
