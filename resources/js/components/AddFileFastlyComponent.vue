<template>
    <Button @click="openAddFileModal = true" title="adicionar um annex na tarefa" class="task-description btn-icon-show-task border-0" icon="pi pi-paperclip" text/>
    <Dialog v-model:visible="openAddFileModal" maximizable modal header="Novo annexo" :style="{ width: '25em' }">
        <div class="col-md-12 mt-3">
            <div class="col-md-10 d-flex flex-column">
                <label for="task-annex" class="form-label mb-3">Adicionar anexes da tarefa</label>
                <input class="form-control d-none" type="file" name="files[]" ref="inputFiles" id="annex-input" multiple @change="onChangeTaskAnnex">
                <Button id="input-file-upload" class="w-100 rounded-2 d-flex flex-column" @click="taskAnnexHandler">
                    <span class="d-flex gap-2 align-items-center m-auto">
                        <i class="pi pi-file"></i>
                        <span>Upload</span>
                    </span>
                </Button>
                <span class="d-flex flex-column" id="selected-annexes"></span>
            </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <Button @click="createAnnex" class="task-description" icon="pi pi-save" text/>
        </div>
    </Dialog>
</template>
<script>
import { useToast } from 'primevue/usetoast';
export default {
    name: 'AddFileFastlyComponent',

    props: {
        task: Object
    },

    data(){
        return {
            openAddFileModal: false,
            annex: new FormData(),
            toast: useToast()
        }
    },
    methods:{
        taskAnnexHandler(){
            let inputFile = document.getElementById('annex-input');
            inputFile.click();
        },
        onChangeTaskAnnex(){
            let selected = document.getElementById('selected-annexes');
            let files = this.$refs.inputFiles.files;
            for (let i = 0; i < files.length; i++){
                this.annex.append('annex[]', files[i]);
                selected.innerHTML += `<smal class="task-description">${files[i].name}</small>`;
            }
        },
        createAnnex(){
            //const data = new FormData();
            //data.append('annex[]', this.$refs.inputFiles.files);
            this.annex.append('task_id', this.task.id)
            this.Api.post('annex', this.annex)
            .then(async response => {
                this.toast.add({ severity: 'success', summary: 'Message', detail: await response.data, life: 3000 });
                this.openAddFileModal = false;
                this.$emit('updateUi');
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
}
</script>
