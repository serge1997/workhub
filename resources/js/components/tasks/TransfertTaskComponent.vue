<template>
    <div class="card border-0">
       <div class="card-header bg-transparent border-0">
            <img class="w-75 m-auto" src="/img/human-board.png" alt="" srcset="">
       </div>
       <div class="card-body">
            <div class="w-auto btn-text-nowrap mb-3 cursor-p">
                <GlobalTasksOverlayComponent
                    :tasks="tasks"
                    :tag-label="`${tasksIds.length} tarefas selecionadas`"
                 />
            </div>
            <div class="form-group d-flex flex-column mb-3">
                <Dropdown v-model="transfertData.sprint" :options="sprints" option-label="name">
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="d-flex gap-2">
                            <Tag icon="pi pi-align-left" :value="slotProps.value.name" severity="secondary" />
                        </div>
                        <div v-else class="d-flex gap-2">
                            <Tag icon="pi pi-align-left" value="sprint de destino" severity="secondary" />
                        </div>
                    </template>
                    <template #option="slotProps">
                        <div class="d-flex gap-2">
                            <Tag icon="pi pi-align-left" :value="slotProps.option.name" severity="secondary" />
                        </div>
                    </template>
                </Dropdown>
            </div>
            <div class="form-group d-flex flex-column mb-4">
                <Dropdown v-model="transfertData.status" :options="execution_status" option-label="name">
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="d-flex gap-2">
                            <Tag icon="pi pi-tag" :value="slotProps.value.name_ucfirst" severity="secondary" />
                        </div>
                        <div v-else class="d-flex gap-2">
                            <Tag icon="pi pi-tag" value="status de destino" severity="secondary" />
                        </div>
                    </template>
                    <template #option="slotProps">
                        <div class="d-flex gap-2">
                            <Tag icon="pi pi-tag" :value="slotProps.option.name_ucfirst" severity="secondary" />
                        </div>
                    </template>
                </Dropdown>
            </div>
            <div class="form-group d-flex flex-column mb-4">
                <Dropdown v-model="transfertData.team" :options="teams" option-label="name">
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="d-flex gap-2">
                            <Tag icon="pi pi-users" :value="slotProps.value.name" severity="secondary" />
                        </div>
                        <div v-else class="d-flex gap-2">
                            <Tag icon="pi pi-users" value="Equipe de destino de destino" severity="secondary" />
                        </div>
                    </template>
                    <template #option="slotProps">
                        <div class="d-flex gap-2">
                            <Tag icon="pi pi-users" :value="slotProps.option.name" severity="secondary" />
                        </div>
                    </template>
                </Dropdown>
            </div>
            <div class="form-group d-flex flex-column">
               <Button @click="transfertTasks" label="transferir" class="rounded-pill" />
            </div>
       </div>
    </div>
</template>
<script>
import { defineAsyncComponent } from 'vue';
import { useToast } from 'primevue/usetoast';
export default {
    name: 'TransfertTaskComponent',

    components: {
        GlobalTasksOverlayComponent: defineAsyncComponent(() =>
            import('../Overlays/GlobalTasksOverlayComponent.vue')
        )
    },
    props:{
        tasksIds: Object
    },
    data(){
        return {
            tasks: [],
            sprints: [],
            teams: [],
            toast: useToast(),
            transfertData: {
                sprint: null,
                status: null,
                team: null
            },
            execution_status: []
        }
    },
    methods: {
        transfertTasks(){
            const data = {
                status_id: this.transfertData.status?.id,
                sprint_id: this.transfertData.sprint?.id,
                team_id: this.transfertData.team?.id,
                tasks_ids: this.tasksIds
            }
            this.Api.put('task/transfert', null, data)
            .then(async response => {
                this.toast.add({ severity: 'success', summary: 'successo', detail: await response.data.message, life: 3000 });
                setTimeout(() => {
                    if (data.sprint_id){
                        this.$router.push(`/sprint/${data.sprint_id}`)
                    }
                }, 300)
            })
            .catch(error => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: error.response.data.message, life: 3000 });
            })
        },
        listAllTasks(){
            this.Api.post('task/list-by-ids', {tasks_ids: this.tasksIds})
            .then(async response => {
                this.tasks = await response.data.data;
            })
            .catch(error => {

            })
        },
        getSprints(){
            this.Api.get('sprint')
            .then(async response => {
                this.sprints = await response.data;
            })
            .catch(error => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded sprints", life: 3000 });
            })
        },
        getTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.execution_status = await response.data;
            })
            .catch(err => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded execution status", life: 3000 });
            })
        },
        listAllTeam(){
            this.Api.get('team-space')
            .then(async response => {
                this.teams = await response.data.data;
            })
        },
    },
    mounted(){
        this.listAllTasks();
        this.getSprints();
        this.getTaskExecutionStatus();
        this.listAllTeam();
    }
}
</script>
