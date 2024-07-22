<template>
    <Button @click="visibleCustomFiledDialog = true" class="w-75 border rounded-2 fs-4 task-description" text icon="pi pi-plus-circle" />
    <Dialog v-model:visible="visibleCustomFiledDialog" header="Criar campo personlizado" :style="{ width: '25rem' }" position="topcenter" :modal="true" :draggable="false">
        <div class="row">
            <div class="col-md-12 d-flex flex-column  gap-2">
                <label for="username" class="font-semibold">Nome do campo</label>
                <InputText id="username" class="w-100" :class="invalidInput" v-model="custom.label" autocomplete="off" />
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
            },
            invalidInput: null,
        }
    },
    methods: {
        createCustomColumn(){
            if(this.custom.label === null || this.custom.label === undefined){
                this.invalidInput = "border border-danger"
                return this.toaster("Label é obrigatorio", "error").fire();
            }
            this.Api.post('custom-column', this.custom)
            .then(async response => {
                this.toaster(await response.data, "success").fire();
                this.custom.description = null;
                this.custom.label = null;
                this.invalidInput = null;
            })
            .catch(error => {
                console.log(error)
            })
        },
        toaster(response, icon){
            const Toast = this.$swal.mixin({
                text: response,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                icon: icon,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = this.$swal.stopTimer;
                    toast.onmouseleave = this.$swal.resumeTimer;
                }
            });
            return Toast
        },

    },
    mounted(){
    }
}
</script>
