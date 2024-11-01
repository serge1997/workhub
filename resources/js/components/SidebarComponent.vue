<template>
    <div class="container-fluid m-auto p-0">
        <NavbarComponent
            @watch-route-params="$emit('watchRouteParams')"
        />
        <div class="row m-auto">
            <div class="col-md-2 d-flex">
                <div style="top: 0; left: 0; z-index: 10;height: 690px; overflow-y: scroll;" class="col-md-2 position-fixed bg-white z-3 min-vh-100">
                    <div class="sidebar-header p-3">
                        <h6>Logo</h6>
                    </div>
                    <div class="sidebar-body">
                        <ul class="list-group text-capitalize">
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none" :to="{name: 'Home'}">
                                    <i class="pi pi-home"></i>
                                    Inicio
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none" :to="{name: 'TaskReception'}">
                                    <i class="pi pi-inbox"></i>
                                    Caixa de entrada
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none" :to="{name: 'Profil'}">
                                    <i class="pi pi-user"></i>
                                    Profil
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none" :to="{name: 'Task'}">
                                    <i class="pi pi-book"></i>
                                    tasks
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
                                    <Menu v-if="menuCreateToggle" :model="menu" class="p-2 rounded-0 border-0">
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
                                    <Menu v-if="menuSprintsToggle" @click="$emit('reloadSprintTaks')" :model="sprints" class="p-2 rounded-0 border-0">
                                        <template #item="{ item, props }">
                                           <li class="list-group-item border-0 p-0">
                                                <router-link class="text-decoration-none" v-slot="{ href, navigate }" :to="cleanSprintPathUrl(item.name)">
                                                    <span class="sub-menu-item" style="color: #475569;">
                                                        <i class="pi pi-list-check mb-3 px-1"></i>
                                                        {{ item.name }}
                                                    </span>
                                                </router-link>
                                           </li>
                                        </template>
                                    </Menu>
                                </ul>
                            </li>
                            <li class="list-group-item border-0">
                                <router-link class="text-decoration-none" :to="{name: 'Trash'}">
                                    <i class="pi pi-trash"></i>
                                    Lixeira
                                </router-link>
                            </li>
                            <li class="list-group-item border-0">A fourth item</li>
                            <li class="list-group-item border-0">And a fifth one</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10 m-auto position-realtive">
                <slot></slot>
            </div>
        </div>
    </div>
</template>
<script>
import { useToast } from 'primevue/usetoast';
import { provide } from 'vue';
export default {
    name: 'SidebarComponent',

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
            if (location.pathname.includes("sprint")){
                let regex = /[sprint, \s]/g;
                return path.replaceAll(regex, "");
            }
            return path.replace(" ", "/");
        }
    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
        this.getSprints()
    }
}
</script>
<style scoped>
.col-md-2, .list-group-item{
    color: #475569;
}
.list-group-item{
    cursor: pointer;
}
.sidebar-body, .sub-menu-item{
    font-size: 0.9rem;
}
</style>
