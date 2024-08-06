<template>
    <div class="w-100 position-relative">
        <Button @click="toogleStatusListBox(task.id)" class="task-description p-0" icon="pi pi-angle-right" text />
        <Listbox @change="handleTaskStatus(task.id)" :id="`task-status-listbox-${task.id}`" v-model="selectedStatus" :options="task_status" optionLabel="name" style="z-index: 1000;" class="w-25 position-fixed border rounded-2 shadow-sm d-none">
            <template #option="slotProps">
                <div class="d-flex align-items-center gap-2 border-bottom p-1">
                    <i class="pi pi-circle-fill task-description" :style="{'color': slotProps.option.severity}"></i>
                    <div>{{ slotProps.option.name }}</div>
                </div>
            </template>
        </Listbox>
    </div>
</template>
<script>
export default{
    name: 'ListTaskExecutionStatusComponent',

    props:{
        task: Object
    },
    data(){
        return{
            task_status: null
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
        onListAllTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.task_status = await response.data;
            })
            .catch(err => {
                console.log(err);
            })
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
        this.onListAllTaskExecutionStatus()
    }
}
</script>
