<template>
    <div style="z-index: 2;" class="row m-auto bg-white d-flex justify-content-end">
        <div class="icons d-flex justify-content-end col-md-4">
            <Button @click="showNotifyBox = !showNotifyBox" text class="bg-transparent gap-0 w-25">
                <span>
                    <i class="pi pi-bell"></i>
                </span>
                <Badge class="position-absolute bg-danger" severity="secondary" :value="notification.count" />
            </Button>
            <Listbox @change="showTask" v-if="showNotifyBox" v-model="notificationSelected" class="border shadow-sm notification-list-box overflow-scroll position-absolute py-4" :options="notification.contents" optionLabel="name">
                <template #option="slotProps">
                    <div class="d-flex align-items-center gap-2 border-bottom p-1">
                        <i class="pi pi-bell task-description" style="font-size: 0.7em;" :style="{'color': slotProps.option.severity}"></i>
                        <div style="font-size: .8em;" class="task-description">{{ slotProps.option.notification }}...</div>
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
                    <Button @click="visibleFastTaskDialog = true" class="w-50 navbar-dialog-btn rounded-2 fs-4 text-danger" text icon="pi pi pi-book" />
                    <span><small class="task-description navbar-dialog-btn-desc">Tarefa</small></span>
                    <Dialog v-model:visible="visibleFastTaskDialog" header="Criar tarefa rapido" :style="{ width: '65rem' }" position="topcenter" :modal="true" :draggable="false">
                        <CreateFastTaskComponent />
                    </Dialog>
                </div>
                <div class="col-md-6 mb-3 d-flex flex-column justify-content-center align-items-center">
                    <CreateSprintModalComponent />
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
import CreateSprintModalComponent from './CreateSprintModalComponent.vue';

export default {
    name: 'NavbarComponent',
    emits: ['watchRouteParams'],

    components:{
        CustomColumnComponent,
        CreateFastTaskComponent,
        CreateSprintModalComponent
    },

    data(){
        return {
            auth: null,
            visibleNavBarDialog: false,
            visibleCustomFiledDialog: false,
            toast: useToast(),
            notification: {
                count: null,
                contents: null
            },
            notificationSelected: null,
            showNotifyBox: false,
            visibleFastTaskDialog: false
        }
    },

    methods: {
        logOut(){
            this.Api.post('logout')
                .then(response => {
                    this.Auth.logout();
                    this.$router.push('/');
                })
                .catch(err => {
                    console.log(err)
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
                    this.listNotificationByTaskExecutor()
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
        },
        async listNotificationByTaskExecutor(){
            this.Api.get('task-activity/by-task-executor')
            .then(async response => {
                this.notification.contents = await response.data
                this.notification.count = this.notification.contents.length;
            })
            .catch(e => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded notification data", life: 3000 });
            })
        },
        async showTask(){
            if (this.notificationSelected != null){
                let type = this.notificationSelected.description.toLowerCase().split(' ').join('-');
                let origin_id = this.notificationSelected.origin_id ?? "none";
                await this.listNotificationByTaskExecutor()
                await this.markReadedNotification(this.notificationSelected)
                this.$router.push(`/task-show/${origin_id}/${type}/${this.notificationSelected.task_id}`)
                return this.$emit('watchRouteParams')
            }
        },
        async markReadedNotification(data){
            this.Api.put('task-activity/readed', {task_activity_id: data.id})

        }
    },
    created(){
        this.auth = this.Auth.user();
    },
    mounted(){
        this.wssocket("ws://localhost:8155/teste");
        this.listNotificationByTaskExecutor();
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
.notification-list-box{
    width: 290px;
    height: 600px;
    border-radius: 18px;
    z-index: 999;
    right: inherit;
    top: 7%;
}
</style>
