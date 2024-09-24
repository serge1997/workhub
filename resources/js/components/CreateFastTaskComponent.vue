<template>
    <Button @click="visibleFastTaskDialog = true" class="w-50 navbar-dialog-btn rounded-2 fs-4 text-danger" text icon="pi pi pi-book" />
    <small class="task-description navbar-dialog-btn-desc">Task rapido</small>
    <Dialog v-model:visible="visibleFastTaskDialog" header="Criar tarefa rapido" :style="{ width: '65rem' }" position="topcenter" :modal="true" :draggable="false">
        <div class="row mt-3">
            <div class="col-md-10 m-auto mb-3">
                <InputText v-model="fastTask.title" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="Titulo da tarefa" />
            </div>
            <div class="col-md-10 m-auto mb-3">
                <Textarea v-model="fastTask.description" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="Descrição da tarefa" />
            </div>
            <div class="col-md-10 m-auto d-flex gap-2 fast-task-form-icon-group">
                <div class="d-flex flex-column gap-2">
                    <Button text class="border rounded-pill fast-task-form-btn px-3 py-0 d-flex gap-1 align-items-center justify-content-center">
                        <span v-if="!fastTask.user_id" class="d-flex align-items-center">
                            <i class="pi pi-user fast-task-form-icon"></i>
                        </span>
                        <span v-else class="d-flex align-items-center">
                            <img :alt="fastTask.user_id.name" :src="`/img/users_avatars/${fastTask.user_id.avatar}`" style="width: 18px" />
                            <i class="fast-task-form-icon"></i>
                        </span>
                        <span class="d-flex align-items-center">
                            <small class="task-description">{{ fastTask.user_id === null ? 'usuario responsavel' : fastTask.user_id.name }}</small>
                        </span>
                    </Button>
                    <Listbox v-model="fastTask.user_id" :options="users" optionLabel="name" filter class="w-full md:w-56">
                        <template #option="slotProps">
                            <div class="d-flex gap-2">
                                <img :alt="slotProps.option.name" :src="`/img/users_avatars/${slotProps.option.avatar}`" style="width: 28px" />
                                <div>{{ slotProps.option.name }}</div>
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
                            <i class="pi pi-circle-fill" :class="fastTask.priority !== null ? 'text-'+fastTask.priority.severity : 'fast-task-form-icon'"></i>
                        </span>
                        <span v-if="fastTask.priority !== null" class="d-flex align-items-center">
                            <small class="task-description">Prioridade {{ fastTask.priority.label }}</small>
                        </span>
                        <span v-else class="d-flex align-items-center">
                            <small class="task-description">Prioridade</small>
                        </span>
                    </Button>
                    <Listbox v-model="fastTask.priority" :options="priorities" filter optionLabel="label" class="w-full md:w-56">
                        <template #option="slotProps">
                            <div class="d-flex align-items-center gap-2">
                                <i class="pi pi-circle-fill" :class="`text-${slotProps.option.severity}`"></i>
                                <div>{{ slotProps.option.label }}</div>
                            </div>
                        </template>
                    </Listbox>
                </div>
            </div>
            <div class="col-md-10 m-auto mt-4">
                <Button v-if="disbaleBtnCreate()" @click="createFastTask" disabled class="btn-block w-100" id="btn-create-fast" label="Salvar" />
                <Button v-else @click="createFastTask" class="btn-block w-100" id="btn-create-fast" label="Salvar" />
            </div>
        </div>
    </Dialog>
</template>
<script>
import { DateTime } from '../core/DateTime';
export default {
    name: 'CreateFastTaskComponent',

    watch: {
        'fastTask.title': {
            handler: function(newval, old){
                this.disbaleBtnCreate()
            }
        },
    },
    data(){
        return{
            visibleFastTaskDialog: false,
            priorities: [
                {value: "ALT", label: "Alta", severity: "danger"},
                {value: "MED", label: "Media", severity: "warning"},
                {value: "BAX", label: "Baixa", severity: "success"}
            ],
            visibleTaskTimeInputDialog: false,
            fastTask:{
                title: null,
                priority: null,
                user_id: null,
                execution_delay: null,
                description: null,
            },
            users: null,
            disableBtn: 'disabled',
        }
    },

    methods:{
        onListAllUsers(){
            this.Api.get('users')
            .then(async (response) => {
                this.users = await response.data;
            })
            .catch(err => console.log(err))
        },
        createFastTask(){
            const enFormat = DateTime.enFormat(this.fastTask.execution_delay);
            const data = {
                title: this.fastTask.title,
                priority: this.fastTask.priority.value,
                user_id: this.fastTask.user_id.id,
                execution_delay: DateTime.time(enFormat),
                description: this.fastTask.description
            }
            this.Api.post('task', data)
            .then(async response => {
                this.toaster(response.data).fire();
                this.fastTask.title = null;
                this.fastTask.priority = null;
                this.fastTask.user_id = null;
                this.fastTask.execution_delay = null;
                this.fastTask.description =  null;
                data = null;
            })
            .catch(error => {
                console.log(error)
            })
        },
        disbaleBtnCreate(){
            return this.fastTask.title === null
                || this.fastTask.execution_delay === null
                || this.fastTask.priority === null
                || this.fastTask.user_id === null
                || this.fastTask.title == ""
                || this.fastTask.execution_delay == ""
                ? true : false;
        },
        toaster(response){
            const Toast = this.$swal.mixin({
                text: response,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                icon: "success",
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            return Toast
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
