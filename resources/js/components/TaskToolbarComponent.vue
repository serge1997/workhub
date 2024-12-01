<template>
    <div class="container m-auto position-fixed d-none shadow-lg rounded-pill" id="task-toolbar">
        <div class="row">
            <div class="col-md-10 d-flex gap-1 align-items-center">
                <Button @click="visibleTaskTransfertSidebar = true" class="task-description btn-text-nowrap  d-flex align-items-center gap-1" label="Projeto" text>
                    <span class="d-flex align-items-center">
                        <i class="pi pi-sort-amount-up-alt small-icon text-white"></i>
                    </span>
                    <span class="small-fw text-white"><small>Transferir</small></span>
                </Button>
                <Button class="task-description btn-text-nowrap  d-flex align-items-center gap-1" label="Projeto" text>
                    <span class="d-flex align-items-center">
                        <i class="pi pi-share-alt small-icon text-white"></i>
                    </span>
                    <span class="small-fw text-white"><small>Sub tarefas</small></span>
                </Button>
                <Button class="task-description btn-text-nowrap  d-flex align-items-center gap-1" label="Projeto" text>
                    <span class="d-flex align-items-center">
                        <i class="pi pi-align-right small-icon text-white"></i>
                    </span>
                    <span class="small-fw text-white"><small>Alteração em massa</small></span>
                </Button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <Sidebar v-model:visible="visibleTaskTransfertSidebar" header="Transferir tarefas" :style="{width: '35em'}">
               <TransfertTaskComponent
                    :tasks-ids="tasksIds"
                />
            </Sidebar>
        </div>
    </div>
</template>
<script>
import { defineAsyncComponent } from 'vue';
export default {
    name: 'TaskToolbarComponent',

    components: {
        TransfertTaskComponent: defineAsyncComponent(() =>
            import('./tasks/TransfertTaskComponent.vue')
        )
    },
    props:{
        tasksIds: Object
    },
    data(){
        return {
            visibleTaskTransfertSidebar: false
        }
    }
}
</script>
<style scoped>
#task-toolbar{
    bottom: 5%;
    background-color: #09090b;
    z-index: 1;
}
</style>
