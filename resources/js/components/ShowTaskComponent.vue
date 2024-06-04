<template>
    <Button @click="visibleShowTaskModal = !visibleShowTaskModal" text icon="pi pi-eye" />
    <Dialog v-model:visible="visibleShowTaskModal" modal header="Showing task info" :style="{ width: '35rem' }">
        <small>Nenhum detalhes a mostrar</small><br>
        <Button text icon="pi pi-map" />
    </Dialog>
</template>
<script>
export default {
    name: 'ShowTaskComponent',

    data(){
        return {
            visibleShowTaskModal: false
        }
    }
}
</script>
