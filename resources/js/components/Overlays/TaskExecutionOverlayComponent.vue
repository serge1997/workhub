<template>
    <Button @click="toggleTaskStatusOverlay" class="p-0" severity="secondary" text title="Status">
        <i :id="`sub-task-status-icon-${taskId}`" style="font-size: .8em;" class="pi pi-tag icon-list-task"></i>
    </Button>
    <input type="hidden" :id="`selected-task-status-${taskId}`" v-model="selectedStatus" />
    <OverlayPanel ref="visibleTaskStatusOverlay">
        <Listbox class="rounded-2 border-0" @change="handleTaskStatus" v-model="task_execution_status" :options="taskStatus" optionLabel="name">
            <template #option="slotProps">
                <div class="d-flex align-items-center gap-2 border-bottom p-1">
                    <i class="pi pi-circle-fill task-description" :style="{'color': slotProps.option.severity}"></i>
                    <div style="font-size: .8em;" class="task-description">{{ slotProps.option.name }}</div>
                </div>
            </template>
        </Listbox>
    </OverlayPanel>
</template>
<script>
import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';
export default {

    props: {
        taskStatus: Object,
        taskId: Number
    },
    data(){
        return {
            toast: useToast(),
            visibleTaskStatusOverlay: ref(null),
            task_execution_status: null,
            selectedStatus: null
        }
    },

    methods: {
        handleTaskStatus(event){
            this.toggleTaskStatusOverlay(event);
            this.selectedStatus = this.task_execution_status.id;
            document.getElementById(`sub-task-status-icon-${this.taskId}`).style.color = this.task_execution_status.severity;
            this.task_execution_status = null;
        },
        toggleTaskStatusOverlay(event){
            this.visibleTaskStatusOverlay.toggle(event);
        },
    },
    mounted(){
        this.visibleTaskStatusOverlay = this.$refs.visibleTaskStatusOverlay;
    }
}
</script>
