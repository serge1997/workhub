<template>
    <div class="container-fluid min-vh-100">
    <div class="row min-vh-100">
      <SidebarComponent />
      <div class="col-md-8 border">
        <h3 class="text-center fw-light">Register user</h3>
        <div class="card p-3 mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Nome completo</label>
                    <input type="text" class="form-control" id="email" placeholder="full name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Nome de usuario</label>
                    <input type="text" class="form-control" id="email" placeholder="name@example.com">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control" id="email" placeholder="full name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Password</label>
                    <input type="password" class="form-control" id="email" placeholder="password">
                </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-12 d-flex flex-column">
                    <label for="email" class="form-label">Position</label>
                    <Dropdown :options="positions" optionLabel="name" placeholder="select a position"/>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12 d-flex flex-column">
                    <label for="email" class="form-label">Manager</label>
                    <Dropdown :options="managers" optionLabel="name" placeholder="select a manager"/>
               </div>
            </div>
            <div class="row">
                <div class="col-md-12 p-3 d-flex justify-content-end">
                    <Button class="form-btn" text label="Salvar" />
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>
</template>
<script>
import SidebarComponent from './../../SidebarComponent.vue';
export default {
    name: 'Register',

    components: {
        SidebarComponent
    },
    data(){
        return {
            managers: [
                {name: "Serge Gogo"},
                {name: "Paulo "}
            ],
            positions: [
                {name: "Developer"},
                {name: "Project manager"}
            ]
        }
    }
}
</script>
<style>
.form-label{
    color: #475569;
}
</style>
