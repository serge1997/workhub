<template>
   <SidebarComponent>
        <div class="container-fluid">
            <div class="row mb-4">
                <Toolbar class="p-0 border-0 bg-transparent border-bottom">
                    <template #start>
                        <div class="d-flex gap-2 w-100">
                            <Tag class="text-capitalize" severity="secondary" :value="`/ ${$route.params.name}`"/>
                            <Button class="task-description btn-text-nowrap  d-flex gap-1" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-bolt small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Projetos involvidos</small></span>
                            </Button>
                            <Button class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
                                <span class="d-flex align-items-center">
                                    <i class="pi pi-align-center small-icon"></i>
                                </span>
                                <span class="small-fw"><small>Tarefas</small></span>
                            </Button>
                            <Button class="task-description d-flex gap-1 btn-text-nowrap " label="Projeto" text>
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
                <ProjectListComponent
                    :projects="projects"
                />
            </div>
        </div>
   </SidebarComponent>
</template>
<script>
import ProjectListComponent from './../../TeamSpace/ProjectListComponent.vue';
export default {

    components: {
        ProjectListComponent
    },
    data(){
        return {
            name: this.$route.params.name,
            projects: []
        }
    },
    mounted(){
        this.listAllProjects();
    },
    methods:{
        listAllProjects(){
            this.Api.get('project')
            .then(async response => {
                this.projects = response.data.data;
            })
        }
    }
}
</script>
