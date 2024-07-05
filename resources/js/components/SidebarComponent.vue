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
                                <router-link class="text-decoration-none d-flex gap-1" :to="{name: 'TaskReception'}">
                                    <span class="d-flex justify-items-center gap-1">
                                        <span>
                                            <i class="pi pi-inbox"></i>
                                        </span>
                                        <span>Caixa de entrada</span>
                                    </span>
                                    <span>
                                        <Badge :value="notification.count" />
                                    </span>
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
                                <router-link class="text-decoration-none" :to="{name: 'Sprint'}">
                                    <i class="pi pi-bolt"></i>
                                    sprint
                                </router-link>
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
                <Dialog v-model:visible="visibleTaskNotificationModal" modal header="Alert" :style="{ width: '28rem' }">
                    <ul class="list-group">
                        <li style="background-color: #f1f5f9;" v-for="notification in notification.content" class="list-group-item p-4 border-0 border-bottom">
                            <div class="w-100 d-flex flex-column">
                                <span class="task-description">{{ notification.data.message }} por {{ notification.data.by }}</span>
                                <span>
                                    <small class="task-description">
                                        <i class="pi pi-clock"></i>
                                        {{ notification.created_formated }}
                                    </small>
                                </span>
                            </div>
                        </li>
                    </ul>
                </Dialog>
                <slot></slot>
            </div>
        </div>
    </div>
</template>
<script>
import _ from 'lodash'

export default {
    name: 'SidebarComponent',
    data(){
        return {
            menu: [
                {label: 'Task', route: '/task-create', icon: 'pi pi-book'},
                {label: 'usuario', route: '/register', icon:'pi pi-users'}
            ],
            menuCreateToggle: false,
            teste: null,
            notification:{
                inbox: null,
                count: 0,
                content: null,
            },
            visibleTaskNotificationModal: false,
        }
    },
    watch: {
        'notification.content': _.debounce(function(newNotif) {
            this.getUnreadNotification()
        }, 3000)
    },
    methods: {
        getUnreadNotification(){
            this.Api.get('task-notification')
            .then(async response => {
                const countNotif = await response.data.notifications.filter(notif => notif !== null).length;
                if (this.notification.count < countNotif){
                    this.visibleTaskNotificationModal = true;
                }
                this.notification.content = await response.data.notifications.filter(notif => notif !== null);
                this.notification.count = countNotif;
            })
        }
    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
        this.getUnreadNotification();
        this.getUnreadNotification();


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
