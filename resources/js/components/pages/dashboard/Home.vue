<template>
    <SidebarComponent>
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-10 p-2">
                    <Button @click="visibleNewsMoal = true" class="rounded-pill" label="Novo" icon="pi pi-plus" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-10 p-2">
                    <h3 class="fw-bold">Olá, {{authName}}</h3>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 p-2">
                    <div class="card w-100 shadow-sm border" style="border-radius: 12px;">
                        <div class="card-header border-0 bg-transparent">
                            <h5 class="task-description">Recentes</h5>
                        </div>
                        <div class="card-body">
                            list of recents things
                        </div>
                    </div>
                </div>
            </div>
            <div class="row position-relative">
                <div class="col-md-6 p-2">
                    <div class="card w-100 shadow-sm" style="border-radius: 12px;">
                        <div class="card-header border-0 bg-transparent">
                            <h5 class="task-description">Seus projetos</h5>
                        </div>
                        <div class="card-body">
                            <ProjectHomeListComponent />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <Dialog class="overflow-scroll" v-model:visible="visibleNewsMoal" header="  " :style="{ width: '85em', height: '55rem' }" maximizable>
                    <div class="row">
                        <div class="card w-100 border-0">
                            <div class="card-header bg-transparent">
                                <Button @click="componentIs='CreateFastTaskComponent'" :class="toggleActiveClass('CreateFastTaskComponent')" class="task-description" label="Projeto" text>
                                    <span class="d-flex gap-1">
                                        <span><i class="pi pi-book"></i></span>
                                        <span class="small-fw">Tarefa</span>
                                    </span>
                                </Button>
                                <Button @click="componentIs='CreateProjectComponent'" :class="toggleActiveClass('CreateProjectComponent')" class="task-description" label="Projeto" text>
                                    <span class="d-flex gap-1">
                                        <span><i class="pi pi-slack"></i></span>
                                        <span class="small-fw">Projeto</span>
                                    </span>
                                </Button>
                                <Button @click="componentIs='CreateTeamSpaceComponent'" :class="toggleActiveClass('CreateTeamSpaceComponent')" class="task-description" label="Projeto" text>
                                    <span class="d-flex gap-1">
                                        <span><i class="pi pi-box"></i></span>
                                        <span class="small-fw">Team space</span>
                                    </span>
                                </Button>
                            </div>
                            <div class="card-body p-0 mt-4">
                                <KeepAlive>
                                    <component :is="componentIs"></component>
                                </KeepAlive>
                            </div>
                        </div>
                    </div>
                </Dialog>
            </div>
        </div>
    </SidebarComponent>
</template>
<script>
import CreateFastTaskComponent from '../../CreateFastTaskComponent.vue';
import CreateProjectComponent from '../../CreateProjectComponent.vue';
import ProjectHomeListComponent from '../../project/ProjectHomeListComponent.vue';
import CreateTeamSpaceComponent from '../../CreateTeamSpaceComponent.vue';
export default {
    name: 'Home',

    components: {
        CreateFastTaskComponent,
        CreateProjectComponent,
        ProjectHomeListComponent,
        CreateTeamSpaceComponent
    },
    data() {
        return {
            authName: this.Auth.user().name,
            visibleNewsMoal: false,
            componentIs: 'CreateFastTaskComponent',
            activeClass: null
        }
    },
    methods: {
        toggleActiveClass(component){
            return this.componentIs == component ? 'active_component' : null;
        }
    }

}
</script>
<style>
.active_component{
    border-bottom: 2px solid #333;
}
</style>
