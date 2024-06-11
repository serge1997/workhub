<template>
    <div style="z-index: 2;" class="row m-auto bg-white d-flex justify-content-end">
        <div class="icons d-flex justify-content-end col-md-4">
            <Button text icon="pi pi-th-large" />
            <Button v-if="auth" text icon="pi pi-user">
                <img style="width: 80px;" class="img-thumbnail rounded-circle" :src="`/img/users_avatars/${auth.avatar}`" alt="">
            </Button>
            <Button @click="logOut" text class="text-danger p-0" label="Sair" />
        </div>
    </div>
</template>
<script>
export default {
    name: 'NavbarComponent',

    data(){
        return {
            auth: null,
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
                .then(response => {
                    this.auth = response.data;
                })
        }
    },
    mounted(){
        this.getAuth();
    }
}
</script>
