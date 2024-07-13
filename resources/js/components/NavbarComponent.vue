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
                <div class="col-md-6 mb-3">
                    <Button class="w-75 border rounded-2 fs-4" text icon="pi pi-inbox" />
                </div>
                <div class="col-md-6 mb-3">
                    <Button class="w-75 border rounded-2 fs-4 text-danger" text icon="pi pi-book" />
                </div>
                <div class="col-md-6 mb-3">
                    <Button class="w-75 border rounded-2 fs-4 text-warning" text icon="pi pi-bolt" />
                </div>
                <div class="col-md-6 mb-3">
                    <Button @click="visibleCustomFiledDialog = true" class="w-75 border rounded-2 fs-4 task-description" text icon="pi pi-plus-circle" />
                </div>
            </div>
        </Dialog>
        <Dialog v-model:visible="visibleCustomFiledDialog" header="Criar campo personlizado" :style="{ width: '25rem' }" position="topcenter" :modal="true" :draggable="false">
            <div class="row">
                <div class="col-md-12 d-flex flex-column  gap-2">
                    <label for="username" class="font-semibold">Nome do campo</label>
                    <InputText id="username" class="w-100" autocomplete="off" />
                </div>
                <div class="col-md-12 d-flex flex-column  gap-2 mt-3">
                    <label for="costumField-description" class="font-semibold">Descripção do campo</label>
                    <Textarea id="username" class="w-100" autocomplete="off" />
                </div>
                <div class="col-md-12 d-flex justify-content-end mt-3">
                    <Button icon="pi pi-save task-description" text></Button>
                </div>
            </div>
        </Dialog>
    </div>
</template>
<script>
import { Button } from 'bootstrap'

export default {
    name: 'NavbarComponent',

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
