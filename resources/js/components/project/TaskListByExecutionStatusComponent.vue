<template>
    <div class="row">
        <TaskDataTableComponent
            :url="`task-execution-status/list-with-task-count/by-team/${$route.params.id}`"
            header-group-label="Status"
            :header-group-label-has-severity="true"
            global-header-text-color="text-white"
            @selected-task="onSelectedTask"
        />
    </div>
    <div class="col-md-10 m-auto">
        <TaskToolbarComponent
            :tasks-ids="selected_tasks_ids"
        />
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
        TaskDataTableComponent: defineAsyncComponent(() =>
            import('../tasks/TaskDataTableComponent.vue')
        ),
        TaskToolbarComponent: defineAsyncComponent(() =>
            import('./../TaskToolbarComponent.vue')
        )
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
            this.selected_tasks_ids = []
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
        onSelectedTask(id, selectedTarget){
            const toolbar = document.getElementById('task-toolbar');
            if (this.selected_tasks_ids.includes(id)){
                this.selected_tasks_ids.splice(this.selected_tasks_ids.indexOf(id));
            }else{
                this.selected_tasks_ids.push(id);
            }
            if (selectedTarget.length){
                toolbar.classList.remove('d-none')
            }else{
                toolbar.classList.add('d-none')
            }
        },
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
