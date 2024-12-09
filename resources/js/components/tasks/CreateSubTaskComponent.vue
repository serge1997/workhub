<template>
    <div class="row px-3 d-none" :id="`subtask-box-${taskId}`">
        <div class="col-md-12 p-2 d-flex align-items-center gap-3">
            <InputText style="width: 280px;" class="p-1 px-3 border-bottom" v-model="sub_task_title" :id="`sub_task_title-${taskId}`" placeholder="titulo da sub tarefa..."/>
            <Button class="p-0" @click="togglePriorityOverlayPanel" severity="secondary" text title="Prioridade">
                <i :id="`sub-task-priority-icon-${taskId}`" style="font-size: .8em;" class="pi pi-flag icon-list-task"></i>
            </Button>
            <TaskExecutionOverlayComponent
                :task-status="taskStatus"
                :task-id="taskId"
            />
            <input type="file" @change="handleSubTaskFile" class="d-none" :id="`sub-task-annexes-${taskId}`" />
            <Button @click="uploadSubTaskAnnex(taskId)" class="p-0" severity="secondary" text title="Annex">
                <i style="font-size: .8em;" class="pi pi-paperclip icon-list-task"></i>
            </Button>
            <Button @click="createSubTask(taskId)" class="rounded-pill p-1 px-3 small-fw">
                <small>salvar</small>
            </Button>
            <Button @click="$emit('hiddenSubTaskForm', taskId)" class="rounded-pill p-1 px-3 small-fw" severity="secondary">
                <small>cancelar</small>
            </Button>
        </div>
        <div class="col-md-12">
            <OverlayPanel ref="visiblePriorityOverlay" id="priority-overlay-panel">
                <ul class="list-group">
                    <li v-for="priority in priorities" @click="updateTaskPriority(priority.value)" :data-value="priority.value" class="list-group-item d-flex align-items-center border-0 d-flex gap-1 cursor-p">
                        <i class="pi pi-circle-fill" :class="`text-${priority.severity}`"></i>
                        <span>{{ priority.label }}</span>
                    </li>
                </ul>
            </OverlayPanel>
        </div>
    </div>
</template>
<script>
import { defineAsyncComponent, ref } from 'vue';
import TaskExecutionOverlayComponent from '../Overlays/TaskExecutionOverlayComponent.vue';
export default {
    name: 'CreateSubTaskComponent',

    components: {
        TaskExecutionOverlayComponent: defineAsyncComponent(() =>
            import('../Overlays/TaskExecutionOverlayComponent.vue')
        )
    },
    props: {
        taskStatus: Object,
        taskId: Number
    },
    data(){
        return {
            visiblePriorityOverlay: ref(null),
            priorities: [
                {value: "ALT", label: "Alta", severity: "danger"},
                {value: "MED", label: "Media", severity: "warning"},
                {value: "BAX", label: "Baixa", severity: "success"}
            ],
            selected_priority: null,
            sub_task_title: null,
            annexes: []
        }
    },
    methods: {
        uploadSubTaskAnnex(id){
            const inputFile = document.getElementById(`sub-task-annexes-${id}`);
            inputFile.click();
        },
        handleSubTaskFile(event){
            this.annexes.push(event.target.files[event.target.files.length - 1]);
            console.log(this.annexes);
        },
        updateTaskPriority(value){
            this.selected_priority = value;
            const severity = this.priorities.find(priority => priority.value == value);
            document.getElementById(`sub-task-priority-icon-${this.taskId}`).classList.forEach(cl => {
                if (cl.includes('text-')){
                    document.getElementById(`sub-task-priority-icon-${this.taskId}`).classList.remove(cl);
                }
            })
            document.getElementById(`sub-task-priority-icon-${this.taskId}`).classList.add(`text-${severity.severity}`)
            this.togglePriorityOverlayPanel(document.getElementById('priority-overlay-panel'))
        },
        createSubTask(id){
            let status = document.getElementById('selected-task-status-'+id).value;
            const data = new FormData;
            data.append('execution_status_id', status);
            data.append('priority', this.selected_priority);
            data.append('title', this.sub_task_title);
            data.append('annexes', this.annexes);
            data.append('sub_task', true);
           this.Api.post('task', data)
        },
        togglePriorityOverlayPanel(event){
            this.visiblePriorityOverlay.toggle(event);
        }
    },
    mounted(){
        this.visiblePriorityOverlay = this.$refs.visiblePriorityOverlay;
    }
}
</script>
<style scoped>

</style>
