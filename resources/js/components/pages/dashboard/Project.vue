<template>
    <SidebarComponent>
        <div class="container-fluid">
            <div class="row">
                <Toolbar class="w-100 p-2 border-0 border-bottom mb-2">
                    <template #start>
                        <div class="d-flex align-items-center gap-2 w-100">
                            <Tag class="d-flex">
                                <span><small>Projetos</small></span>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-angle-right"></i>
                                </span>
                            </Tag>
                            <Button v-for="project of projects" class="task-description btn-text-nowrap rounded-pill d-flex gap-1 project_btn_toolbar px-2 py-1" @click="listProjectData(project)" :id="`project_btn_toolbar_${project.id}`" label="Projeto" text>
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
                            <Button @click="toggleComponent = 'SprintListComponent'" class="task-description btn-text-nowrap  d-flex gap-1" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-bolt small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Sprint</small></span>
                            </Button>
                            <Button @click="toggleComponent = 'TaskListByExecutionStatusComponent'"  class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-align-center small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Tarefas</small></span>
                            </Button>
                            <Button class="task-description d-flex gap-1 btn-text-nowrap " label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-chart-pie small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Insights</small></span>
                            </Button>
                            <Button @click="listAllprojectTaskBacklog" class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
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
                    @update-backlog-ui="listAllprojectTaskBacklog"
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
        )
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
        listAllProject(){
            this.Api.get('project')
            .then(async response => {
                this.projects = await response.data.data;
                //trigger click on first project btn
                setTimeout(() => {
                    document.querySelector('.project_btn_toolbar').click();
                    this.selected_project = this.projects[0].id;
                    this.project = this.projects[0];
                }, 500)
            })
        },
        listProjectData(project){
            this.selected_project = project.id;
            this.listSprintByProject(project.id);
            this.listAllprojectTaskBacklog();
            this.project = project;
            this.current_project_name = project.name;
            document.getElementById(`project_btn_toolbar_${project.id}`).classList.toggle('active-project-toolbar-btn')
            document.querySelectorAll('.project_btn_toolbar').forEach(btn => {
                if (btn.getAttribute('id') !== `project_btn_toolbar_${project.id}`){
                    btn.classList.remove('active-project-toolbar-btn')
                }
            })
        },
        listSprintByProject(id){
            this.Api.get(`sprint/list-by-project/${id}`)
            .then(async response => {
                this.projectSprints = await response.data.data;
            })
            .catch(error => {

            })
        },
        listAllprojectTaskBacklog(){
            this.toggleComponent = 'BacklogTaskComponent'
            this.Api.get(`tasks/list-backlogs-by-project/${this.selected_project}`)
            .then(async response => {
                this.backlog_tasks = await response.data.data;
            })
            .catch(error => {

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
.active-project-toolbar-btn{
    background-color: #e5e7eb;
    transition: ease-in .5s;
}
</style>
