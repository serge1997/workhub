<template>
   <SidebarComponent>
        <div class="container-fluid">
            <div class="row mb-4">
                <Toolbar class="p-0 border-0 bg-transparent border-bottom">
                    <template #start>
                        <div class="d-flex gap-2 w-100">
                            <Tag class="text-capitalize btn-text-nowrap" severity="secondary" :value="`/ ${$route.params.name}`"/>
                            <Button @click="componentIs = 'ProjectListComponent'" :class="handleActiveClass('ProjectListComponent')" class="task-description btn-text-nowrap  d-flex gap-1" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-bolt small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Projetos involvidos</small></span>
                            </Button>
                            <Button @click="componentIs = 'TaskListByExecutionStatusComponent'" :class="handleActiveClass('TaskListByExecutionStatusComponent')" class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-align-center small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Tarefas</small></span>
                            </Button>
                            <Button @click="componentIs = 'TeamMembersComponent'" :class="handleActiveClass('TeamMembersComponent')" class="task-description d-flex gap-1 btn-text-nowrap " label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-users small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Membros</small></span>
                            </Button>
                        </div>
                    </template>
                </Toolbar>
            </div>
            <div class="row">
                <component :is="componentIs"
                    :projects="projects"
                    :tasks="tasks"
                    :task-status="taskStatus"
                    :icon="projectListIcon"
                    :status-api-url="`task-execution-status/list-with-task-count/by-team/`"
                    :task-Api-url="`task/list-by-team/${$route.params.id}/status/`"
                    :by-id="$route.params.id"
                    @list-task-by-project="listTaskByProject"
                />
            </div>
        </div>
   </SidebarComponent>
</template>
<script>
import { defineAsyncComponent } from 'vue';
import { useToast } from 'primevue/usetoast';
export default {

    components: {
        ProjectListComponent: defineAsyncComponent(() =>
            import('./../../TeamSpace/ProjectListComponent.vue')
        ),
        TaskListByExecutionStatusComponent: defineAsyncComponent(() =>
            import('../../project/TaskListByExecutionStatusComponent.vue')
        ),
        TeamMembersComponent: defineAsyncComponent(() =>
            import('../../TeamSpace/TeamMembersComponent.vue')
        )
    },
    watch: {
        '$route.params.id'(n, old){
            this.listAllProjectsByTeam();
            this.onListAllTaskExecutionStatus();
        }
    },
    data(){
        return {
            name: this.$route.params.name,
            projects: [],
            tasks: [],
            taskStatus: [],
            toast: useToast(),
            projectListIcon: "pi pi-chevron-right",
            componentIs: 'ProjectListComponent',
            team_tasks: []
        }
    },
    mounted(){
        this.listAllProjectsByTeam();
        this.onListAllTaskExecutionStatus();
    },
    methods:{
        onListAllTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.taskStatus = await response.data;
            })
            .catch(err => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded task status data", life: 3000 });
            })
        },
        listExecutionStatus(){
            this.Api.get(`task-execution-status/list-with-task-count/by-team/${this.$route.params.id}`)
        },
        listTaskByProject(project_id, index){
           this.Api.get(`task/list-by-project/${project_id}/team/${this.$route.params.id}`)
           .then(async response => {
                this.tasks[index] = await response.data.data;
                const boxTarget =  document.getElementById(`project-list-box-${project_id}`);
                const btnIcon = document.getElementById(`project-icon-toggle-${project_id}`);
                boxTarget.classList.toggle('d-none')
                if (!boxTarget.classList.contains('d-none')){
                    btnIcon.classList.remove('pi-chevron-right');
                    btnIcon.classList.add('pi-chevron-down')
                }else{
                    btnIcon.classList.remove('pi-chevron-down');
                    btnIcon.classList.add('pi-chevron-right')
                }
           })
        },
        listAllProjectsByTeam(){
            this.Api.get(`project/list-by-team-space/${this.$route.params.id}`)
            .then(async response => {
                //this.projects = response.data.data;
            })
        },
        handleActiveClass(component){
            return this.componentIs == component ? "toolbar-nav-active" : null;
        }
    }
}
</script>
<style scoped>

</style>
