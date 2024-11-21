<template>
    <div class="row">
        <div class="col-md-10 m-auto">
            <div class="row mb-3">
                <label for="project-name">Nome </label>
                <InputText v-model="team_space.name" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="nome do projeto" />
                <small class="text-danger" v-text="formError"></small>
            </div>
            <div class="row mb-3">
                <label for="project-name">Descrição </label>
                <Textarea v-model="team_space.description" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="Descrição do projeto" />
            </div>
            <div class="row">
                <Button @click="createProject" class="rounded-pill mt-4" label="criar um team" />
            </div>
        </div>
    </div>
</template>
<script>
import { DateTime } from '../core/DateTime';
import { useToast } from 'primevue/usetoast';

export default {
    name: 'CreateTeamSpaceComponent',

    data(){
        return{
            team_space:{
                name: null,
                description: null,
            },
            toast: useToast(),
            formError: null
        }
    },
    methods: {
        createProject(){
            this.Api.post('team-space', this.team_space)
            .then(async response => {
                this.formError =null;
                this.clearInputs();
                this.toast.add({ severity: 'success', summary: 'Successo', detail: await response.data.message, life: 3000 })
            })
            .catch(error => {
                this.formError = error.response.data.message;
                this.toast.add({ severity: 'error', summary: 'Error', detail: error.response.data.message, life: 3000 })
            })

        },
        clearInputs(){
            this.team_space.name = null;
            this.team_space.description = null
        }
    }
}
</script>
<style scoped>

</style>
