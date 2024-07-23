<template>
    <div style="z-index: 2;" class="row m-auto bg-white d-flex justify-content-end">
        <div class="icons d-flex justify-content-end col-md-4">
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
import CustomColumnComponent from './CustomColumnComponent.vue'
import CreateFastTaskComponent from './CreateFastTaskComponent.vue'
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
        }
    },
    mounted(){
        this.getAuth();
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
