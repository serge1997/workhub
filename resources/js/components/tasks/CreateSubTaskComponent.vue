<template>
    <div class="row px-3 d-none" :id="`subtask-box-${taskId}`">
        <div class="col-md-12 p-2 d-flex align-items-center gap-3">
            <InputText class="p-1" placeholder="Titulo da sub tarefa..."/>
            <Button class="p-0" @click="togglePriorityOverlayPanel" severity="secondary" text title="Prioridade">
                <i style="font-size: .8em;" class="pi pi-flag icon-list-task"></i>
            </Button>
            <TaskExecutionOverlayComponent
                :task-status="taskStatus"
            />
            <Button class="p-0" severity="secondary" text title="Annex">
                <i style="font-size: .8em;" class="pi pi-paperclip icon-list-task"></i>
            </Button>
            <Button @click="createSubTask" class="rounded-pill p-1 px-3 small-fw">
                <small>salvar</small>
            </Button>
            <Button @click="$emit('hiddenSubTaskForm', taskId)" class="rounded-pill p-1 px-3 small-fw" severity="secondary">
                <small>cancelar</small>
            </Button>
        </div>
        <div class="col-md-12">
            <OverlayPanel ref="visiblePriorityOverlay">
                <ul class="list-group">
                    <li v-for="priority in priorities" @click="updateTaskPriority" :data-value="priority.value" class="list-group-item d-flex align-items-center border-0 d-flex gap-1 cursor-p">
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
        }
    },
    methods: {
        createSubTask(){
            let status = document.getElementById('selected-task-status')
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
