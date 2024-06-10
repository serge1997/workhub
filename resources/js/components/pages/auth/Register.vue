<template>
    <SidebarComponent>
        <div class="row m-auto min-vh-100 position-relative">
            <div class="col-md-8 border m-auto">
                <h3 class="text-center fw-light">Register user</h3>
                <div class="card p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Nome completo</label>
                            <input v-model="user.name" type="text" :class="invalidInpuClass" class="form-control" id="email" placeholder="full name">
                            <small class="text-danger" v-if="formErrorBag && 'name' in formErrorBag" v-text="`*${formErrorBag.name}`"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Nome de usuario</label>
                            <input type="text" v-model="user.username" :class="invalidInpuClass" class="form-control" id="email" placeholder="username">
                            <small class="text-danger" v-if="formErrorBag && 'username' in formErrorBag" v-text="`*${formErrorBag.username}`"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="text" v-model="user.email" :class="invalidInpuClass" class="form-control" id="email" placeholder="name@example.com">
                            <small class="text-danger" v-if="formErrorBag && 'email' in formErrorBag" v-text="`*${formErrorBag.email}`"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Password</label>
                            <input type="password" v-model="user.password" :class="invalidInpuClass" class="form-control" id="email" placeholder="password">
                            <small class="text-danger" v-if="formErrorBag && 'password' in formErrorBag" v-text="`*${formErrorBag.password}`"></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 d-flex flex-column">
                            <label for="email" class="form-label">Departamento</label>
                            <Dropdown :options="departments" v-model="user.department_id" optionValue="id" optionLabel="name" placeholder="select a position"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 d-flex flex-column">
                            <label for="email" class="form-label">User role</label>
                            <Dropdown :options="userType" v-model="user.user_type" optionValue="enum" optionLabel="label" placeholder="select a position"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 d-flex flex-column">
                            <label for="email" class="form-label">Position</label>
                            <Dropdown :options="positions" v-model="user.position_id" optionValue="id" optionLabel="name" placeholder="select a position"/>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 d-flex flex-column">
                        <label for="email" class="form-label">Manager</label>
                        <Dropdown :options="managers" v-model="user.manager_id" optionValue="id" optionLabel="name" placeholder="select a manager"/>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 p-3 d-flex justify-content-end">
                            <Button @click="onCreate" class="form-btn" text label="Salvar" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <h6>right sidebar</h6>
            </div>
        </div>
 </SidebarComponent>
</template>
<script>
import SidebarComponent from './../../SidebarComponent.vue';
import { User } from '../../../main/user.js';
export default {
    name: 'Register',
    data(){
        return {
            managers: [
                {name: "Serge Gogo"},
                {name: "Paulo "}
            ],
            positions: [
                {name: "Developer"},
                {name: "Project manager"}
            ],
            userType: [
                {enum: 'ADM', label: 'Manager'},
                {enum: 'USR', label: 'Colaborador'}
            ],
            user: {
                name: null,
                email: null,
                username: null,
                password: null,
                position_id: null,
                department_id: null,
                manager_id: null,
                user_type: null
            },
            formErrorBag: null,
            invalidInpuClass: null,
            departments: null,
            positions: null,
        }
    },
    //Dev: Serge Gogo
    methods: {
        onCreate(e){
           try {
            e.preventDefault();
            this.Api.post('user', this.user)
                .then(response => {
                    console.log(response)
                    this.toaster(response.data).fire();
                    this.invalidInpuClass = null
                    this.user = {}
                })
                .catch(error =>{
                    this.formErrorBag = error.response.data.errors;
                    this.invalidInpuClass = 'border-danger'
                })
           }catch(error) {
            console.error(error.message)
           }
        },
        onListAllPositions(){
            this.Api.get('positions')
                .then(async response => {
                        this.positions = await response.data;
                    })
                .catch(err => console.log(err));
        },
        onListAllDepartments(){
            this.Api.get('departments')
                .then(async response => {
                    this.departments = await response.data;
                })
                .catch(error => console.log(error));
        },
        toaster(response){
            const Toast = this.$swal.mixin({
                text: response,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                icon: "success",
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            return Toast
        },

    },

    mounted(){
        this.onListAllPositions();
        this.onListAllDepartments()
        // //Container.app();
        // console.log(this.$Api.get('url'));
        // console.log(this.$App.getInstance('User'));

    }
}
</script>
<style>
.form-label{
    color: #475569;
}
</style>
