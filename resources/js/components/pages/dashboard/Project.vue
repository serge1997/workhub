<template>
    <SidebarComponent>
        <div class="container-fluid">
            <div class="row">
                <Toolbar class="w-100 p-0">
                    <template #start>
                        <div class="d-flex w-100">
                            <Tag class="d-flex">
                                <span><small>Projetos</small></span>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-angle-right"></i>
                                </span>
                            </Tag>
                            <Button v-for="project of projects" class="task-description d-flex gap-1" label="Projeto" text>
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
                            <Button class="task-description d-flex gap-1" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-bolt small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Sprint</small></span>
                            </Button>
                            <Button class="task-description d-flex gap-1" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-align-center small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Tarefas</small></span>
                            </Button>
                            <Button class="task-description d-flex gap-1" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-chart-pie small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Insights</small></span>
                            </Button>
                        </div>
                    </template>
                </Toolbar>
            </div>
            <div class="row">
                <SprintListComponent />
            </div>
        </div>
    </SidebarComponent>
</template>
<script>
import SprintListComponent from '../../project/SprintListComponent.vue';
export default {
    name: 'Project',

    components: {
        SprintListComponent
    },

    data(){
        return {
            projects: null
        }
    },
    methods: {
        listAllProject(){
            this.Api.get('project')
            .then(async response => {
                this.projects = await response.data.data;
            })
        }
    },
    mounted(){
        this.listAllProject()
    }
}
</script>
