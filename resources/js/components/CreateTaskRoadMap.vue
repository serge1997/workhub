<template>
    <Button @click="visibleCreateRoadMap = !visibleShowTaskModal" text icon="pi pi-map" />
    <Dialog v-model:visible="visibleCreateRoadMap" modal header="Create road map" :style="{ width: '65rem' }">
        <div class="row">
            <div class="col-md-6 d-flex flex-column">
                <div v-for="(title, index) of roadMap.titleInputInc" class="w-100">
                    <div class="w-100 d-flex align-items-center">
                        <Button @click="removeStep(index)" class="text-danger" icon="pi pi-trash" text />
                        <label class="fw-bold" for="">Etapa {{ roadMap.labelIncrement[index] }}</label>
                    </div>
                    <InputText class="w-100 mb-3" v-model="roadMap.titles[index]" placeholder="add step title" />
                    <Textarea  type="text" class="w-100 mb-3" v-model="roadMap.descriptions[index]" placeholder="add step description" />
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column">
                <Button @click="roadMap.titleInputInc.push(1); roadMap.labelIncrement.push(roadMap.labelIncrement[roadMap.labelIncrement.length - 1] + 1)" style="width: 45%;" text icon="pi pi-plus" label="Adicionar Etapa" />
            </div>
        </div>
    </Dialog>
</template>
<script>
export default {
    name: 'CreateTaskRoadMap',

    data(){
        return {
            visibleCreateRoadMap: false,
            roadMap: {
                titles: [],
                descriptions: [],
                titleInputInc: [1],
                labelIncrement: [1]
            }
        }
    },
    methods: {
        removeStep(index) {
            this.roadMap.titleInputInc.splice(index, 1);
            this.roadMap.titles.splice(index, 1);
            this.roadMap.descriptions.splice(index, 1);
        }
    }
}
</script>
