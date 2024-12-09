<template>
    <div class="col-md-4">
        <Tag style="cursor: pointer;" @click="toogleStatusListBox(task.id)" icon="pi pi-chevron-down v-small-fs" class="p-2" severity="secondary" :value="tagValue" />
        <Listbox class="border rounded-2 shadow-sm d-none position-absolute" style="z-index: 999;right: 0%; width: 240px;" @change="handleTaskStatus(task.id)" :id="`task-status-listbox-${componentName}-${task.id}`" v-model="selectedStatus" :options="taskStatus" optionLabel="name">
            <template #option="slotProps">
                <div class="d-flex align-items-center gap-2 border-bottom p-1">
                    <i class="pi pi-circle-fill task-description" :style="{'color': slotProps.option.severity}"></i>
                    <div style="font-size: .8em;" class="task-description">{{ slotProps.option.name }}</div>
                </div>
            </template>
        </Listbox>
    </div>
</template>
<script>
import { useToast } from 'primevue/usetoast';
export default{
    name: 'ListTaskExecutionStatusComponent',

    props:{
        task: Object,
        taskStatus: Object,
        componentName: String,
        btnLabel: String,
        tagSeverity: String,
        tagValue: String
    },
    data(){
        return{
            toast: useToast()
        }
    },

    methods:{
        toogleStatusListBox(id){
            let box = document.getElementById(`task-status-listbox-${this.componentName}-${id}`);
            if (box.classList.contains('d-none')){
                return box.classList.remove('d-none')
            }
            box.classList.add('d-none')

        },

        handleTaskStatus(id){
            const data = {
                execution_status_id: this.selectedStatus.id,
                task_id: id
            }
            this.Api.put('task/execution-status', data)
            .then(async response => {
                let box = document.getElementById(`task-status-listbox-${this.componentName}-${id}`);
                box.classList.add('d-none')
                this.toast.add({ severity: 'success', summary: 'Message', detail: await response.data, life: 3000 });
                this.$emit('listAllTask');
                this.selectedStatus = null;
            })
            .catch(error => {
                console.log(error)
            })
        },
    },
    mounted(){
    }
}
</script>
