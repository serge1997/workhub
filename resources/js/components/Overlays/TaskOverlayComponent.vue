<template>
    <Tag @click="toggleTaskOverlayPanel" class="cursor-p btn-text-nowrap" severity="warning" :value="`in progress(${ project.tasks_count_in_progress})`" icon="pi pi-tag" />
    <OverlayPanel ref="visibleOverlayPanel" style="width: 380px;">
        <ul class="list-group w-100">
            <li v-for="task in tasks" @click="showTask(task)" class="list-group-item border-0 d-flex flex-column gap-1 cursor-p">
                <span class="">
                    <i class="small-icon task-description pi pi-align-center"></i>
                    {{ task.title }}
                </span>
                <span v-if="task.user_name.name" class="small-fw task-description d-flex gap-3">
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
        project: Object
    },
    data(){
        return {
            visibleOverlayPanel: ref(null),
            tasks: null
        }
    },
    methods:{
        toggleTaskOverlayPanel(event){
            this.visibleOverlayPanel.toggle(event);
            this.listProjectTasks();
        },
        listProjectTasks(){
            this.Api.get('tasks/list-by-project/' + this.project.id)
            .then(async response => {
                this.tasks = await response.data.data;
            })
        },
        showTask(task){
            this.$router.push(`/task-show/${task.id}/task/${task.id}`)
        }
    },
    mounted(){
        this.visibleOverlayPanel = this.$refs.visibleOverlayPanel;
    }
}
</script>
