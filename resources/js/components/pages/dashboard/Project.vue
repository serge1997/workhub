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
        </div>
    </SidebarComponent>
</template>
<script>
export default {
    name: 'Project',

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
