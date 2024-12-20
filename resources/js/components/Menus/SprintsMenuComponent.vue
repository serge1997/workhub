<template>
    <Button @click="toggleTeamSpaceOverlay" class="task-description btn-text-nowrap  d-flex gap-1" label="Projeto" text>
        <span class="d-flex align-items-center">
            <i class="pi pi-tags small-icon"></i>
        </span>
        <span class="small-fw"><small>Sprints</small></span>
    </Button>
    <Menu ref="visibleToggleSprintsMenu" class="rounded-2" :model="splited_sprints" :popup="true">
       <template #item="{item, props}">
            <div class="d-flex gap-2 mt-2">
                <router-link class="d-flex align-items-center gap-2 py-1 text-decoration-none" :to="`/dashboard/${item.path}`">
                    <span class="task-description small-fw d-flex align-items-center">
                        <i class="pi pi-list-check"></i>
                    </span>
                    <span class="task-description d-flex align-items-center">
                        <small>{{ item.name }}</small>
                    </span>
                </router-link>
            </div>
       </template>
       <template #end>
            <div class="d-flex justify-content-start border-top">
                <Button @click="toggleListAllSprints" class="task-description btn-text-nowrap  d-flex gap-1" label="Projeto" text>
                    <span class="d-flex align-items-center">
                        <i class="pi pi-plus-circle small-icon"></i>
                    </span>
                    <span class="small-fw"><small>{{btnToggleLabel}}</small></span>
                </Button>
            </div>
       </template>
    </Menu>
</template>
<script>
import { ref } from 'vue';
export default {
    name: 'SprintsMenuComponent',

    data(){
        return {
            visibleToggleSprintsMenu: ref(null),
            sprints: [],
            splited_sprints: [],
            btnToggleLabel: "todos..."
        }
    },
    mounted(){
        this.visibleToggleSprintsMenu = this.$refs.visibleToggleSprintsMenu;
        this.listSprints();
    },
    methods: {
        toggleTeamSpaceOverlay(event){
            this.visibleToggleSprintsMenu.toggle(event);
        },
        listSprints(){
            this.Api.get('sprint')
            .then(async response => {
                this.sprints = await response.data;
                this.splited_sprints = this.sprints.slice(0, 4)
            })
        },
        toggleListAllSprints(){
            if (this.splited_sprints.length == this.sprints.length){
                this.btnToggleLabel = "todos...";
                return this.splited_sprints = this.sprints.slice(0, 4)
            }
            this.btnToggleLabel = "menos...";
            this.splited_sprints = this.sprints;
        }
    }
}
</script>
