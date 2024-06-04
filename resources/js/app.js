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
import Dialog from 'primevue/dialog';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';

const app = createApp(App);

app.component('Button', Button);
app.component('Dropdown', Dropdown);
app.component('InputText', InputText);
app.component('SidebarComponent', SidebarComponent);
app.component('Menu', Menu);
app.component('Dialog', Dialog);
app.component('IconField', IconField);
app.component('InputIcon', InputIcon);


app.use(router)
        .use(VueAxios, axios)
            .use(PrimeVue)
                .mount('#app');
