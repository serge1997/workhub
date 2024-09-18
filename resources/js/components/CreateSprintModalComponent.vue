<template>
    <Button @click="visibleCreateSprint = !visibleCreateSprint" text icon="pi pi-list-check" />
    <Dialog v-model:visible="visibleCreateSprint" draggable="false" modal header="Create a new sprint" :style="{ width: '65rem' }">
        <div class="row">
           <div class="col-md-10 m-auto">
                <div class="w-75 mb-3">
                    <label for="name">Sprint name</label>
                    <InputText class="w-100" placeholder="sprint name" v-model="sprint.name" />
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
                    <Textarea class="w-100" placeholder="description" />
                </div>
                <div class="w-75">
                    <Button label="Salvar" />
                </div>
           </div>
        </div>
    </Dialog>
</template>
<script>

//fields (sprint name, sprint desc, sprint start_at, sprint close_at, sprint created_by)
export default {
    name: 'CreateSprintModalComponent',

    data(){
        return {
            visibleCreateSprint: false,
            sprint: {
                name: null,
                desc: null,
                start_at: null,
                close_at: null
            }
        }
    },
    methods: {

    },
    mounted(){

    }
}
</script>
