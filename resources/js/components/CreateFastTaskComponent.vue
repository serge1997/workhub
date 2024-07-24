<template>
    <Button @click="visibleFastTaskDialog = true" class="w-50 navbar-dialog-btn rounded-2 fs-4 text-danger" text icon="pi pi pi-book" />
    <small class="task-description navbar-dialog-btn-desc">Task rapido</small>
    <Dialog v-model:visible="visibleFastTaskDialog" header="Criar tarefa rapido" :style="{ width: '65rem' }" position="topcenter" :modal="true" :draggable="false">
        <div class="row mt-3">
            <div class="col-md-10 m-auto mb-3">
                <InputText v-model="fastTask.title" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="Titulo da tarefa" />
            </div>
            <div class="col-md-10 m-auto d-flex gap-2 fast-task-form-icon-group">
                <div class="d-flex flex-column gap-2">
                    <Button text class="border rounded-pill fast-task-form-btn px-3 py-0 d-flex gap-1 align-items-center justify-content-center">
                        <span class="d-flex align-items-center">
                            <i class="pi pi-user fast-task-form-icon"></i>
                        </span>
                        <span class="d-flex align-items-center">
                            <small class="task-description">usuario responsavel</small>
                        </span>
                    </Button>
                    <Listbox v-model="fastTask.user_id" :options="users" filter class="w-full md:w-56">
                        <template #data="{option}">
                            <div class="d-flex">
                                <img :alt="option.name" :src="`img/users_avatars/${option.avatar}`" style="width: 18px" />
                                <div>{{ option.name }}</div>
                            </div>
                        </template>
                    </Listbox>
                </div>
                <div class="d-flex flex-column gap-2">
                    <Button @click="visibleTaskTimeInputDialog = true" text class="border rounded-pill fast-task-form-btn px-3 py-0 d-flex gap-1 align-items-center justify-content-center">
                        <span class="d-flex align-items-center">
                            <i class="pi pi-clock fast-task-form-icon"></i>
                        </span>
                        <span class="d-flex align-items-center">
                            <small class="task-description">Tempo execução</small>
                        </span>
                    </Button>
                    <Dialog v-model:visible="visibleTaskTimeInputDialog" :style="{ width: '25rem' }" position="topcenter" :modal="true" :draggable="false">
                        <Calendar v-model="fastTask.execution_delay" id="execution-time" class="w-100"  placeholder="execution time..." timeOnly />
                    </Dialog>
                </div>
                <div class="d-flex flex-column gap-2">
                    <Button text class="border rounded-pill fast-task-form-btn px-3 py-0 d-flex gap-1 align-items-center justify-content-center">
                        <span class="d-flex align-items-center">
                            <i class="pi pi-circle-fill fast-task-form-icon"></i>
                        </span>
                        <span v-if="fastTask.priority !== null" class="d-flex align-items-center">
                            <small class="task-description">Prioridade {{ fastTask.priority.label }}</small>
                        </span>
                        <span v-else class="d-flex align-items-center">
                            <small class="task-description">Prioridade</small>
                        </span>
                    </Button>
                    <Listbox @change="onSelectedPriority" v-model="fastTask.priority" :options="priorities" filter optionLabel="label" class="w-full md:w-56" />
                </div>
            </div>
            <div class="col-md-10 m-auto mt-4">
                <Button class="btn-block w-100" label="Salvar" />
            </div>
        </div>
    </Dialog>
</template>
<script>
export default {
    name: 'CreateFastTaskComponent',

    data(){
        return{
            visibleFastTaskDialog: false,
            priorities: [
                {value: "ALT", label: "Alta"},
                {value: "MED", label: "Media"},
                {value: "BAX", label: "Baixa"}
            ],
            visibleTaskTimeInputDialog: false,
            fastTask:{
                title: null,
                priority: null,
                user_id: null,
                execution_delay: null
            },
            users: null,
        }
    },

    methods:{
        onSelectedPriority(){
            console.log(this.fastTask.priority.label);
        },
        onListAllUsers(){
            this.Api.get('users')
            .then(async (response) => {
                this.users = await response.data.filter(manager => manager.user_type !== "ADM");
            })
            .catch(err => console.log(err))
        },
    },
    mounted(){
        this.onListAllUsers();
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
