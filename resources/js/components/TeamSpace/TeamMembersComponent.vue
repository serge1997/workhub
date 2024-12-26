<template>
    <div class="col-md-12 m-auto">
        <DataTable v-model:expandedRows="expandedRow" :value="members_data"  @rowExpand="onRowExpand">
            <Column style="width: 3rem"  expander />
            <Column>
                <template #header="{data}">
                     <small class="gray-pure p-2 w-100 gray-alert-bg">Members</small>
                </template>
                    <template #body="{data}">
                        <Tag severity="secondary">
                            <Chip :image="`/img/users_avatars/${data.avatar}`"/>
                            <span>{{ data.name }}</span>
                        </Tag>
                    </template>
            </Column>
            <Column>
                <template #header="{data}">
                     <small class="gray-pure p-2 w-100 gray-alert-bg">Total tarefas atribuidas</small>
                </template>
                <template #body="{data}">
                    {{ data.task_total }}
                </template>
            </Column>
            <Column>
                <template #header="{data}">
                     <small class="gray-pure p-2 w-100 gray-alert-bg">Concluidos</small>
                </template>
                    <template #body="{data}">
                        <Tag v-if="data.task_concluded" severity="success" :value="data.task_concluded" />
                        <Tag v-else severity="secondary" value="-" />
                    </template>
            </Column>
            <template #expansion="slotProps">
                <small>tarefas para {{ slotProps.data.name }}</small>
                <DataTable :value="slotProps.data.tasks">
                    <Column class="border-bottom">
                        <template #header>
                            <small class="fw-normal">Tarefas</small>
                        </template>
                        <template #body="{data}">
                            <span class="d-flex gap-1">
                                <Button text>
                                    <i class="pi pi-circle task-description"></i>
                                </Button>
                                <router-link class="text-decoration-none gray-pure p-2 w-100" :to="`/task-show/${data.id}/task/${data.id}`">
                                    {{ data.short_title }}
                                </router-link>
                            </span>
                        </template>
                    </Column>
                    <Column class="border-bottom">
                        <template #header>
                            <small class="fw-normal">Prioridade</small>
                        </template>
                        <template #body="{ data }">
                            <div class="d-flex gap-1 align-items-center">
                                <span>
                                    <i :class="`text-${taskPrioritySeverity(data.priority)}`" class="pi pi-flag-fill small-icon"></i>
                                </span>
                                <span>
                                   <small> {{ data.priority_fullDescription }}</small>
                                </span>
                            </div>
                        </template>
                    </Column>
                    <Column class="border-bottom">
                        <template #header>
                            <small class="fw-normal">Status</small>
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
                            <small class="fw-normal">Sprint</small>
                        </template>
                        <template #body="{ data }">
                            <div>
                                <small>{{ data.sprint_name }}</small>
                            </div>
                        </template>
                    </Column>
                    <Column class="border-bottom">
                        <template #header="data">
                            <small class="fw-normal">Projeto</small>
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
import DataTable from 'primevue/datatable';

export default {
    name: 'TeamMembersComponent',
    inject: ['taskPrioritySeverity'],

    components: {
        DataTable
    },

    data(){
        return{
            members_data: [],
            expandedRow: null
        }
    },
    mounted(){
        this.Api.get(`bi/list-members-tasks/by-team/${this.$route.params.id}`)
        .then(async response => {
            this.members_data = await response.data.data;
        })
    },
    methods: {
        onRowExpand(){
           console.log(this.expandedRow)
        }
    }
}

</script>
