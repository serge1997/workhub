<template>
    <div class="w-100">
        <Button @click="toogleStatusListBox(task.id)" class="task-description p-0" icon="pi pi-angle-right" text />
        <Listbox class="w-75 border rounded-2 shadow-sm d-none position-absolute" style="z-index: 999;left: 15%;" @change="handleTaskStatus(task.id)" :id="`task-status-listbox-${task.id}`" v-model="selectedStatus" :options="taskStatus" optionLabel="name">
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
        taskStatus: Object
    },
    data(){
        return{
            toast: useToast()
        }
    },

    methods:{
        toogleStatusListBox(id){
            let box = document.getElementById(`task-status-listbox-${id}`);
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
                let box = document.getElementById(`task-status-listbox-${id}`);
                box.classList.add('d-none')
                this.toast.add({ severity: 'success', summary: 'Message', detail: await response.data, life: 3000 });
                return this.$emit('listAllTask');
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
