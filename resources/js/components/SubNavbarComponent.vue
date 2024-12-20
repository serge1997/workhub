<template>
    <div class="container-fluid p-0 mb-4">
        <Toolbar class="p-0 border-0 bg-transparent border-bottom">
            <template #start>
                <div class="d-flex w-100">
                    <TeamSpaceMenuComponent />
                    <SprintsMenuComponent />
                    <ProjectsMenuComponent />
                    <Button class="task-description d-flex gap-1 btn-text-nowrap " label="Projeto" text>
                        <span class="d-flex align-items-center">
                            <i class="pi pi-cog small-icon"></i>
                        </span>
                        <span class="small-fw"><small>Configurações</small></span>
                    </Button>
                </div>
            </template>
        </Toolbar>
    </div>
</template>
<script>
import { defineAsyncComponent } from 'vue';
export default {
    name: 'SubNavbarComponent',

    components: {
        TeamSpaceMenuComponent: defineAsyncComponent(() =>
            import('./Menus/TeamSpaceMenuComponent.vue')
        ),
        SprintsMenuComponent: defineAsyncComponent(() =>
            import('./Menus/SprintsMenuComponent.vue')
        ),
        ProjectsMenuComponent: defineAsyncComponent(() =>
            import('./Menus/ProjectsMenuComponent.vue')
        )
    },

    data(){
        return{
        }
    },
    methods: {

    },
    mounted(){

    }
}
</script>
