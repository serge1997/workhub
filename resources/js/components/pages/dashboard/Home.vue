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
            <div class="row">
                <div class="col-md-6 p-2">
                    <div class="card w-100 shadow-sm">
                        <div class="card-header border bg-transparent">
                            <h4 class="task-description">Recentes</h4>
                        </div>
                        <div class="card-body">
                            list of recents things
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <Dialog v-model:visible="visibleNewsMoal" header="  " :style="{ width: '85em' }" maximizable>
                    <div class="row">
                        <div class="card w-100 border-0">
                            <div class="card-header bg-transparent">
                                <Button @click="componentIs='CreateFastTaskComponent'" class="task-description" label="Projeto" text>
                                    <span class="small-fw">Tarefa</span>
                                </Button>
                                <Button @click="componentIs='CreateProjectComponent'" class="task-description" label="Projeto" text>
                                    <span class="small-fw">Projeto</span>
                                </Button>
                            </div>
                            <div class="card-body">
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
export default {
    name: 'Home',

    components: {
        CreateFastTaskComponent,
        CreateProjectComponent
    },
    data() {
        return {
            authName: this.Auth.user().name,
            visibleNewsMoal: false,
            componentIs: 'CreateFastTaskComponent'
        }
    }
}
</script>
