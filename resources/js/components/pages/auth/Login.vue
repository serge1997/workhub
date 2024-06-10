<template>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0">
                        LOGO
                    </div>
                    <div class="card-body">
                        <small class="text-danger" v-text="invalidResponse"></small>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="text" v-model="auth.email" class="form-control" id="email" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" v-model="auth.password" class="form-control" id="password" placeholder="password">
                        </div>
                    </div>
                    <div class="card-footer border-0">
                        <Button @click="login" class="form-btn" text label="Sign-in" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Login',

        data(){
            return{
                auth:{
                    email: null,
                    password: null
                },
                invalidResponse: null,
            }
        },
        methods: {
            login(){
                this.Api.post('login', this.auth)
                    .then(async response => {
                        localStorage.setItem('token', response.data.token);
                        this.$router.push({name: 'TaskReception'});
                    })
                    .catch(err => {
                        console.log(err.response.data)
                        this.invalidResponse = err.response.data
                    })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
