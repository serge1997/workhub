<template>
    <Button @click="visibleShowTaskModal = !visibleShowTaskModal; $emit('showTask', task_id)" text>
        <i :class="`pi ${openModalIcon} icon-list-task`"></i>
    </Button>
    <Dialog v-model:visible="visibleShowTaskModal" modal header="Showing task info" :style="{ width: '35rem' }">
        <small>Nenhum detalhes a mostrar</small><br>
        <Button text icon="pi pi-map" />
    </Dialog>
</template>
<script>
export default {
    name: 'ShowTaskComponent',

    props: ['openModalIcon', 'task_id'],

    data(){
        return {
            visibleShowTaskModal: false
        }
    }
}
</script>
