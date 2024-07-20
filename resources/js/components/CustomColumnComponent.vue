<template>
    <Button @click="visibleCustomFiledDialog = true" class="w-75 border rounded-2 fs-4 task-description" text icon="pi pi-plus-circle" />
    <Dialog v-model:visible="visibleCustomFiledDialog" header="Criar campo personlizado" :style="{ width: '25rem' }" position="topcenter" :modal="true" :draggable="false">
        <div class="row">
            <div class="col-md-12 d-flex flex-column  gap-2">
                <label for="username" class="font-semibold">Nome do campo</label>
                <InputText id="username" class="w-100" v-model="custom.label" autocomplete="off" />
            </div>
            <div class="col-md-12 d-flex flex-column  gap-2 mt-3">
                <label for="costumField-description" class="font-semibold">Descripção do campo</label>
                <Textarea id="username" v-model="custom.description" class="w-100" autocomplete="off" />
            </div>
            <div class="col-md-12 d-flex justify-content-end mt-3">
                <Button @click="createCustomColumn" icon="pi pi-save task-description" text></Button>
            </div>
        </div>
    </Dialog>
</template>
<script>
export default {
    name: 'CustomColumnComponent',
    data(){
        return{
            visibleCustomFiledDialog: false,
            custom: {
                label: null,
                description: null
            }
        }
    },
    methods: {
        createCustomColumn(){
            this.Api.post('custom-column', this.custom)
            .then(async response => {
                console.log(response.data)
            })
            .catch(error => {
                console.log(error)
            })
        }
    },
    mounted(){
    }
}
</script>
