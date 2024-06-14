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
                                <InputText type="text" class="w-100" id="email" placeholder="Task title" />
                            </div>
                            <div class="col-md-6 mb-3 d-flex flex-column">
                                <label for="email" class="form-label">Prioridade</label>
                                <Dropdown :options="priorities" optionLabel="label" optionValue="value" class="w-100" id="prioritie" placeholder="Choose priority" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3 d-flex flex-column">
                                <label for="email" class="form-label">Descrição</label>
                                <Textarea type="text" class="w-100" id="task-description" placeholder="task description" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 d-flex flex-column mb-3">
                                <label for="email" class="form-label">Tempo de execução</label>
                                <Calendar id="execution-time" v-model="task.execution_time" placeholder="execution time..." timeOnly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3 d-flex flex-column">
                                <label for="email" class="form-label">Colaborador</label>
                                <Dropdown :options="priorities" optionLabel="label" optionValue="value" class="w-100" id="prioritie" placeholder="Choose prioritie" />
                            </div>
                            <div class="col-md-6 mb-3 d-flex flex-column">
                                <label for="priorities" class="form-label">Seguidore(s)</label>
                                <MultiSelect :options="priorities" v-model="task.task_folowers" optionLabel="label" optionValue="value" class="w-100" id="task-folowers" placeholder="Choose task folowers" :maxSelectedLabels="3" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 d-flex flex-column">
                                <label for="task-annex" class="form-label">Annexes da tarefa</label>
                                <input class="form-control" type="file" id="anex-test">
                                <Button style="width: 40%;" class="rounded-2" label="Upload" icon="pi pi-file" @click="taskAnnexHandler"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 d-flex flex-column">
                                <label for="task-annex" class="form-label">Road map</label>
                                <CreateTaskRoadMap />
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
            task:{
                execution_time: null,
                task_folowers: [],
                task_anex: null
            }
        }
    },
    methods: {
        taskAnnexHandler(ev) {
            console.log(ev.target.textContent)
            const fileInput = document.querySelector('#anex-test');
            fileInput.click()
            fileInput.addEventListener('change', async (event) => {
                const file = event.target.files[0];
                ev.target.textContent += ` ${file.name}`;
                console.log(file.name);
            })
        }
    }
}
</script>
