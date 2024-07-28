<template>
    <Button @click="openAddFileModal = true" class="task-description btn-icon-show-task" icon="pi pi-paperclip" text/>
    <Dialog v-model:visible="openAddFileModal" maximizable modal header="" :style="{ width: '25em' }">
        <div class="col-md-12 mt-3">
            <div class="col-md-10 d-flex flex-column">
                <label for="task-annex" class="form-label mb-3">Adicionar anexes da tarefa</label>
                <input class="form-control d-none" type="file" name="files[]" ref="inputFiles" id="annex-input" multiple @change="onChangeTaskAnnex">
                <Button id="input-file-upload" class="w-100 rounded-2 d-flex flex-column" @click="taskAnnexHandler">
                    <span class="d-flex gap-2 align-items-center m-auto">
                        <i class="pi pi-file"></i>
                        <span>Upload</span>
                    </span>
                    <span class="d-flex flex-column" id="selected-annexes">
                    </span>
                </Button>
            </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <Button class="task-description" icon="pi pi-save" text/>
        </div>
    </Dialog>
</template>
<script>
export default {
    name: 'AddFileFastlyComponent',

    data(){
        return {
            openAddFileModal: false
        }
    },
    methods:{
        taskAnnexHandler(){
            let inputFile = document.getElementById('annex-input')
            inputFile.click();
        }
    }
}
</script>
