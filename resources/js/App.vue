<template>
    <div>
        <router-view v-slot="{ Component }">
            <Transition name="transition-router">
                <component :is="Component"></component>
            </Transition>
        </router-view>
        <Toast />
    </div>
</template>
<script>
import { prioritySeverity, taskStatusSeverity } from './core/utilities.mjs';

export default {
    data(){
        return {

        }
    },
    provide(){
        return{
            taskSeverity: taskStatusSeverity,
            taskPrioritySeverity: prioritySeverity
        }
    },
    mounted(){
        //localStorage.removeItem('token');
    }
}
</script>
<style>
body {
    background-color: #f8fafc;
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
.small-fw{
    font-size: 0.9em;
}
.small-icon{
    font-size: 0.7em;
}
.v-small-fs {
    font-size: .7em;
}
.cursor-p {
    cursor: pointer;
}
.transition-router-leave-from{
    opacity: 0;
    transition: opacity 0.5s;
}
.transition-router-leave-to{
    opacity: 0;
    transition: opacity 0.5s;
}
.btn-text-nowrap{
    white-space: nowrap;
}
</style>
