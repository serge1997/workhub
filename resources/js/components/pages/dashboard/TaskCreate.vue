<template>
    <SidebarComponent>
        <div class="row position-relative">
            <div class="col-md-10 m-auto">
                <h3 class="text-center fw-light"></h3>
            </div>
            <div class="col-md-10">
                <div class="card w-100 border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 d-flex flex-column">
                                <label for="email" class="form-label">Titulo</label>
                                <InputText v-model="task.title" type="text" :class="formErrorBag && formErrorBag.title ? invalidInpuClass : ''" class="w-100" id="email" placeholder="Task title" />
                                <small class="text-danger" v-if="formErrorBag && formErrorBag.title" v-text="`${formErrorBag.title}`"></small>
                            </div>
                            <div class="col-md-6 mb-3 d-flex flex-column">
                                <label for="email" class="form-label">Prioridade</label>
                                <Dropdown :options="priorities" v-model="task.priority" :class="formErrorBag && formErrorBag.priority ? invalidInpuClass : ''" optionLabel="label" optionValue="value" class="w-100" id="prioritie" placeholder="Choose priority" />
                                <small class="text-danger" v-if="formErrorBag && formErrorBag.priority" v-text="`${formErrorBag.priority}`"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3 d-flex flex-column">
                                <label for="email" class="form-label">Descrição</label>
                                <Textarea v-model="task.description" class="w-100" id="task-description" placeholder="task description" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 d-flex flex-column mb-3">
                                <label for="email" class="form-label">Tempo de execução</label>
                                <Calendar id="execution-time" v-model="task.execution_delay_date" :class="formErrorBag && formErrorBag.execution_time ? invalidInpuClass : ''" placeholder="execution time..." timeOnly />
                                <small class="text-danger" v-if="formErrorBag && formErrorBag.execution_time" v-text="`${formErrorBag.execution_time}`"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3 d-flex flex-column">
                                <label for="email" class="form-label">Colaborador</label>
                                <Dropdown v-model="task.user_id" :options="users" optionLabel="name" optionValue="id" :class="formErrorBag && formErrorBag.user_id ? invalidInpuClass : ''" class="w-100" id="prioritie" placeholder="Choose prioritie" />
                                <small class="text-danger" v-if="formErrorBag && formErrorBag.user_id" v-text="`${formErrorBag.user_id}`"></small>
                            </div>
                            <div class="col-md-6 mb-3 d-flex flex-column">
                                <label for="priorities" class="form-label">Seguidore(s)</label>
                                <MultiSelect :options="followers" v-model="task.followers" optionLabel="name" optionValue="id" class="w-100" id="task-folowers" placeholder="Choose task folowers" :maxSelectedLabels="3" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 d-flex flex-column">
                                <label for="task-annex" class="form-label">Annexes da tarefa</label>
                                <input class="form-control" type="file" id="annex-test">
                                <Button style="width: 40%;" class="rounded-2" label="Upload" icon="pi pi-file" @click="taskAnnexHandler"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 d-flex flex-column">
                                <label for="task-annex" class="form-label">Road map</label>
                                <CreateTaskRoadMap />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <Button class="w-50" label="Criar tarefa" @click="createTask" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SidebarComponent>
</template>
<script>
import CreateTaskRoadMap from './../../CreateTaskRoadMap.vue';
import { DateTime } from '../../../core/DateTime';
export default{
    name: 'TaskCreate',

    components: {
        CreateTaskRoadMap
    },

    data(){
        return {
            priorities: [
                {value: "ALT", label: "Alta"},
                {value: "MED", label: "Media"},
                {value: "BAX", label: "Baixa"}
            ],
            users: null,
            followers: null,
            managers: null,
            task:{
                title: null,
                description: null,
                user_id: null,
                priority: null,
                execution_delay: null,
                execution_delay_date: null,
                followers: [],
                annex: null,
                time_delay: null
            },
            invalidInpuClass: null,
            formErrorBag: null,
        }
    },
    methods: {
        taskAnnexHandler(ev) {
            console.log(ev.target.textContent)
            const fileInput = document.querySelector('#annex-test');
            fileInput.click()
            fileInput.addEventListener('change', async (event) => {
                const file = event.target.files[0];
                this.task.annex = event.target.files[0];
                console.log(this.task.annex)
                ev.target.textContent += ` ${file.name}`;
                console.log(file.name);
            })
        },
        createTask(e){
            e.preventDefault();
            this.task.execution_delay = DateTime.enFormat(this.task.execution_delay_date);
            this.task.time_delay = DateTime.time(this.task.execution_delay);
            const data = new FormData();
            data.append('annex', this.task.annex);
            data.append('execution_delay', this.task.execution_delay);
            data.append('title', this.task.title);
            data.append('time_delay', this.task.time_delay);
            data.append('description', this.task.description);
            data.append('priority', this.task.priority);
            data.append('user_id', this.task.user_id);
            this.Api.post('task', data)
            .then(async response => {
                this.toaster(response.data).fire();
            })
            .catch(async err => {
                if (err.response.status) {
                    this.formErrorBag = err.response.data.errors
                    this.invalidInpuClass = 'border-danger'
                }
                console.log(err.response.status)
            })
        },
        onListAllUsers(){
            this.Api.get('users')
            .then(async (response) => {
                this.managers = await response.data.filter(manager => manager.user_type == "ADM");
                this.followers = await response.data;
                this.users = await response.data;
            })
            .catch(err => console.log(err))
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
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
        this.onListAllUsers()
    }
}
</script>
