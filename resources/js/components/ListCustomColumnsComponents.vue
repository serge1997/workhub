<template>
    <Button @click="visibleAddTaskCustomColumn = true" class="task-description" icon="pi pi-plus-circle" text/>
    <Dialog v-model:visible="visibleAddTaskCustomColumn" maximizable modal header="" :style="{ width: '25em' }">
        <div class="col-md-12">
            <MultiSelect :options="customColumns" v-model="taskCustomColumns.columns" optionLabel="label" optionValue="id" class="w-100" id="custom-column" placeholder="Choose custom column" :maxSelectedLabels="3" />
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <Button class="task-description" icon="pi pi-save" text/>
        </div>
    </Dialog>
</template>
<script>
export default {
    name: 'ListCustomColumnsComponents',

    props: {
        task_id: Number
    },

    data(){
        return {
            customColumns: null,
            visibleAddTaskCustomColumn: false,
            taskCustomColumns: {
                columns: [],
            }
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
        }
    },
    mounted(){
        this.getAllCustomColumns();
    }

}
</script>
