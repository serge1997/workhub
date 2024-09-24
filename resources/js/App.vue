<template>
    <div>
        <router-view></router-view>
        <Toast />
    </div>
</template>
<script>
export default {
    data(){
        return {

        }
    },
    provide(){
        return{
            messagep: "from provide"
        }
    },
    mounted(){
        //localStorage.removeItem('token');
    }
}
</script>
<style>
body {
    background-color: #f1f5f9;
}
.form-btn {
    background-color: #1e293b;
    color: #f1f5f9;
}
.swal2-container.swal2-backdrop-show,.swal2-container.swal2-noanimation{z-index:11000}

.task-description {
    color: #64748b;
}

.btn-icon-show-task{
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}
</style>
