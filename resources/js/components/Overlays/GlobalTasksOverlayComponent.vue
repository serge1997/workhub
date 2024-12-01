<template>
    <Tag @click="toggleTasksOverlayPanel" icon="pi pi-eye" :value="tagLabel" :severity="tagSeverity"/>
    <OverlayPanel ref="visibleTasksOverlayPanel" style="width: 30%;">
        <ul class="list-group w-100">
            <li v-for="task in tasks" class="list-group-item border-0 d-flex flex-column gap-1 cursor-p">
                <span class="">
                    <i class="small-icon task-description pi pi-align-center"></i>
                    {{ task.title }}
                </span>
                <span v-if="task.user_name" class="small-fw task-description d-flex gap-3">
                    <small>Responsavel: {{ task.user_name.name }}</small>
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
export default {
    name: 'UsersOverlayComponent',

    props: {
        tasks: Object,
        tagSeverity: String,
        tagLabel: String
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
