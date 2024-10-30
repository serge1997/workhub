<template>
    <div class="row">
        <div class="col-md-10 m-auto">
            <div class="row mb-3">
                <label for="project-name">Nome </label>
                <InputText v-model="project.name" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="nome do projeto" />
            </div>
            <div class="row mb-3">
                <label for="project-name">Descrição </label>
                <Textarea v-model="project.descricao" style="background-color: #f3f4f6;" class="w-100 border-0 p-3" placeholder="Descrição do projeto" />
            </div>
            <div class="row mb-4">
                <div class="col-md-6 d-flex flex-column">
                    <label for="project-name">Data inicio </label>
                    <Calendar v-model="project.start_at"/>
                </div>
                <div class="col-md-6 d-flex flex-column">
                    <label for="project-name">Data de termino </label>
                    <Calendar v-model="project.end_at"/>
                </div>
            </div>
            <div class="row">
                <Button class="rounded-pill" label="criar projeto" />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CreateProjectComponent',

    data(){
        return{
            project:{
                name: null,
                descricao: null,
                start_at: null,
                end_at: null
            }
        }
    }
}
</script>
