<template>
    <div class="container-fluid m-auto p-0">
        <NavbarComponent />
        <div class="row m-auto">
            <div class="col-md-2 d-flex overflow-scroll">
                <div style="top: 0; left: 0; z-index: 10;" class="col-md-2 position-fixed bg-white z-3 min-vh-100">
                    <div class="sidebar-header p-3">
                        <h6>Logo</h6>
                    </div>
                    <div class="sidebar-body">
                        <ul class="list-group text-capitalize">
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
                            <li class="list-group-item border-0">
                                <i class="pi pi-bolt"></i>
                                sprint
                            </li>
                            <li class="list-group-item border-0">
                                <span @click="menuCreateToggle = !menuCreateToggle">
                                    <i class="pi pi-angle-down"></i>
                                    create
                                </span>
                                <Menu v-if="menuCreateToggle" :model="menu" class="p-2 rounded-0 shadow-sm">
                                    <template #item="{ item, props }">
                                        <router-link class="text-decoration-none" v-slot="{ href, navigate }" :to="item.route">
                                            <span class="sub-menu-item" style="color: #475569;">
                                                <i :class="item.icon" class="mb-3 px-1"></i>
                                                {{ item.label }}
                                            </span>
                                        </router-link>
                                    </template>
                                </Menu>
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
export default {
    name: 'SidebarComponent',

    data(){
        return {
            menu: [
                {label: 'Task', route: '/', icon: 'pi pi-book'},
                {label: 'usuario', route: '/register', icon:'pi pi-users'}
            ],
            menuCreateToggle: false
        }
    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
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
