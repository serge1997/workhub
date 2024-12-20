<template>
    <Button @click="toggleMenu" class="task-description btn-text-nowrap  d-flex gap-1" text>
        <span class="d-flex align-items-center">
            <i class="pi pi-slack small-icon"></i>
        </span>
        <span class="small-fw"><small>Projetos</small></span>
    </Button>
    <Menu ref="visibleProjectsMenu" class="rounded-2" :model="projects" :popup="true">
       <template #item="{item, props}">
            <div class="d-flex gap-2 mt-2">
                <router-link class="d-flex align-items-center gap-2 py-1 text-decoration-none" :to="`/dashboard/projects/${item.id}/${item.rand_uuid}`">
                    <span class="small-fw task-description d-flex align-items-center">
                        <i :style="`color: #${item.severity}`" class="pi pi-tags"></i>
                    </span>
                    <span class="task-description">
                        <small>{{ item.name }}</small>
                    </span>
                </router-link>
            </div>
       </template>
    </Menu>
</template>
<script>
import { ref } from 'vue';

export default {
    name: 'ProjectsMenuComponent',

    data(){
        return {
            visibleProjectsMenu: ref(null),
            projects: []
        }
    },
    mounted(){
        this.visibleProjectsMenu = this.$refs.visibleProjectsMenu;
        this.listAllProject();
    },
    methods: {
        listAllProject(){
            this.Api.get('project')
            .then(async response => {
                this.projects = await response.data.data;
            })
        },
        toggleMenu(event){
            this.visibleProjectsMenu.toggle(event);
        }
    }
}

</script>