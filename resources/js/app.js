import './bootstrap';
import { createApp } from 'vue';
import VueAxios from 'vue-axios';
import App from './App.vue';
import axios from 'axios';
import router from './router/index.js';
import PrimeVue from "primevue/config";
import "primevue/resources/themes/aura-light-blue/theme.css";
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
import Provider from './core/Provider.mjs';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Textarea from 'primevue/textarea';
import Calendar from 'primevue/calendar';
import MultiSelect from 'primevue/multiselect';
import FileUpload from 'primevue/fileupload';
import Tag from 'primevue/tag';
import Toolbar from 'primevue/toolbar';
import Chip from 'primevue/chip';
import AvatarGroup from 'primevue/avatargroup';
import Avatar from 'primevue/avatar';
import ConfirmPopup from 'primevue/confirmpopup';
import Listbox from 'primevue/listbox';
import ConfirmDialog from 'primevue/confirmdialog';
import Toast from 'primevue/toast';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import Badge from 'primevue/badge';
import AutoComplete from 'primevue/autocomplete';
import ColorPicker from 'primevue/colorpicker';
import OverlayPanel from 'primevue/overlaypanel';

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
app.component('AvatarGroup', AvatarGroup);
app.component('Avatar', Avatar);
app.component('ConfirmPopup', ConfirmPopup);
app.component('Listbox', Listbox);
app.component('ConfirmDialog', ConfirmDialog)
app.component('Toast', Toast);
app.component('Badge', Badge)
app.component('AutoComplete', AutoComplete);
app.component('ColorPicker', ColorPicker);
app.component('OverlayPanel', OverlayPanel);




app.use(router)
    .use(VueAxios, axios)
    .use(PrimeVue)
    .use(ConfirmationService)
    .use(ToastService)
    .use(Provider)
    .use(VueSweetalert2)
    .mount('#app');
