<template>
    <Button @click="onToggleTeamSpaceOverlay" class="task-description btn-text-nowrap  d-flex gap-1" label="Projeto" text>
        <span class="d-flex align-items-center">
            <i class="pi pi-users small-icon"></i>
        </span>
        <span class="small-fw"><small>Teams</small></span>
    </Button>
    <Menu ref="toggleTeamSpaceOverlay" class="rounded-2" :model="teams" :popup="true">
       <template #item="{item, props}">
            <div class="d-flex gap-2 mt-2">
                <router-link class="d-flex gap-2 py-1 text-decoration-none" :to="`/${item.path}`">
                    <Tag severity="secondary" class="px-2" :value="item.first_letter"/>
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
    name: 'TeamSpaceMenuComponent',

    data(){
        return {
            toggleTeamSpaceOverlay: ref(null),
            teams: []
        }
    },
    mounted(){
        this.toggleTeamSpaceOverlay = this.$refs.toggleTeamSpaceOverlay;
        this.listAllTeam()
    },
    methods: {
        onToggleTeamSpaceOverlay(event){
            this.toggleTeamSpaceOverlay.toggle(event);
        },
        listAllTeam(){
            this.Api.get('team-space')
            .then(async response => {
                this.teams = await response.data.data;
            })
        },
    }
}
</script>
