<template>
    <Tag @click="toggleTasksOverlayPanel" class="cursor-p btn-text-nowrap" :icon="icon" :value="tagLabel" :severity="tagSeverity"/>
    <OverlayPanel ref="visibleTasksOverlayPanel" style="width: 380px;">
        <ul class="list-group w-100">
            <li v-for="task in tasks"
                class="list-group-item border-0 d-flex flex-column gap-1 cursor-p"
                @click="$router.push(`/task-show/${task.id}/task/${task.id}`)"
            >
                <span class="">
                    <i class="small-icon task-description pi pi-align-center"></i>
                    {{ task.title }}
                </span>
                <span class="small-fw task-description d-flex gap-3">
                    <small v-if="task.user_name">Responsavel: {{ task.user_name.name }}</small>
                    <small>
                        <i class="small-icon task-description pi pi-align-center"></i>
                        {{ task.sprint_name }}
                    </small>
                </span>
            </li>
        </ul>
    </OverlayPanel>
    <Dialog>

    </Dialog>
</template>
<script>
import { ref } from 'vue';
import router from '../../router';
export default {
    name: 'UsersOverlayComponent',

    props: {
        tasks: Object,
        tagSeverity: String,
        tagLabel: String,
        icon: String
    },
    data(){
        return {
            visibleTasksOverlayPanel: ref(null)
        }
    },
    methods:{
        toggleTasksOverlayPanel(event){
            this.visibleTasksOverlayPanel.toggle(event);
        },
    },
    mounted(){
        this.visibleTasksOverlayPanel = this.$refs.visibleTasksOverlayPanel;
    }
}
</script>
