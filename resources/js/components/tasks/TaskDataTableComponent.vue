<template>
    <div class="col-md-12 m-auto">
        <DataTable v-model:expandedRows="expandedRow" :value="datas"  @rowExpand="onRowExpand">
            <Column style="width: 3rem"  expander />
            <Column class="border-bottom">
                <template #header>
                    <small class="task-description p-2 w-100 fw-normal">{{ headerGroupLabel }}</small>
                </template>
                    <template #body="{data}">
                        <Tag v-if="headerGroupLabelHasSeverity" :style="{'background-color': data.severity}">
                            <Chip v-if="isByUsers" class="bg-transparent" :image="`/img/users_avatars/${data.avatar}`"/>
                            <span :class="globalHeaderTextColor">{{ data.name }}</span>
                        </Tag>
                        <Tag v-else severity="secondary">
                            <Chip v-if="isByUsers" class="bg-transparent" :image="`/img/users_avatars/${data.avatar}`"/>
                            <span :class="globalHeaderTextColor">{{ data.name }}</span>
                        </Tag>
                    </template>
            </Column>
            <Column class="border-bottom">
                <template #header>
                    <small class="p-2 w-100 task-description fw-normal">Total tarefas atribuidas</small>
                </template>
                <template #body="{data}">
                    <Tag severity="secondary" :value="data.task_total" />
                </template>
            </Column>
            <Column class="border-bottom" v-if="hasConcludedColumn">
                <template #header>
                     <small class="p-2 w-100 task-description fw-normal">Concluidos</small>
                </template>
                    <template #body="{data}">
                        <Tag v-if="data.task_concluded" severity="success" :value="data.task_concluded" />
                        <Tag v-else severity="secondary" value="-" />
                    </template>
            </Column>
            <Column class="border-bottom">
                <template #header>
                    <small class="p-2 w-100 task-description fw-normal">Horas accumuladas</small>
                </template>
            </Column>
            <template #expansion="slotProps">
                <small class="task-description">tarefas para <strong>{{ slotProps.data.name }}</strong></small>
                <DataTable :value="slotProps.data.tasks">
                    <Column class="border-bottom">
                        <template #header>
                            <small class="fw-normal task-description">Tarefas</small>
                        </template>
                        <template #body="{data}">
                            <span class="d-flex gap-1">
                                <Button text class="d-none">
                                    <i class="pi pi-circle task-description"></i>
                                </Button>
                                <TaskActionMenuComponent
                                    :task-status="task_status"
                                    :users="members"
                                    :task="data"
                                    @update-priority="updatePriority"
                                    @update-task-status="updateTaskStatus"
                                    @update-task-user="updateTaskUser"
                                    @on-selected-task="onSelectedTask"
                                />
                                <router-link class="text-decoration-none gray-pure p-2 w-100" :to="`/task-show/${data.id}/task/${data.id}`">
                                   <small> {{ data.short_title }}</small>
                                </router-link>
                            </span>
                        </template>
                    </Column>
                    <Column class="border-bottom">
                        <template #header>
                            <small class="fw-normal task-description">Prioridade</small>
                        </template>
                        <template #body="{ data }">
                            <div class="d-flex gap-1 align-items-center">
                                <span v-if="data.priority_fullDescription">
                                    <i :class="`text-${taskPrioritySeverity(data.priority)}`" class="pi pi-flag-fill small-icon"></i>
                                </span>
                                <span v-if="data.priority_fullDescription">
                                   <small> {{ data.priority_fullDescription }}</small>
                                </span>
                                <span v-else>-</span>
                            </div>
                        </template>
                    </Column>
                    <Column class="border-bottom">
                        <template #header>
                            <small class="fw-normal task-description">Status</small>
                        </template>
                        <template #body="{data}">
                            <div class="d-flex gap-1">
                                <span>
                                    <i :style="`color: ${data.execution_status_severity}`" class="pi pi-circle-fill small-icon"></i>
                                </span>
                                <span>
                                    <small>{{ data.full_task_execution_status }}</small>
                                </span>
                            </div>
                        </template>
                    </Column>
                    <Column class="border-bottom">
                        <template #header="data">
                            <small class="fw-normal task-description">Sprint</small>
                        </template>
                        <template #body="{ data }">
                            <div>
                                <small>{{ data.sprint_name }}</small>
                            </div>
                        </template>
                    </Column>
                    <Column class="border-bottom">
                        <template #header="data">
                            <small class="fw-normal task-description">Projeto</small>
                        </template>
                        <template #body="{data}">
                            <div class="d-flex gap-1">
                                <span>
                                    <i class="pi pi-tags small-icon" :style="`color: #${data.project_severity}`"></i>
                                </span>
                                <span>
                                    <small>{{ data.project_name}}</small>
                                </span>
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </DataTable>
    </div>
</template>
<script>
import TaskActionMenuComponent from '../Menus/TaskActionMenuComponent.vue';
import { statusColor } from '../../core/utilities.mjs';
export default {
    name: 'TeamMembersComponent',
    inject: ['taskPrioritySeverity'],

    watch:{
        '$route.params.id'(n, old){
            this.getData();
        }
    },
    components: {
        TaskActionMenuComponent
    },
    props: {
        url: String,
        taskData: Object,
        isByUsers: Boolean,
        headerGroupLabel: String,
        headerGroupLabelHasSeverity: Boolean,
        hasConcludedColumn: Boolean,
        globalHeaderTextColor: String
    },

    data(){
        return{
            datas: [],
            expandedRow: null,
            task_status: [],
            members: [],
            setStatusColor: statusColor,
            taskSelectedTarget: []
        }
    },
    mounted(){
        this.getData();
        this.onListAllTaskExecutionStatus();
        this.listTeamMembers();
    },
    methods: {
        onSelectedTask(id){
            const icon = document.getElementById(`task_selected_icon_${id}`);
            if (icon.classList.contains('pi-circle')){
                icon.classList.remove('pi-circle')
                icon.classList.add('pi-circle-fill');
                this.taskSelectedTarget.push("pi-circle-fill")
            }else{
                icon.classList.remove('pi-circle-fill');
                icon.classList.add('pi-circle');
                this.taskSelectedTarget.splice(0, 1);
            }
            this.$emit("selectedTask", id, this.taskSelectedTarget);
        },
        updateTaskUser(task_id, user_id){
            this.Api.put('task/user', {user_id: user_id, task_id: task_id})
            .then(() => {
                this.getData();
            })
        },
        updateTaskStatus(task_id, status_id){
            this.Api.put('task/execution-status', {task_id: task_id, execution_status_id: status_id})
            .then(()=> {
                this.getData();
            })
        },
        onRowExpand(){
           console.log(this.expandedRow)
        },
        listTeamMembers(){
            this.Api.get(`user/list-by-team/${this.$route.params.id}`)
            .then(async response => {
                this.members = await response.data.data;
            })
        },
        onListAllTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.task_status = await response.data;
            })
        },
        updatePriority(task_id, value){
            this.Api.put(`task/priority`, {task_id: task_id, priority: value})
            .then(() => {
                console.log(value, task_id);
                this.getData();
            })
        },
        getData(){
            this.Api.get(this.url)
            .then(async response => {
                this.datas = await response.data.data;
            })
        }
    }
}

</script>
<style scoped>
.table_columns:hover{
    background-color: aqua;
}
</style>
