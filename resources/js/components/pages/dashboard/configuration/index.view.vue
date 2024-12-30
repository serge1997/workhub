<template>
    <SidebarComponent>
        <div class="container-fluid">
           <div class="row">
                <div class="col-md-2 d-flex flex-column gap-2">
                    <Button text class="d-flex gap-2 task-description">
                        <span>
                            <small><i class="pi pi-users"></i></small>
                        </span>
                        <span>
                            <small>usuarios</small>
                        </span>
                    </Button>
                    <Button text class="d-flex gap-2 task-description">
                        <span>
                            <small><i class="pi pi-tags"></i></small>
                        </span>
                        <span>
                            <small>Projetos</small>
                        </span>
                    </Button>
                </div>
                <div class="col-md-10">
                  <component :is="componentIs"/>
                </div>
           </div>
        </div>
    </SidebarComponent>
</template>
<script>
import { defineAsyncComponent } from 'vue';

export default {
    name: 'Configuration.index',

    components: {
        UsersListComponent: defineAsyncComponent(() =>
            import('../../../configuation/UsersListComponent.vue')
        )
    },
    data(){
        return {
            componentIs: 'UsersListComponent'
        }
    },

    mounted(){

    },
    methods: {

    }
}

</script>
