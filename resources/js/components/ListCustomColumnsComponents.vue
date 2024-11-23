<template>
    <Button @click="visibleAddTaskCustomColumn = true" class="task-description" icon="pi pi-plus-circle" text/>
    <Dialog v-model:visible="visibleAddTaskCustomColumn" maximizable modal header="" :style="{ width: '25em' }">
        <div class="col-md-12">
            <MultiSelect :options="customColumns" v-model="taskCustomColumns.columns" optionLabel="label" optionValue="id" class="w-100" id="custom-column" placeholder="Choose custom column" :maxSelectedLabels="3" />
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <Button @click="createByTask" class="task-description" icon="pi pi-save" text/>
        </div>
    </Dialog>
</template>
<script>
import { useToast } from 'primevue/usetoast';
export default {
    name: 'ListCustomColumnsComponents',

    props: {
        task_id: Number,
    },

    data(){
        return {
            customColumns: null,
            visibleAddTaskCustomColumn: false,
            taskCustomColumns: {
                columns: [],
            },
            toast: useToast()
        }
    },
    methods:{
        getAllCustomColumns(){
            this.Api.get('custom-column/task', {task_id: this.task_id})
            .then(async response => {
                this.customColumns = await response.data;
            })
            .catch(error => {
                console.log(error);
            })
        },
        createByTask(){
            Reflect.set(this.taskCustomColumns, 'task_id', this.task_id);
            this.Api.post('custom-column-value/task', this.taskCustomColumns)
            .then(async response => {
                this.visibleAddTaskCustomColumn = false;
                this.toast.add({ severity: 'success', summary: 'Task', detail: response.data , life: 3000 });
                this.$emit('updateUi');
            })
            .catch(error => {
                console.log(error)
            })
        },
    },
    mounted(){
        this.getAllCustomColumns();
    }

}
</script>
