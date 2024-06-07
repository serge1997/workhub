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
                            <label for="email" class="form-label">Position</label>
                            <Dropdown :options="positions" v-model="user.position_id" optionLabel="name" placeholder="select a position"/>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 d-flex flex-column">
                        <label for="email" class="form-label">Manager</label>
                        <Dropdown :options="managers" v-model="user.manager_id" optionLabel="name" placeholder="select a manager"/>
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
import { Container } from './../../../core/Container.js';
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
            user: {},
            container: Container.app(),
            formErrorBag: null,
            invalidInpuClass: null,
        }
    },
    //Dev: Serge Gogo
    methods: {
        onCreate(e){
           try {
            e.preventDefault();
            Reflect.setPrototypeOf(this.user, this.container.getInstance('User'));
            this.user.create('user')
                .then(response => {
                    console.log(response)
                })
                .catch(error =>{
                    this.formErrorBag = error;
                    this.invalidInpuClass = 'border-danger'
                })
           }catch(error) {
            console.error(error.message)
           }
        }
    },

    mounted(){


    }
}
</script>
<style>
.form-label{
    color: #475569;
}
</style>
