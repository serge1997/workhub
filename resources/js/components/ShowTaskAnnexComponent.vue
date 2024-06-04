<template>
    <Button @click="visibleShowAnnexModal = !visibleShowAnnexModal" text icon="pi pi-paperclip" />
    <Dialog v-model:visible="visibleShowAnnexModal" modal header="Task annexe(s)" :style="{ width: '35rem' }">
        <small>Nenhum arquivo anexado</small>
    </Dialog>
</template>
<script>
export default {
    name: 'ShowTaskAnnexComponent',

    data(){
        return {
            visibleShowAnnexModal: false
        }
    }
}

</script>
