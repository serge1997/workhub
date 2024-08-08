<template>
    <SidebarComponent>
        <div class="row">
            <div class="col-md-10 mt-3 m-auto p-0">
                <div class="row w-100 p-0 m-auto">
                    <Toolbar class="p-0">
                        <template #start>
                            <div class="w-100 d-flex">
                                <Button @click="componentIs = 'CardTaskComponent'" icon="pi pi-th-large" text/>
                                <Button @click="componentIs = 'ListTaskComponent'" icon="pi pi-list" text />
                            </div>
                        </template>
                    </Toolbar>
                </div>
                <div class="w-100 d-flex gap-4" style="overflow-x: scroll;">
                    <div v-for="status in task_status" class="w-75 mt-3">
                        <div style="height: 600px; min-width: 360px; overflow: scroll;">
                            <div class="card w-100">
                                <div class="card-header border-0 bg-white">
                                    <Tag class="w-100" :style="{'background-color': executionStatusBg(status.status)}" :value="status.name" />
                                </div>
                                <div class="card-body mt-4">
                                    <keep-alive>
                                        <component
                                            :tasks="tasks"
                                            :show-status="status.status"
                                            :is="componentIs"
                                            @confirm-delete="confirmDelete"
                                            @list-all-task="onListAllTask"
                                            :task-status="taskStatus"
                                            :task-execution-status="task_status">
                                        </component>
                                    </keep-alive>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row mt-3">
                    <div style="height: 600px; overflow: scroll;" class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-white">
                                <Tag class="w-100" value="Fila Tarefa" severity="warning" />
                            </div>
                            <div class="card-body mt-4">
                                <keep-alive>
                                    <component
                                        :tasks-wait="tasksWait"
                                        show-status="WAT"
                                        :is="componentIs"
                                        @confirm-delete="confirmDelete"
                                        :task-execution-status="task_status">
                                    </component>
                                </keep-alive>
                            </div>
                        </div>
                    </div>
                    <div style="height: 600px; overflow: scroll;" class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-transparent">
                                <Tag class="w-100" value="In Progress" severity="primary" />
                            </div>
                            <div class="card-body mt-4">
                                <keep-alive>
                                    <component
                                        :tasks-progress="tasksProgress"
                                        show-status="PRO"
                                        :is="componentIs"
                                        @confirm-delete="confirmDelete"
                                        :task-execution-status="task_status">
                                    </component>
                                </keep-alive>
                            </div>
                        </div>
                    </div>
                    <div style="height: 600px; overflow: scroll;" class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-transparent">
                                <Tag class="w-100" value="Concluido" severity="success" />
                            </div>
                            <div class="card-body mt-4">
                                <keep-alive>
                                    <component
                                        show-status="CON"
                                        :tasks-concluded="tasksConcluded"
                                        :is="componentIs"
                                        @confirm-delete="confirmDelete"
                                        :task-execution-status="task_status">
                                    </component>
                                </keep-alive>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <ConfirmDialog />
            <Toast />
        </div>
    </SidebarComponent>
</template>
<script>
import ListTaskComponent from './../../tasks/ListTaskComponent.vue';
import CardTaskComponent from './../../tasks/CardTaskComponent.vue';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
export default{
    name: 'Sprint',

    components: {
        ListTaskComponent,
        CardTaskComponent
    },
    data(){
        return{
            task: {
                progress: null,
                waiting: null,
                concluded: null,
            },
            componentIs: 'CardTaskComponent',
            conf: useConfirm(),
            toast: useToast(),
            tasks: null,
            tasksProgress: null,
            tasksWait: null,
            tasksConcluded: null,
            task_status: null,
            taskStatus: null
        }
    },
    methods: {
        onListAllTask(){
            this.Api.get('tasks')
            .then(async response => {
                this.tasks = await response.data;
                this.tasksWait = await response.data.filter(task => task.execution_status === 'WAT');
                this.tasksProgress = await response.data.filter(task => task.execution_status === 'PRO');
                this.tasksConcluded = await response.data.filter(task => task.execution_status === 'CON');
                console.log(response)
            })
            .catch(err => {
                console.log(err)
            })
        },
        onListAllTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.task_status = await response.data;
                this.taskStatus = await response.data;
            })
            .catch(err => {
                console.log(err);
            })
        },
        confirmDelete(id){
            this.conf.require({
                message: 'Você quer deletar essa task?',
                header: 'Aviso',
                icon: 'pi pi-exclamation-triangle',
                rejectProps: {
                    label: 'Cancel',
                    severity: 'secondary',
                    outlined: true
                },
                acceptProps: {
                    label: 'Save'
                },
                accept: () => {

                    this.deleteTask(id);
                },
                reject: () => {
                    this.toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
                }
            });
        },
        deleteTask(id){
            this.Api.delete('task', {task_id: id})
            .then(async response => {
                this.toast.add({ severity: 'info', summary: 'Message', detail: response.data, life: 3000 });
                this.onListAllTask()
            })
            .catch(erro => {
                console.log(erro);
            })
        },
        executionStatusBg(status){
            switch(status){
                case "WAT" :
                    return "#7c3aed"
                case "PRO" :
                    return "#0ea5e9"
                case "CDR" :
                    return "#9333ea"
                case "CON" :
                    return "#10b981"
                case "TST" :
                    return "#f59e0b"
                case "BKL" :
                    return "#94a3b8"
                case "PRQ" :
                    return "#e11d48"
                default : "#333"
            }
        },
        handleTaskStatus(data){
            console.log(data);
        },
    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
        this.onListAllTask();
        this.onListAllTaskExecutionStatus()

    }
}

</script>
