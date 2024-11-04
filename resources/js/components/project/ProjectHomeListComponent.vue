<template>
    <div class="card border-0">
        <div v-for="project in projects" class="card-body d-flex p-0">
            <router-link class="card-body d-flex align-items-center justify-content-between nav-link text-dark">
                <div class="icon d-flex gap-1 align-items-center">
                    <img style="width: 43px;" class="rounded-circle shadow-sm d-none" src="/img/project-image.png" />
                    <span style="width: 38px; height: 37px" class="rounded-circle border p-2 py-2 d-flex justify-content-center align-items-center">
                        <i :style="`color: #${project.severity};`" class="pi pi-briefcase task-description"></i>
                    </span>
                    <h6 class="mt-1">{{ project.name }}</h6>
                </div>
            </router-link>
            <div class="meta-data d-flex gap-2 align-items-center">
                <TaskOverlayComponent :project="project" />
                <UsersOverlayComponent :project="project" />
            </div>
        </div>
    </div>
</template>
<script>
import { useToast } from 'primevue/usetoast';
import UsersOverlayComponent from '../Overlays/UsersOverlayComponent.vue';
import TaskOverlayComponent from '../Overlays/TaskOverlayComponent.vue';
export default {
    name: 'ProjectHomeListComponent',

    components: {
        UsersOverlayComponent,
        TaskOverlayComponent
    },

    data(){
        return {
            projects: null
        }
    },
    methods: {
        listAllProject(){
            this.Api.get('project')
            .then(async response => {
                this.projects = await response.data.data;
            })
        }
    },
    mounted(){
        this.listAllProject();
    }
}
</script>
