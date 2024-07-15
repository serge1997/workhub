<template>
    <Button @click="visibleShowTaskModal = !visibleShowTaskModal; $emit('showTask', task_id)" text>
        <i :class="`pi ${openModalIcon} icon-list-task`"></i>
    </Button>
    <Dialog v-model:visible="visibleShowTaskModal" modal header="" :style="{ width: '45rem' }">
        <div class="row">
            <div v-if="taskFinded" class="col-md-12 m-auto">
                <div class="row">
                    <div v-if="taskFinded.user_name" class="col-md-12 mb-3 d-flex align-items-center gap-2 border-bottom p-2" id="task-header">
                        <span>
                            <Chip :image="`/img/users_avatars/${taskFinded.user_name.avatar}`" :label="taskFinded.user_name.name" />
                        </span>
                        <span>
                            <Tag :severity="setSeverity(taskFinded.priority)" :value="taskFinded.priority_fullDescription" />
                        </span>
                        <span>
                            <Button @click="openAddRoadMapModal" class="task-description" icon="pi pi-plus-circle" text/>
                        </span>
                    </div>
                    <div class="col-md-12 mb-1">
                        <h3>{{ taskFinded.title }}</h3>
                    </div>
                    <div class="col-md-12 p-2">
                        <p>{{ taskFinded.description }}</p>
                    </div>
                </div>
                <div v-if="taskFinded.roads_map" class="row" id="road-map">
                    <div v-for="road of taskFinded.roads_map" class="col-md-12">
                        <h6 class="fw-bolder">{{ road.title }}</h6>
                        <div class="w-100">
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
            </div>
        </div>
        <div class="row mt-4">
            <div v-for="custom in customColumns" class="col-md-12 d-flex align-items-center gap-2 mb-4">
                <label for="">{{ custom.label}}</label>
                <InputText class="col-md-8" placeholder="custom column value"/>
            </div>
        </div>
        <Button text icon="pi pi-map" />
        <Dialog v-model:visible="visibleShowAnnex" class="min-vh-100" maximizable modal header="" :style="{ width: '100%' }">
            <iframe class="iframe min-vh-100" :src="`/task-annex/${annex}`" width="100%" height="100%" frameborder="0"></iframe>
        </Dialog>
        <Dialog v-model:visible="visibleAddTaskRoadMap" maximizable modal header="" :style="{ width: '25em' }">
            <div class="col-md-12">
                <InputText class="w-100 border-0 border-bottom rounded-0" id="add-roadmap-input" placeholder="Addiconnar guia para a tarefa"/>
            </div>
            <div class="col-md-12 d-flex justify-content-end">
                <Button class="task-description" icon="pi pi-save" text/>
            </div>
        </Dialog>
    </Dialog>
</template>
<script>
export default {
    name: 'ShowTaskComponent',

    props: ['openModalIcon', 'task_id', 'taskFinded', 'customColumns'],

    data(){
        return {
            visibleShowTaskModal: false,
            visibleShowAnnex: false,
            visibleAddTaskRoadMap: false,
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
        openAddRoadMapModal(){
            this.visibleAddTaskRoadMap = true;
            setTimeout(() => {
                let input = document.getElementById('add-roadmap-input')
                input.focus()
                console.log(input);
            }, 100)
        },
        showAnnex(annex){
            this.annex = annex;
            this.visibleShowAnnex = true;
            setTimeout(() => {
                const iframHeader = document.querySelector('.iframe')
                console.log(iframHeader)
                //iframHeader.classList.add('d-none')
            }, 1000)
        },
        setSeverity(priority){
            if(priority === "ALT")  return "danger";
            if (priority === "MED") return "warning";
            return "success";
        }
    },
    mounted(){
    }
}
</script>
