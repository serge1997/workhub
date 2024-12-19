<template>
    <div class="container-fluid m-auto p-0">
        <NavbarComponent
            @watch-route-params="$emit('watchRouteParams')"
            @show-sidebar="showSidebar"
        />
        <SubNavbarComponent />
        <div class="m-auto">
            <div class="d-flex d-none" id="side_bar">
                <div style="top: 0; left: 0; z-index: 10;height: 690px; overflow-y: scroll; width: 220px;" class="position-fixed side-bar-body shadow-sm z-3 vh-100">
                    <div class="sidebar-header p-3 d-flex justify-content-between align-items-center">
                        <h6>Logo</h6>
                        <Button @click="hiddenSidebar" icon="pi pi-arrow-left" class="task-description" text/>
                    </div>
                    <div class="sidebar-body">
                        <ul class="list-group text-capitalize">
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none list-group-item border-0 p-0" :to="{name: 'Home'}">
                                    <i class="pi pi-home"></i>
                                    Inicio
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none list-group-item border-0 p-0" :to="{name: 'TaskReception'}">
                                    <i class="pi pi-inbox"></i>
                                    Caixa de entrada
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none list-group-item border-0 p-0" :to="{name: 'Profil'}">
                                    <i class="pi pi-user"></i>
                                    Profil
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none list-group-item border-0 p-0" :to="{name: 'Task'}">
                                    <i class="pi pi-book"></i>
                                    tasks
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">
                                <span @click="menuTeamSpaceToggle = !menuTeamSpaceToggle">
                                    <i class="pi pi-box"></i>
                                    Team space
                                </span>
                                <ul class="list-group border-0 p-0">
                                    <Menu v-if="menuTeamSpaceToggle && teams_space" :model="teams_space" class="p-2 rounded-0 border-0" style="background-color: #f3f4f6;">
                                        <template #item="{ item, props }">
                                           <li class="list-group-item border-0 p-0 mb-2">
                                                <a class="text-decoration-none" @click="$router.push(`/dashboard/team-space/${item.slug}`)">
                                                    <span class="sub-menu-item d-flex align-items-center gap-2" style="color: #475569;">
                                                        <Tag class="px-2" :value="item.first_letter"/>
                                                        <span>{{ item.name }}</span>
                                                    </span>
                                                </a>
                                           </li>
                                        </template>
                                    </Menu>
                                    <p v-if="menuTeamSpaceToggle && !teams_space" class="p-2 border rounded-pill mt-2 text-lowercase text-center fw-medium">Nenhum team encontrado</p>
                                </ul>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none list-group-item border-0 p-0" :to="{name: 'Project'}">
                                    <i class="pi pi-slack"></i>
                                    Projetos
                                </router-link>
                            </li>
                            <li class="list-group-item border-0 d-none">
                                <router-link class="text-decoration-none" :to="{name: 'Sprint'}">
                                    <i class="pi pi-bolt"></i>
                                    sprint
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">
                                <span @click="menuCreateToggle = !menuCreateToggle">
                                    <i class="pi pi-pen-to-square"></i>
                                    create
                                </span>
                                <ul class="list-group border-0 p-0">
                                    <Menu v-if="menuCreateToggle" :model="menu" class="p-2 rounded-0 border-0" style="background-color: #f3f4f6;">
                                        <template #item="{ item, props }">
                                           <li class="list-group-item border-0 p-0">
                                                <router-link @click="generateSprint" v-if="item.action == 'generateSprint'" class="text-decoration-none" v-slot="{ href, navigate }" :to="item.route">
                                                    <span class="sub-menu-item" style="color: #475569;">
                                                        <i :class="item.icon" class="mb-3 px-1"></i>
                                                        {{ item.label }}
                                                    </span>
                                                </router-link>
                                                <router-link v-else class="text-decoration-none" v-slot="{ href, navigate }" :to="item.route">
                                                    <span class="sub-menu-item" style="color: #475569;">
                                                        <i :class="item.icon" class="mb-3 px-1"></i>
                                                        {{ item.label }}
                                                    </span>
                                                </router-link>
                                           </li>
                                        </template>
                                    </Menu>
                                </ul>
                            </li>
                            <li class="list-group-item border-0">
                                <span @click="menuSprintsToggle = !menuSprintsToggle">
                                    <i class="pi pi-bars"></i>
                                    sprints
                                </span>
                                <ul class="list-group border-0 p-0">
                                    <Menu v-if="menuSprintsToggle" @click="$emit('reloadSprintTaks')" :model="sprints" class="p-2 rounded-0 border-0" style="background-color: #f3f4f6;">
                                        <template #item="{ item, props }">
                                           <li class="list-group-item border-0 p-0">
                                                <a class="text-decoration-none text-lowercase" @click="cleanSprintPathUrl(item.path)">
                                                    <span class="sub-menu-item text-capitalize" style="color: #475569;">
                                                        <i class="pi pi-list-check mb-3 px-1"></i>
                                                        {{ item.name }}
                                                    </span>
                                                </a>
                                           </li>
                                        </template>
                                    </Menu>
                                </ul>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none list-group-item border-0 p-0" :to="{name: 'Trash'}">
                                    <i class="pi pi-trash"></i>
                                    Lixeira
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-fluid m-auto position-realtive">
                <slot></slot>
            </div>
        </div>
    </div>
</template>
<script>
import { useToast } from 'primevue/usetoast';
import { provide } from 'vue';
import SubNavbarComponent from './SubNavbarComponent.vue';
export default {
    name: 'SidebarComponent',

    components: {
        SubNavbarComponent
    },

    data(){
        return {
            menu: [
                {label: 'Task', route: '/task-create', icon: 'pi pi-book', action: 'page'},
                {label: 'usuario', route: '/register', icon:'pi pi-users', action: 'page'},
                {label: 'Gerar novo sprint', route: '#', icon:'pi pi-bolt', action: 'generateSprint'}
            ],
            menuCreateToggle: false,
            sprints: null,
            menuSprintsToggle: false,
            toast: useToast(),
            menuTeamSpaceToggle: false,
            teams_space: null
        }
    },
    provide() {
        return {
            sprintsp: "this.sprints"
        }
    },
    methods: {
        generateSprint(e){
            e.preventDefault();
            const actionUrl = new URL(e.target.baseURI)
            const pathName = actionUrl.pathname.replace(/\W/g, '');
            let result;

            this.Api.post('sprint', {generate: true})
            .then(async response => {
                result = await response.data.data;
                this.toast.add({ severity: 'success', summary: 'Error', detail: await response.data.message, life: 3000 });
            })
            .catch(error => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when generated a sprint", life: 3000 });
            })
            setTimeout(() => {
                location.assign(`/sprint/${result.id}`);
            }, 700)

        },
        getSprints(){
            this.Api.get('sprint')
            .then(async response => {
                this.sprints = await response.data;
            })
            .catch(error => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded sprints", life: 3000 });
            })
        },
        cleanSprintPathUrl(path){
           this.$router.push("/dashboard/"+path);
        },
        listAllTeam(){
            this.Api.get('team-space')
            .then(async response => {
                this.teams_space = await response.data.data;
            })
        },
        hiddenSidebar(){
            document.getElementById('side_bar').classList.add('d-none')
        },
        showSidebar(){
            document.getElementById('side_bar').classList.remove('d-none')
        }
    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
        this.getSprints();
        this.listAllTeam();
    }
}
</script>
<style scoped>
.col-md-2, .list-group-item{
    color: #475569;
}
.side-bar-body, .list-group-item{
    background-color: #f3f4f6;
    transition: 0.3s ease-in-out;
}
.list-group-item{
    cursor: pointer;
}
.sidebar-body, .sub-menu-item{
    font-size: 0.9rem;
}
.list-group-item:hover{
    color: var(--li-item-hover-blue);
}
</style>
