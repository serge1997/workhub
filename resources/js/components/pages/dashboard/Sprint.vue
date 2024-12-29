<template>
    <SidebarComponent @reload-sprint-taks="onListAllTask">
        <div class="row">
            <div class="col-md-10 mt-3 m-auto p-0">
                <div class="row w-100 p-0 m-auto">
                    <Toolbar class="p-1 bg-transparent rounded-0 border-0 border-bottom">
                        <template #start>
                            <div class="w-100 d-flex align-items-center">
                                <Button @click="componentIs = 'CardTaskComponent'" text>
                                    <i class="pi pi-th-large task-description small-fw"></i>
                                </Button>
                                <Button @click="componentIs = 'ListTaskComponent'" icon="pi pi-list" text>
                                    <i class="pi pi-list task-description small-fw"></i>
                                </Button>
                                <Button :label="currentSprintName" class="task-description text-capitalize small-fw" text />
                            </div>
                        </template>
                        <template #center>
                            <div class="w-100 d-flex gap-2">
                                <div v-for="meter in sprints_meters" class="card border-0 p-0 bg-transparent">
                                    <div class="card-body-p-0 d-flex align-items-center gap-1 bg-transparent">
                                        <i :style="`color: ${meter.color};`" class="v-small-fs pi pi-circle-fill"></i>
                                        <small class="v-small-fs task-description">{{ meter.label }} ({{ meter.value }})</small>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template #end>
                            <div class="w-100 d-flex d-none d-sm-inline">
                                <AutoComplete @change="getUserTask" v-model="user_filtered" optionLabel="name" placeholder="digit a user name..." :suggestions="users_filter" @complete="onListAllUsers">
                                    <template #option="slotProps">
                                        <div class="d-flex gap-1 w-50">
                                            <img style="width: 28px;" :alt="slotProps.option.name" :src="`/img/users_avatars/${slotProps.option.avatar}`" />
                                            <div>{{ slotProps.option.name }}</div>
                                        </div>
                                    </template>
                                </AutoComplete>
                            </div>
                        </template>
                    </Toolbar>
                </div>
                <div class="w-100 d-flex gap-4 vh-100" style="overflow: scroll;">
                    <div v-for="status in task_status_by_sprint" class="w-100 mt-3 vh-100">
                        <div v-if="status.status != 'BKL'" style="min-width: 360px; overflow: scroll;">
                            <div class="card w-100">
                                <div class="card-header border-0 bg-white">
                                    <Tag class="w-100 d-flex gap-2 bg-transparent shadow-sm rounded-2" :style="`border-top: 3px solid ${executionStatusBg(status.status)}; color: #374151;`">
                                        <span>{{ status.name_ucfirst }}</span>
                                        <span>
                                            <Badge severity="secondary" :value="status.task_count"/>
                                        </span>
                                    </Tag>
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
    watch: {
        '$route.params.id'(n, old){
            this.listTaskExecutionStatusBySprint();
            this.onListAllTask();
        }
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
            taskStatus: null,
            users_filter: null,
            user_filtered: null,
            currentSprintName: null,
            task_status_by_sprint: null,
            router_id: this.$route.params,
            sprints_meters: []
        }
    },
    methods: {
        listSprintConcludedNotMeter(){
            this.Api.get("bi/list-concluded-not/by-sprint/"+ this.$route.params.id)
            .then(async response => {
                this.sprints_meters = await response.data.data;
            })
        },
        listTaskExecutionStatusBySprint(){
            this.Api.get(`task-execution-status/list-task-quantity-by-sprint/${this.$route.params.id}`)
            .then(async response => {
                this.task_status_by_sprint = await response.data.data;
            })
            .catch(error => {

            })
        },
        onListAllTask(){
            let pathname = location.pathname;
            this.currentSprintName = pathname.replaceAll(/\W|dashboard/g, ' ');
            this.Api.get('tasks/by-sprint', {sprint_id: this.$route.params.id})
            .then(async response => {
                this.tasks = await response.data;
                this.listSprintConcludedNotMeter();
            })
            .catch(err => {
                console.log(err)
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded tasks data", life: 3000 });
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
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded task status data", life: 3000 });
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
                case "BLOCK":
                    return "#e11d48";
                default : return "#333"
            }
        },
        handleTaskStatus(data){
            console.log(data);
        },
        onListAllUsers(){
            this.Api.get('users')
            .then(async (response) => {
                this.users_filter = await response.data;
            })
            .catch(err => console.log(err))
        },
        getUserTask(){
            console.log(this.user_filtered);
            this.Api.get('task-by-filtered-user', {user_id: this.user_filtered.id})
            .then(async response => {
                this.tasks = await response.data
            })
            .catch(err => console.log(err))
        }
    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
        this.onListAllTask();
        this.onListAllTaskExecutionStatus();
        this.listTaskExecutionStatusBySprint();
    }
}

</script>
