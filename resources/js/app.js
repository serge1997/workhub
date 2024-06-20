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
import NavbarComponent from './components/NavbarComponent.vue';
import Dialog from 'primevue/dialog';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import OwnPlugins from './core/OwnPlugins.mjs';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Textarea from 'primevue/textarea';
import Calendar from 'primevue/calendar';
import MultiSelect from 'primevue/multiselect';
import FileUpload from 'primevue/fileupload';
import Tag from 'primevue/tag';
import Toolbar from 'primevue/toolbar';
import Chip from 'primevue/chip';

function loggedIn(){
    return localStorage.getItem('token');
}
console.log(loggedIn())
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)){
        if (!loggedIn()){
            next({
                path: '/',
                query: {redirect: to.fullPath}
            })
        }else{
            next()
        }
    }else{
        next()
    }
})
const app = createApp(App);

app.component('Button', Button);
app.component('Dropdown', Dropdown);
app.component('InputText', InputText);
app.component('SidebarComponent', SidebarComponent);
app.component('NavbarComponent', NavbarComponent);
app.component('Menu', Menu);
app.component('Dialog', Dialog);
app.component('IconField', IconField);
app.component('InputIcon', InputIcon);
app.component('InputText', InputText);
app.component('Textarea', Textarea);
app.component('Calendar', Calendar);
app.component('MultiSelect', MultiSelect);
app.component('FileUpload', FileUpload);
app.component('Tag', Tag);
app.component('Toolbar', Toolbar);
app.component('Chip', Chip);


app.use(router)
        .use(VueAxios, axios)
            .use(PrimeVue)
                .use(OwnPlugins)
                    .use(VueSweetalert2)
                        .mount('#app');
