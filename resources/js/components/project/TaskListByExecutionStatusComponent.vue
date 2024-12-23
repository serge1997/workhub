<template>
    <div class="row">
        <div class="col-md-12 d-flex flex-column gap-3">
            <div v-for="(status, index) of task_status_by_project" class="w-100 d-flex flex-column gap-2">
                <div class="w-100 d-flex gap-3">
                    <Button text class="p-1 task-description btn-list-task-by-project" @click="listTaskByExecutionStatus(status.id, index, true)">
                        <span><i :class="`pi ${toggleIcon}`" :id="`icon_toggle_${status.id}`"></i></span>
                    </Button>
                    <Tag style="width: 100px;" class="p-2 sprint-list-tag text-white btn-text-nowrap" :style="{'background-color': setStatusColor(status.status)}">
                        <span>{{ status.name_ucfirst }}</span>
                    </Tag>
                    <span style="width: 15px;" class="d-flex align-items-center">
                        <Tag :value="status.task_count" class="px-2" severity="secondary" />
                    </span>
                    <Button text class="p-1 task-description">
                        <span><i class="pi pi-ellipsis-h"></i></span>
                    </Button>
                </div>
                <div class="row d-none" :id="`box_list_task_${status.id}`">
                    <TaskListComponent
                        :tasks="tasks[index]"
                        @update-ui="listTaskByExecutionStatus(status.id, index, false)"
                        :task-status="taskStatus"
                        @on-selected-task="onSelectedTask"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useToast } from 'primevue/usetoast';
import { defineAsyncComponent } from 'vue';
import { statusColor } from '../../core/utilities.mjs';
export default {
    name: 'TaskListByExecutionStatusComponent',

    components: {
        TaskListComponent: defineAsyncComponent(() =>
            import('./TaskListComponent.vue')
        ),
    },
    props: {
        byId: Number,
        taskStatus: Object,
        statusApiUrl: String,
        taskApiUrl: String
    },
    watch:{
        '$route.params.id'(n, old){
            this.task_status_by_project = null;
            this.listAllTaskExecution();
        }
    },
    data() {
        return {
            toast: useToast(),
            tasks: [],
            toggleIcon: 'pi-angle-right',
            selected_tasks_ids: [],
            setStatusColor: statusColor,
            task_status_by_project: []
        }
    },
    methods: {
        listAllTaskExecution(){
            this.Api.get(this.statusApiUrl + this.byId)
            .then(async response => {
                this.task_status_by_project = await response.data.data;
            })
            .catch(err => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded task status data", life: 3000 });
            })
        },
        listTaskByExecutionStatus(status, index){
            let spanIcon = document.getElementById(`icon_toggle_${status}`);
            //this.Api.get(`task/list-by-project/${this.byId}/status/${status}`)
            this.Api.get(this.taskApiUrl + status)
            .then(async response => {
                this.tasks[index] = await response.data.data;
                console.log(this.tasks[index])
                document.getElementById(`box_list_task_${status}`).classList.toggle('d-none')
                if (spanIcon.classList.contains('pi-angle-right')){
                    spanIcon.classList.remove('pi-angle-right')
                    spanIcon.classList.add('pi-angle-down')
                }else{
                    spanIcon.classList.remove('pi-angle-down')
                    spanIcon.classList.add('pi-angle-right')
                }
            })
        }
    },
    mounted(){
        this.listAllTaskExecution();
        const tooggleFirstTaskListInterval = setInterval(() => {
            const btnListTask = document.querySelector('.btn-list-task-by-project');
            if (btnListTask){
                btnListTask.click();
                clearInterval(tooggleFirstTaskListInterval);
            }
       }, 200)
    }
}
</script>
<style scoped>
</style>
