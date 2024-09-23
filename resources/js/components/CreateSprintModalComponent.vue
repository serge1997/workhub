<template>
    <Button class="w-50 navbar-dialog-btn rounded-2 fs-4 task-description" @click="visibleCreateSprint = !visibleCreateSprint" text icon="pi pi-list-check" />
    <small class="task-description navbar-dialog-btn-desc">Sprint</small>
    <Dialog v-model:visible="visibleCreateSprint" draggable="false" modal header="Create a new sprint" :style="{ width: '65rem' }">
        <div class="row">
           <div class="col-md-10 m-auto">
                <div class="w-75 mb-3">
                    <label for="name">Sprint name</label>
                    <InputText class="w-100" placeholder="sprint name" v-model="sprint.name" />
                    <span v-if="formErrors && formErrors.name" class="text-danger">{{formErrors.name[0]}}</span>
                </div>
               <div class="w-75">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name">Start at</label>
                            <Calendar class="w-100" v-model="sprint.start_at" />
                        </div>
                        <div class="col-md-6">
                            <label for="name">Closed at</label>
                            <Calendar class="w-100" v-model="sprint.close_at" />
                        </div>
                    </div>
               </div>
                <div class="w-75 mb-3">
                    <label for="desc">Description</label>
                    <Textarea v-model="sprint.desc"class="w-100" placeholder="description" />
                </div>
                <div class="w-75">
                    <Button @click="createSprint" label="Salvar" />
                </div>
           </div>
        </div>
    </Dialog>
</template>
<script>

import { useToast } from 'primevue/usetoast';
export default {
    name: 'CreateSprintModalComponent',

    data(){
        return {
            visibleCreateSprint: false,
            sprint: {
                name: null,
                desc: null,
                start_at: null,
                close_at: null,
                generate: false
            },
            formErrors: null,
            toast: useToast()
        }
    },
    methods: {
        createSprint(){
            this.Api.post('sprint', this.sprint)
            .then(async response => {
                this.formErrors = null;
                this.visibleCreateSprint = false;
                this.toast.add({ severity: 'success', summary: 'Error', detail: await response.data, life: 3000});
            })
            .catch(error => {

                if (error.response.status === 422){
                    this.formErrors = error.response.data.errors;
                }
                console.log(this.formErrors)
            })
        }
    },
    mounted(){

    }
}
</script>
