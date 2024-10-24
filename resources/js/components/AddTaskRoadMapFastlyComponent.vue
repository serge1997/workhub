<template>
    <Button @click="openAddRoadMapModal" class="task-description btn-icon-show-task" icon="pi pi-plus-circle" text/>
    <Dialog v-model:visible="visibleAddTaskRoadMap" maximizable modal header="" :style="{ width: '25em' }">
        <div class="col-md-12 mt-3">
            <div class="w-100 mb-3 d-flex flex-column gap-1">
                <InputText v-model="roadMap.road_map_titles" class="w-100 border-0 border-bottom rounded-0" :class="invalid" id="add-roadmap-input" placeholder="titulo"/>
                <small class="text-danger" v-if="formError" v-for="title in formError.road_map_titles" v-text="title"></small>
            </div>
            <div class="w-100">
                <Textarea v-model="roadMap.road_map_descriptions" class="w-100 border-0 border-bottom rounded-0" placeholder="Descrição" />
            </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <Button @click="createFastRoadMap" class="task-description" icon="pi pi-save" text/>
        </div>
    </Dialog>
</template>
<script>
import { useToast } from "primevue/usetoast";
import { when } from "../core/utilities.mjs";
export default{
    name: 'AddTaskRoadMapFastlyComponent',
    props: {
        task: Object
    },

    data(){
        return {
            visibleAddTaskRoadMap: false,
            roadMap: {
                road_map_titles: null,
                road_map_descriptions: null
            },
            toast: useToast(),
            formError: null,
            invalid: null,
        }
    },
    methods: {
        openAddRoadMapModal(){
            this.visibleAddTaskRoadMap = true;
            setTimeout(() => {
                let input = document.getElementById('add-roadmap-input')
                input.focus()
            }, 100)
        },
        createFastRoadMap(){
            Reflect.set(this.roadMap, 'task_id', this.task.id);
            this.Api.post('task-road-map', this.roadMap)
            .then(async response => {
                this.invalid = null;
                this.formError = null;
                this.roadMap.road_map_descriptions = null;
                this.roadMap.road_map_titles = null;
                this.toast.add({ severity: 'success', summary: 'Message', detail: await response.data, life: 3000 });
                this.$emit('updateUi');
            })
            .catch(error => {
                console.log(error)
                this.formError = error.response.data.errors;
                this.invalid = 'border border-dange'
                when(error.response.status == 500,
                    this.toast.add({ severity: 'error', summary: 'Erro', detail: error.response.data, life: 3000 })
                );
            })
        }
    },
    mounted(){

    }
}
</script>
