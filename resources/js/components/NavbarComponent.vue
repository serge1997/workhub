<template>
    <div style="z-index: 2;" class="row m-auto bg-white d-flex justify-content-end">
        <div class="icons d-flex justify-content-end col-md-4">
            <Button @click="showNotifyBox = !showNotifyBox" text class="bg-transparent d-flex gap-0">
                <span>
                    <i class="pi pi-bell"></i>
                </span>
                <Badge class="position-absolute bg-danger" severity="secondary" value="2" />
            </Button>
            <Listbox v-if="showNotifyBox" class="border shadow-sm position-absolute py-4" style="width: 280px;border-radius: 18px;z-index: 999; right: inherit; top: 7%;" :options="notifications" optionLabel="name">
                <template #option="slotProps">
                    <div class="d-flex align-items-center gap-2 border-bottom p-1">
                        <i class="pi pi-circle-fill task-description" :style="{'color': slotProps.option.severity}"></i>
                        <div style="font-size: .8em;" class="task-description">{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Listbox>
            <Button @click="visibleNavBarDialog = !visibleNavBarDialog" text icon="pi pi-th-large" />
            <Button v-if="auth" text icon="pi pi-user">
                <img style="width: 80px;" class="img-thumbnail rounded-circle" :src="`/img/users_avatars/${auth.avatar}`" alt="">
            </Button>
            <Button @click="logOut" text class="text-danger p-0" label="Sair" />
        </div>
        <Dialog v-model:visible="visibleNavBarDialog" header="" :style="{ width: '25rem' }" position="topright" :modal="true" :draggable="false">
            <div class="row">
                <div class="col-md-6 mb-3 d-flex flex-column justify-content-center align-items-center">
                    <Button class="w-50 navbar-dialog-btn rounded-2 fs-4" text icon="pi pi-inbox" />
                    <small class="task-description navbar-dialog-btn-desc">Entrada</small>
                </div>
                <div class="col-md-6 mb-3 d-flex flex-column justify-content-center align-items-center">
                    <CreateFastTaskComponent />
                </div>
                <div class="col-md-6 mb-3 d-flex flex-column justify-content-center align-items-center">
                    <Button class="w-50 navbar-dialog-btn rounded-2 fs-4 text-warning" text icon="pi pi-bolt" />
                    <small class="task-description navbar-dialog-btn-desc">Sprint</small>
                </div>
                <div class="col-md-6 mb-3 d-flex flex-column justify-content-center align-items-center">
                    <CustomColumnComponent />
                </div>
            </div>
        </Dialog>
    </div>
</template>
<script>
import CustomColumnComponent from './CustomColumnComponent.vue';
import CreateFastTaskComponent from './CreateFastTaskComponent.vue';
import { useToast } from 'primevue/usetoast';

export default {
    name: 'NavbarComponent',

    components:{
        CustomColumnComponent,
        CreateFastTaskComponent
    },

    data(){
        return {
            auth: null,
            visibleNavBarDialog: false,
            visibleCustomFiledDialog: false,
            toast: useToast(),
            notifications: [
                {name: "notify one", severity: "#443ab"},
                {name: "notify one", severity: "#443ab"},
            ],
            showNotifyBox: false
        }
    },

    methods: {
        logOut(){
            this.Api.post('logout')
                .then(response => {
                    localStorage.removeItem('token')
                    console.log(response)
                    this.$router.push('/');
                })
                .catch(err => {
                    console.log(err)
                })
        },
       getAuth(){
            this.Api.get('user')
                .then(async response => {
                    this.auth = await response.data;
                })
        },
        wssocket(url){
            const ws = new WebSocket(url);

            ws.onopen = e => console.log("websocket task-notify connected");

            ws.onmessage = async (event) => {
                let obj = JSON.parse(JSON.parse(event.data));
                console.log(obj)
                if (obj.id){
                    this.toast.add({ severity: 'info', icon: '', summary: 'notification', detail: obj.activity, life: 10000 });
                }
            };
            ws.onclose = e => {
                console.log("Websocket closed ");
                setTimeout(() => {
                    this.wssocket(url);
                }, 10000)
            }

            ws.onerror = e => {
                console.log("Websocket close. try new connection in 20s");
                setTimeout(() => {
                    this.wssocket(url);
                }, 20000)
            }
        }
    },
    mounted(){
        this.getAuth();
        this.wssocket("ws://localhost:8155/teste");
    }
}
</script>

<style>
.navbar-dialog-btn {
    border: 1px solid #94a3b8;
}
.navbar-dialog-btn-desc{
    font-weight: 500;
}
</style>
