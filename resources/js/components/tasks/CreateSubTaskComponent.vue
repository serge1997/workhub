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
            <input type="file" ref="sub_task_annexes" @change="handleSubTaskFile" class="d-none" :id="`sub-task-annexes-${taskId}`" />
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
import { useToast } from 'primevue/usetoast';
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
            annexes: [],
            toast: useToast(),
            postData: new FormData
        }
    },
    methods: {
        uploadSubTaskAnnex(id){
            const inputFile = document.getElementById(`sub-task-annexes-${id}`);
            inputFile.click();
        },
        handleSubTaskFile(event){
            this.annexes.push(event.target.files[event.target.files.length - 1]);
            const files = this.$refs.sub_task_annexes.files;
            for(let i = 0; i < files.length; i++){
                this.postData.append('annex[]', files[i]);
            }
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
           this.postData.append('execution_status_id', status);
           this.postData.append('priority', this.selected_priority);
           this.postData.append('title', this.sub_task_title);
           this.postData.append('sub_task', true);
           this.postData.append('task_id', this.taskId)
           this.Api.post('sub-task', this.postData)
           .then(async response => {
                document.getElementById(`sub_task_title-${this.taskId}`).value = null;
                this.toast.add({severity: 'success', summary: 'successo', detail: await response.data.message, life: 3000})
                document.getElementById(`subtask-box-${this.taskId}`).classList.add('d-none');
                this.$emit('updateSubTaskListUi');
           })
           .catch(error => {
            this.toast.add({severity: 'error', summary: 'error', detail: error.response.data.message, life: 3000})
           })
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
