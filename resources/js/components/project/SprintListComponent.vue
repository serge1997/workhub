<template>
    <div class="row">
        <TaskDataTableComponent
            :url="`sprint/list-by-project/${$route.params.id}`"
            header-group-label="Sprints"
            :header-group-label-has-severity="false"
            :has-concluded-column="true"
            global-header-text-color="gray-pure"
            @selected-task="onSelectedTask"
        />
    </div>
    <div class="col-md-10 m-auto">
        <TaskToolbarComponent
            :tasks-ids="selected_tasks_ids"
        />
    </div>
</template>
<script>
import TaskListComponent from './TaskListComponent.vue';
import TaskDataTableComponent from '../tasks/TaskDataTableComponent.vue';
import { defineAsyncComponent } from 'vue';
export default {
    name: 'SprintListComponent',

    props: {
        sprints: Object,
        projectId: Number,
        projectName: String,
        taskStatus: Object
    },

    components: {
        TaskListComponent,
        TaskDataTableComponent,
        TaskToolbarComponent: defineAsyncComponent(() =>
            import('../TaskToolbarComponent.vue')
        ),
    },
    watch:{
        '$route.params.id'(n, old){
            this.selected_tasks_ids = [];
        },
    },

    data() {
        return {
            toggleIcon: 'pi-angle-right',
            tasks: [],
            selected_tasks_ids: []
        }
    },

    methods: {
        onSelectedTask(id, selectedTarget){
            const toolbar = document.getElementById('task-toolbar');
            if (this.selected_tasks_ids.includes(id)){
                this.selected_tasks_ids.splice(this.selected_tasks_ids.indexOf(id));
            }else{
                this.selected_tasks_ids.push(id);
            }
            if (selectedTarget.length){
                toolbar.classList.remove('d-none')
            }else{
                toolbar.classList.add('d-none')
            }
        },
        listTaskBySprint(sprint_id, index, hidden_box){
            this.Api.get(`tasks/sprint/${sprint_id}/project/${this.projectId}`)
            .then(async response => {
                this.tasks[index] = await response.data.data;
                if(hidden_box){
                    this.toggleTaskListBySprint(sprint_id)
                }
            })
        },
        toggleTaskListBySprint(box_id){
            let box = document.getElementById(`box_list_task_by_sprint_${box_id}`);
            let i = document.getElementById(`icon_toggle_${box_id}`);
            box.classList.toggle('d-none');
            if (!box.classList.contains('d-none')){
                i.classList.remove('pi-angle-right')
                i.classList.add('pi-angle-down')
            }else{
                i.classList.remove('pi-angle-down')
                i.classList.add('pi-angle-right')
            }

        },
    },
    mounted(){
        const toggleFirstTaskListInterval = setInterval(() => {
            const btnListTask = document.querySelector('.btn-list-task-by-sprint-sprint-list');
            if (btnListTask){
                btnListTask.click();
                console.log("hello world")
                clearInterval(toggleFirstTaskListInterval);
                return;
            }
       }, 300)
    }
}
</script>
<style scoped>
.sprint-list-tag{
    background-color: #0284c7;
}
</style>
