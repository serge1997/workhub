<template>
    <div>
        <router-view></router-view>
    </div>
</template>
<script>
export default {

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
</style>
