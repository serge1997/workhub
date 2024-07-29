<template>
    <Button @click="visibleShowTaskModal = !visibleShowTaskModal; $emit('showTask', task_id)" text>
        <i :class="`pi ${openModalIcon} icon-list-task`"></i>
    </Button>
    <Dialog v-model:visible="visibleShowTaskModal" modal header="" :style="{ width: '85rem' }">
        <div v-if="taskFinded" class="row">
            <div class="col-md-8">
                <input type="hidden" id="task-id-show" :value="taskFinded.id">
                <div class="row">
                    <div v-if="taskFinded.user_name" class="col-md-12 mb-3 d-flex align-items-center gap-2 border-bottom p-2" id="task-header">
                        <span>
                            <Chip :image="`/img/users_avatars/${taskFinded.user_name.avatar}`" :label="taskFinded.user_name.name" />
                        </span>
                        <span class="d-flex">
                            <span><Chip class="rounded-0" label="prioridade"/></span>
                            <Tag :severity="setSeverity(taskFinded.priority)" :value="taskFinded.priority_fullDescription" />
                        </span>
                        <span class="d-flex">
                            <span><Chip class="rounded-0" label="status"/></span>
                            <Tag class="py-0" :severity="setStatusSeverity(taskFinded.execution_status)" :value="taskFinded.full_task_execution_status" />
                        </span>
                        <span class="d-flex">
                            <Tag class="py-2 bg-secondary" icon="pi pi-clock" :value="taskFinded.execution_delay" />
                        </span>
                        <span>
                            <AddTaskRoadMapFastlyComponent
                                :task="taskFinded"
                            />
                        </span>
                        <span>
                            <AddFileFastlyComponent
                                :task="taskFinded"
                            />
                        </span>
                    </div>
                    <div class="col-md-12 mb-1">
                        <h2 class="task-title text-capitalize">{{ taskFinded.title }}</h2>
                    </div>
                    <div class="col-md-12 p-2">
                        <p>{{ taskFinded.description }}</p>
                    </div>
                </div>
                <div v-if="taskFinded.roads_map" class="row" id="road-map">
                    <div v-for="road of taskFinded.roads_map" class="col-md-12">
                        <h6 class="fw-bolder">{{ road.title }}</h6>
                        <div class="w-75">
                            <p>{{ road.description }}</p>
                        </div>
                    </div>
                </div>
                <div v-if="taskFinded.annexes" class="row d-flex justify-content-center flex-wrap" id="task-annexes">
                    <div v-for="annex of taskFinded.annexes" class="col-md-4">
                        <Button @click="showAnnex(annex.annex)" class="border rounded-2 p-3 d-flex flex-column w-100 gap-1" text>
                            <span>
                                <i class="pi pi-file-pdf fs-3 task-description"></i>
                            </span>
                            <span>
                                <small class="task-description">{{ annex.annex_type }}</small>
                            </span>
                        </Button>
                    </div>
                </div>
                <div v-if="taskFinded.customColumnValue" class="row mt-4">
                    <div class="com-md-12 mb-3 border-0 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="">Colunas personalizadas</h4>
                            <ListCustomColumnsComponents :task_id="taskFinded.id"/>
                        </div>
                    </div>
                    <div v-for="custom in taskFinded.customColumnValue" class="col-md-10 d-flex justify-content-between align-items-center gap-2 mb-4">
                        <label class="text-capitalize custom-column-label" for="">{{ custom.label}}</label>
                        <InputText @blur="$emit('createCustomValue', custom.custom_column_id, custom.value.length)" :id.trim="`custom-value-${custom.custom_column_id}`" class="w-75 border-0 border-bottom rounded-0 custom-column-input" :value="custom.value"/>
                    </div>
                </div>
            </div>
            <div class="col-md-4 task-activities-box rounded-1">
                <div class="row">
                    <div class="col-md-10 p-4">
                        <h6>Atividades no task</h6>
                    </div>
                </div>
            </div>
        </div>
        <Button text icon="pi pi-map" />
        <Dialog v-model:visible="visibleShowAnnex" class="min-vh-100" maximizable modal header="" :style="{ width: '100%' }">
            <iframe class="iframe min-vh-100" :src="`/task-annex/${annex}`" width="100%" height="100%" frameborder="0"></iframe>
        </Dialog>

    </Dialog>
</template>
<script>
import ListCustomColumnsComponents from './ListCustomColumnsComponents.vue';
import AddTaskRoadMapFastlyComponent from './AddTaskRoadMapFastlyComponent.vue';
import AddFileFastlyComponent from './AddFileFastlyComponent.vue';
export default {
    name: 'ShowTaskComponent',

    props: ['openModalIcon', 'task_id', 'taskFinded', 'customColumns'],
    components: {
        ListCustomColumnsComponents,
        AddTaskRoadMapFastlyComponent,
        AddFileFastlyComponent
    },

    data(){
        return {
            visibleShowTaskModal: false,
            visibleShowAnnex: false,
            task: {
                progress: "PRO",
                waiting: "WAT",
                concluded: "CON",
                height: "ALT",
                medium: "MED",
                low: "BAX"
            },
            annex: null,
        }
    },
    methods:{
        executionStatus(status){
            switch(status) {
                case this.task.waiting :
                    return "danger"
            }
        },
        handleTaskStatus(){

        },
        showAnnex(annex){
            this.annex = annex;
            this.visibleShowAnnex = true;
            setTimeout(() => {
                const iframHeader = document.querySelector('.iframe')
                //iframHeader.classList.add('d-none')
            }, 1000)
        },
        setSeverity(priority){
            if(priority === "ALT")  return "danger";
            if (priority === "MED") return "warning";
            return "success";
        },
        setStatusSeverity(status){
            if(status === "WAT")  return "warning";
            if (status === "PRO") return "primary";
            return "success";
        }
    },
    created(){

    },
    mounted(){
    }
}
</script>
<style scoped>
.task-title{
    font-weight: 600;
}
.custom-column-label{
    font-weight: 600;
}

.custom-column-input{
    background-color: #f1f5f9;
}
.task-activities-box{
    background-color: #f1f5f9;
}
</style>
