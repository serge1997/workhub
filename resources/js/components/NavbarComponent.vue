<template>
    <div style="z-index: 2;" class="row m-auto bg-white d-flex justify-content-end">
        <div class="icons d-flex justify-content-end col-md-3">
            <Button text icon="pi pi-th-large" />
            <Button text icon="pi pi-user" />
            <Button @click="logOut" text class="text-danger p-0" label="Sair" />
        </div>
    </div>
</template>
<script>
export default {
    name: 'NavbarComponent',

    methods: {
        logOut(){
            localStorage.removeItem('token')
            this.Api.post('logout')
                .then(response => {

                    console.log(response)
                    this.$router.push('/');
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}
</script>
