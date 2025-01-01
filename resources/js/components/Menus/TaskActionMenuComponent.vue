<template>
    <Button @click="toggleTaskActionMenu" class="p-1" text>
        <i class="pi pi-ellipsis-v small-icon task-description"></i>
    </Button>
    <Button @click="$emit('onSelectedTask', task.id)" class="p-1" text>
        <i :id="`task_selected_icon_${task.id}`" class="pi pi-circle small-icon task-description"></i>
    </Button>
   <Menu :model="actions" class="shadow" ref="visibleTaskActionMenu" style="width: 380px;" :popup="true">
        <template #start>
            <div class="d-flex justify-content-center gap-3 border-bottom">
                <Button text @click="menuIs = 'priority'" class="d-flex algn-items-center gap-1" :class="handleActionMenuActiveClass('priority')">
                    <span><i class="pi pi-tag small-icon task-description"></i></span>
                    <small class="task-description">Prioridade</small>
                </Button>
                <Button text @click="menuIs = 'status'" class="d-flex algn-items-center gap-1" :class="handleActionMenuActiveClass('status')">
                    <span><i class="pi pi-list small-icon task-description"></i></span>
                    <small class="task-description">Status</small>
                </Button>
                <Button text @click="menuIs = 'responsavel'" class="d-flex algn-items-center gap-1" :class="handleActionMenuActiveClass('responsavel')">
                    <span><i class="pi pi-list small-icon task-description"></i></span>
                    <small class="task-description">Responsavel</small>
                </Button>
            </div>
        </template>
        <template #item="{item, props}">
            <div class="menu-action-content-box">
                <div v-if="menuIs === 'priority'" class="d-flex flex-column">
                    <Button v-for="priority in item.priorities" text @click="$emit('updatePriority', task?.id, priority.value)" class="d-flex gap-2">
                        <i class="pi pi-flag-fill small-icon" :class="`${priority.severity}`"></i>
                        <small class="gray-pure">{{ priority.priority }}</small>
                    </Button>
                </div>
                <div v-if="menuIs === 'status' && item.status" class="d-flex flex-column">
                    <Button text v-for="status in item.status" @click="$emit('updateTaskStatus', task?.id, status.id)" class="d-flex gap-2">
                        <span>
                            <i class="pi pi-circle-fill small-icon" :style="`color: ${status.severity}`"></i>
                        </span>
                        <span><small class="gray-pure">{{ status.name_ucfirst	 }}</small></span>
                    </Button>
                </div>
               <div v-if="menuIs === 'responsavel'" class="d-flex flex-column">
                    <Button text v-for="user in item.users" class="d-flex gap-2" @click="$emit('updateTaskUser', task?.id, user.id)">
                        <span>
                            <small>
                                <img style="width: 35px;" class="img-thumbnail rounded-circle" :src="`/img/users_avatars/${user.avatar}`" alt="">
                            </small>
                        </span>
                        <span><small class="gray-pure">{{ user.name	 }}</small></span>
                    </Button>
               </div>
            </div>
        </template>
   </Menu>
</template>
<script>
import { defineAsyncComponent, ref } from 'vue';

export default {
    name: 'TaskActionMenuComponent',

    components: {
    },
    props: {
        taskStatus: Object,
        users: Object,
        task: Object
    },
    data(){
        return{
            visibleTaskActionMenu: ref(null),
            actions: [
                {priorities: [
                    {value: "ALT", priority: "Alta", severity: "text-danger"},
                    {value: "MED", priority: "Media", severity: "text-warning"},
                    {value: "BAX", priority: "Baixa", severity: "text-success"}
                ]},
                {status: []},
                {users: []}
            ],
            menuIs: "priority"
        }
    },
    mounted(){
        this.visibleTaskActionMenu = this.$refs.visibleTaskActionMenu;
        this.actions[0].status = this.taskStatus;
        this.actions[0].users = this.users;
    },
    methods: {
        toggleTaskActionMenu(event){
            this.visibleTaskActionMenu.toggle(event);
        },
        handleActionMenuActiveClass(active){
            return this.menuIs == active ? 'toolbar-nav-active' : null;
        },
    }
}
</script>
<style>
.menu-action-content-box:hover{
    background-color: #fff;
}
</style>
