<template>
    <Button @click="toggleUserOverlayPanel" text>
        <Tag :severity="severity" class="cursor-p" :value="`${entityPriority ?? 'prioridade'}`" icon="pi pi-angle-down" />
    </Button>
    <OverlayPanel ref="visibleOverlayPanel" style="width: 300px;">
        <ul class="list-group">
            <li v-for="priority in priorities" @click="updateTaskPriority" :data-value="priority.value" class="list-group-item d-flex align-items-center border-0 d-flex gap-1 cursor-p">
                <i class="pi pi-circle-fill" :class="`text-${priority.severity}`"></i>
                <span>{{ priority.label }}</span>
            </li>
        </ul>
    </OverlayPanel>
</template>
<script>
import { useToast } from 'primevue/usetoast';
export default {
    name: 'PriorityOverlayComponent',
    props: {
        entityPriority: String,
        entityPriorityValue: Number,
        severity: String,
        task: Object
    },
    data(){
        return {
            priorities: [
                {value: "ALT", label: "Alta", severity: "danger"},
                {value: "MED", label: "Media", severity: "warning"},
                {value: "BAX", label: "Baixa", severity: "success"}
            ],
            visibleOverlayPanel: null,
            toast: useToast()
        }
    },
    methods: {
        toggleUserOverlayPanel(event){
            this.visibleOverlayPanel.toggle(event);
        },
        updateTaskPriority(event){
            this.toggleUserOverlayPanel(event);
            let value = this.eventTargetValue(event, 'LI', 'data-value');
            if (value != this.task.priority){
                this.Api.put('task/priority', {task_id: this.task.id, priority: value})
                    .then(async response => {
                        this.toast.add({severity: 'success', detail: response.data.message, life: 1000});
                        this.$emit('updateUi');
                    })
                    .catch(error => {
                        this.toast.add({severity: 'error', detail: error.response.data.message, life: 1000})
                    })
            }
        },
        eventTargetValue(event, node_name, data_attribute){
            let target = event.target;

            if (node_name == target.nodeName){
                return target.getAttribute(data_attribute);
            }
            return target.parentNode.getAttribute(data_attribute);
        }
    },
    mounted(){
        this.visibleOverlayPanel = this.$refs.visibleOverlayPanel;
    }
}
</script>
