<template>
    <div v-if="teams_space" class="card border-0">
        <div v-for="team in teams_space" class="card-body d-flex p-0">
            <router-link class="card-body d-flex align-items-center justify-content-between nav-link text-dark">
                <div class="icon d-flex gap-1 align-items-center">
                    <img style="width: 43px;" class="rounded-circle shadow-sm d-none" src="/img/project-image.png" />
                    <span style="width: 38px; height: 37px" class="rounded-circle border p-2 py-2 d-flex justify-content-center align-items-center">
                        <i :style="`color: #${team.severity};`" class="pi pi-briefcase task-description"></i>
                    </span>
                    <h6 class="mt-1">{{ team.name }}</h6>
                </div>
            </router-link>
            <div class="meta-data d-flex gap-2 align-items-center">

            </div>
        </div>
    </div>
    <div v-else>
        <p class="p-2 d-flex justify-content-center align-items-center gap-2 border rounded-pill mt-2 text-lowercase text-center fw-medium task-description">
           <span> Nenhum team encontrado </span>
           <span class="task-description d-flex justify-content-center align-items-center"><i class="pi pi-ban"></i></span>
        </p>
    </div>
</template>
<script>
import { useToast } from 'primevue/usetoast';

export default {
    name: 'ProjectHomeListComponent',

    components: {
    },

    data(){
        return {
            teams_space: null
        }
    },
    methods: {
        listAllTeam(){
            this.Api.get('team-space')
            .then(async response => {
                this.teams_space = await response.data.data;
            })
        }
    },
    mounted(){
        this.listAllTeam();
    }
}
</script>
