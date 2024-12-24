<template>
    <SidebarComponent>
        <div class="container-fluid">
            <div class="row">
                <Toolbar class="w-100 p-2 border-0 border-bottom mb-2 mt-2">
                    <template #start>
                        <div class="d-flex align-items-center gap-2 w-100">
                            <Tag class="d-flex">
                                <span><small>Projetos</small></span>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-angle-right"></i>
                                </span>
                            </Tag>
                            <Button v-for="project of projects" :class="handleActiveProjectClass(project.id)" class="task-description btn-text-nowrap d-flex gap-1 project_btn_toolbar px-2 py-1" @click="listProjectData(project)" :id="`project_btn_toolbar_${project.id}`" text>
                                <span class="d-flex align-items-center">
                                    <i :style="`color: #${project.severity};`" class="pi pi-circle-fill small-icon"></i>
                                </span>
                                <span class="small-fw">{{ project.name }}</span>
                            </Button>
                        </div>
                    </template>
                </Toolbar>
            </div>
            <div class="row mb-4">
                <Toolbar class="p-0 border-0 bg-transparent border-bottom">
                    <template #start>
                        <div class="d-flex gap-2 w-100">
                            <Button @click="toggleComponent = 'SprintListComponent'" :class="handleActiveClass('SprintListComponent')" class="task-description btn-text-nowrap  d-flex gap-1" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-bolt small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Sprint</small></span>
                            </Button>
                            <Button @click="toggleComponent = 'TaskListByExecutionStatusComponent'" :class="handleActiveClass('TaskListByExecutionStatusComponent')"  class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-align-center small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Tarefas</small></span>
                            </Button>
                            <Button @click="toggleComponent = 'ProjectInsightComponent'" :class="handleActiveClass('ProjectInsightComponent')" class="task-description d-flex gap-1 btn-text-nowrap " label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-chart-pie small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Insights</small></span>
                            </Button>
                            <Button @click="listAllprojectTaskBacklog(prevent = true)" :class="handleActiveClass('BacklogTaskComponent')" class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-hammer small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Backlog</small></span>
                            </Button>
                            <Button @click="visibleFastTaskDialog = true" class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-plus-circle small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Adicionar uma nova tarefa</small></span>
                            </Button>
                        </div>
                    </template>
                </Toolbar>
            </div>
            <div class="row">
                <component
                    :is="toggleComponent"
                    :sprints="projectSprints"
                    :project-id="selected_project"
                    :tasks="backlog_tasks"
                    :project-name="current_project_name"
                    :task-status="taskStatus"
                    :status-api-url="`task-execution-status/list-task-by-project/`"
                    :task-Api-url="`task/list-by-project/${selected_project}/status/`"
                    :by-id="selected_project"
                    @update-backlog-ui="listAllprojectTaskBacklog"
                    @update-ui="listAllprojectTaskBacklog"
                >
                </component>
            </div>
            <div class="row">
                <Dialog v-model:visible="visibleFastTaskDialog" header="Criar tarefa rapido" :style="{ width: '65rem' }" position="topcenter" :modal="true" :draggable="false">
                    <CreateFastTaskComponent
                        :project="project"
                    />
                </Dialog>
            </div>
        </div>
    </SidebarComponent>
</template>
<script>
import { defineAsyncComponent } from 'vue';
export default {
    name: 'Project',

    components: {
        SprintListComponent: defineAsyncComponent(() =>
            import('../../project/SprintListComponent.vue')
        ),
        BacklogTaskComponent: defineAsyncComponent(() =>
            import('../../project/BacklogTaskComponent.vue')
        ),
        CreateFastTaskComponent: defineAsyncComponent(() =>
            import('./../../CreateFastTaskComponent.vue')
        ),
        TaskListByExecutionStatusComponent: defineAsyncComponent(() =>
            import('../../project/TaskListByExecutionStatusComponent.vue')
        ),
        ProjectInsightComponent: defineAsyncComponent(() =>
            import('../../project/ProjectInsightComponent.vue')
        )
    },
    watch: {
        '$route.params.id'(n, old) {
            this.listAllProject();
        }
    },
    data(){
        return {
            projects: null,
            projectSprints: null,
            selected_project: null,
            toggleComponent: 'SprintListComponent',
            backlog_tasks : null,
            current_project_name: null,
            taskStatus: null,
            visibleFastTaskDialog: false,
            project: null
        }
    },
    methods: {
        handleActiveClass(component){
            return this.toggleComponent == component ? "toolbar-nav-active" : null;
        },
        handleActiveProjectClass(id = this.selected_project){
            return this.$route.params.id == id ? "toolbar-nav-active" : null;
        },
        listAllProject(){
            this.Api.get('project')
            .then(async response => {
                this.projects = await response.data.data;
                if (this.$route.params?.id){
                    this.project = this.projects.find(project => project.id == this.$route.params.id)
                    const triggerProjectClick = setInterval(() => {
                        let finded_project_btn = document.getElementById(`project_btn_toolbar_${this.$route.params.id}`);
                        if (finded_project_btn){
                            finded_project_btn.click();
                            clearInterval(triggerProjectClick);
                        }
                    }, 300)
                }else{
                     //trigger click on first project btn
                    setTimeout(() => {
                        document.querySelector('.project_btn_toolbar').click();
                        this.selected_project = this.projects[0].id;
                        this.project = this.projects[0];
                    }, 1000)
                }
            })
        },
        listProjectData(project){
            this.selected_project = project.id;
            this.listSprintByProject(project.id);
            this.listAllprojectTaskBacklog(false);
            this.project = project;
            this.current_project_name = project.name;
            if (this.$route.params?.id){
                this.$router.push(`/dashboard/projects/${project.id}/${project.slug}`)
            }
        },
        listSprintByProject(id){
            this.Api.get(`sprint/list-by-project/${id}`)
            .then(async response => {
                this.projectSprints = await response.data.data;
            })
            .catch(error => {

            })
        },
        listAllprojectTaskBacklog(prevent){
            if(prevent){
                this.toggleComponent = 'BacklogTaskComponent'
            }
            this.Api.get(`tasks/list-backlogs-by-project/${this.selected_project}`)
            .then(async response => {
                this.backlog_tasks = await response.data.data;
            })
        },
        onListAllTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.taskStatus = await response.data;
            })
            .catch(err => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded task status data", life: 3000 });
            })
        },
    },
    mounted(){
        this.listAllProject();
        this.onListAllTaskExecutionStatus();
    }
}
</script>
<style scoped>
</style>
