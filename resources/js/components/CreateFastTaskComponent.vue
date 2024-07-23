<template>
    <Button @click="visibleFastTaskDialog = true" class="w-50 navbar-dialog-btn rounded-2 fs-4 text-danger" text icon="pi pi pi-book" />
    <small class="task-description navbar-dialog-btn-desc">Task rapido</small>
    <Dialog v-model:visible="visibleFastTaskDialog" header="Criar tarefa rapido" :style="{ width: '65rem' }" position="topcenter" :modal="true" :draggable="false">
        <div class="row">
            <div class="col-md-10 m-auto mb-3">
                <InputText style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="Titulo da tarefa" />
            </div>
            <div class="col-md-10 m-auto d-flex gap-2 fast-task-form-icon-group">
                <Button text class="border rounded-pill fast-task-form-btn px-3 py-0 d-flex gap-1 align-items-center justify-content-center">
                    <span class="d-flex align-items-center">
                        <i class="pi pi-user fast-task-form-icon"></i>
                    </span>
                    <span class="d-flex align-items-center">
                        <small class="task-description">usuario responsavel</small>
                    </span>
                </Button>
                <Button text class="border rounded-pill fast-task-form-btn px-3 py-0 d-flex gap-1 align-items-center justify-content-center">
                    <span class="d-flex align-items-center">
                        <i class="pi pi-clock fast-task-form-icon"></i>
                    </span>
                    <span class="d-flex align-items-center">
                        <small class="task-description">Tempo execução</small>
                    </span>
                </Button>
            </div>
        </div>
    </Dialog>
</template>
<script>
export default {
    name: 'CreateFastTaskComponent',

    data(){
        return{
            visibleFastTaskDialog: false
        }
    },

    methods:{

    },
    mounted(){

    }
}
</script>

<style scoped>
::placeholder{
    font-weight: 500;
    font-size: 1.1rem;
    color:#1f2937
}
.fast-task-form-icon{
    color: #64748b;
    font-size: 0.8em;
}
.fast-task-form-btn{
    background-color: #f3f4f6;
}
</style>
