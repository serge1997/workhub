<template>
    <div class="row mt-3">
        <div class="col-md-10 m-auto mb-3">
            <InputText v-model="fastTask.title" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="Titulo da tarefa" />
        </div>
        <div class="col-md-10 m-auto mb-3">
            <Textarea v-model="fastTask.description" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="Descrição da tarefa" />
        </div>
        <div class="col-md-10 mb-3 m-auto d-flex flex-column">
            <div class="row">
                <div class="col-md-6">
                    <Dropdown v-model="fastTask.project_id" :options="projects" optionLabel="name" :class="formErrorBag && formErrorBag.sprint_id ? invalidInpuClass : ''" class="w-100" id="prioritie" placeholder="Selectione um projeto">
                        <template #value="slotProps">
                            <div v-if="slotProps.value">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="task-description"><i class="pi pi-tag"></i></span>
                                    <Tag severity="secondary" :value="slotProps.value.name"/>
                                </div>
                            </div>
                            <span v-else>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="task-description"><i class="pi pi-tag"></i></span>
                                    <span>{{ slotProps.placeholder }}</span>
                                </div>
                            </span>
                        </template>
                        <template #option="slotProps">
                            <div class="d-flex gap-2">
                                <span class="task-description"><i class="pi pi-tag"></i></span>
                                <span>{{ slotProps.option.name }}</span>
                            </div>
                        </template>
                    </Dropdown>
                    <small class="text-danger" v-if="formErrorBag && formErrorBag.project_id" v-text="`${formErrorBag.project_id}`"></small>
                </div>
                <div class="col-md-6">
                    <Dropdown v-model="fastTask.sprint_id" :options="sprints" optionLabel="name" :class="formErrorBag && formErrorBag.sprint_id ? invalidInpuClass : ''" class="w-100" id="prioritie" placeholder="Selectione um sprint">
                        <template #value="slotProps">
                            <div v-if="slotProps.value">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="task-description"><i class="pi pi-list"></i></span>
                                    <Tag severity="warning" :value="slotProps.value.name"/>
                                </div>
                            </div>
                            <span v-else>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="task-description"><i class="pi pi-list"></i></span>
                                    <span>{{ slotProps.placeholder }}</span>
                                </div>
                            </span>
                        </template>
                        <template #option="slotProps">
                            <div class="d-flex gap-2">
                                <span class="task-description"><i class="pi pi-tag"></i></span>
                                <span>{{ slotProps.option.name }}</span>
                            </div>
                        </template>
                    </Dropdown>
                    <small class="text-danger" v-if="formErrorBag && formErrorBag.sprint_id" v-text="`${formErrorBag.sprint_id}`"></small>
                </div>
            </div>
        </div>
        <div class="col-md-10 m-auto d-flex justify-content-between fast-task-form-icon-group">
            <div class="d-flex flex-column gap-2 position-relative">
                <Button @click="toggleUserListBox = !toggleUserListBox" text class="border rounded-pill fast-task-form-btn px-3 py-0 d-flex gap-1 align-items-center justify-content-center">
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
                <Listbox v-if="toggleUserListBox" @change="handleToggleUserList" v-model="fastTask.user_id" :options="users" optionLabel="name" filter style="width: 240px; z-index: 10; top: 140%;" class="position-absolute shadow">
                    <template #option="slotProps">
                        <div class="d-flex gap-2">
                            <img :alt="slotProps.option.name" :src="`/img/users_avatars/${slotProps.option.avatar}`" style="width: 22px" />
                            <div class="small-fw">{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Listbox>
            </div>
            <div class="d-flex flex-column gap-2 position-relative">
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
                <Button @click="togglePriorityListBox = !togglePriorityListBox" text class="border rounded-pill fast-task-form-btn px-3 py-0 d-flex gap-1 align-items-center justify-content-center">
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
                <Listbox v-if="togglePriorityListBox" @change="handleTogglePriorityList" v-model="fastTask.priority" :options="priorities" filter optionLabel="label" style="width: 240px; z-index: 1; bottom: 30%;" class="position-absolute shadow">
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
            <Button v-if="disbaleBtnCreate()" @click="createFastTask" disabled class="btn-block w-100 rounded-pill" id="btn-create-fast" label="Salvar" />
            <Button v-else @click="createFastTask" class="btn-block w-100 rounded-pill" id="btn-create-fast" label="Salvar" />
        </div>
    </div>
</template>
<script>
import { useToast } from 'primevue/usetoast';
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
                sprint_id: null,
                project_id: null
            },
            users: null,
            disableBtn: 'disabled',
            sprints: null,
            toggleUserListBox: false,
            togglePriorityListBox: false,
            projects: [],
            toast: useToast()
        }
    },

    methods:{
        handleToggleUserList(){
            this.toggleUserListBox = false;
        },
        handleTogglePriorityList(){
            this.togglePriorityListBox = false;
        },
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
                priority: this.fastTask.priority ? this.fastTask.priority.value : null,
                user_id: this.fastTask.user_id ? this.fastTask.user_id.id : null,
                execution_delay: DateTime.time(enFormat),
                description: this.fastTask.description,
                project_id: this.fastTask.project_id.id,
                sprint_id: this.fastTask.sprint_id.id
            }
            this.Api.post('task', data)
            .then(async response => {
                this.toast.add({severity: 'success', summary: 'Success', detail: await response.data, life: 3000});
                this.fastTask.title = null;
                this.fastTask.priority = null;
                this.fastTask.user_id = null;
                this.fastTask.execution_delay = null;
                this.fastTask.description =  null;
                this.fastTask.sprint_id = null;
                this.fastTask.project_id = null;
                data = null;
            })
            .catch(error => {
                console.log(error)
            })
        },
        disbaleBtnCreate(){
            return this.fastTask.title === null
                || this.fastTask.title == ""
                || this.fastTask.project_id == null
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
        getSprints(){
            this.Api.get('sprint')
            .then(async response => {
                this.sprints = await response.data;
            })
            .catch(error => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded sprints", life: 3000 });
            })
        },
        listAllProject(){
            this.Api.get('project')
            .then(async response => {
                this.projects = await response.data.data;
            })
        }
    },
    mounted(){
        this.onListAllUsers();
        this.getSprints();
        this.listAllProject();
    }
}
</script>

<style scoped>
/*::placeholder{
    font-weight: 500;
    font-size: 1.1rem;
    color:#1f2937
}*/
.fast-task-form-icon{
    color: #64748b;
    font-size: 0.8em;
}
.fast-task-form-btn{
    background-color: #f3f4f6;
}
</style>
