<template>
    <div class="row">
        <div class="col-md-12 mb-3">
            <h6 class="d-flex align-items-center gap-1">
                <Tag :value="projectName" icon="pi pi-briefcase" severity="secondary" />
                <span>Backlog</span>
            </h6>
        </div>
        <div class="col-md-12">
            <TaskListComponent
                :tasks="tasks"
                :task-status="taskStatus"
                :tasks-ids="selected_tasks_ids"
                @update-ui="$emit('updateBacklogUi')"
                @on-selected-task="onSelectedTask"
            />
        </div>
    </div>
</template>
<script>
import TaskListComponent from './TaskListComponent.vue';
import { defineAsyncComponent } from 'vue';
export default {
    name: 'BacklogTaskComponent',

    components: {
        TaskListComponent
    },

    props: {
        tasks: Object,
        projectName: String,
        taskStatus: Object
    },
    data(){
        return {
            selected_tasks_ids: []
        }
    },
    methods: {
        onSelectedTask(id){
            const iconTag = document.getElementById(`selected_task_icon_${id}`);
            const li = document.getElementById(`task_list_li_${id}`);
            const all = document.querySelectorAll('.task-list-list-items');
            let classes = [];
            iconTag.classList.toggle('pi-circle');
            iconTag.classList.toggle('pi-circle-fill');
            iconTag.classList.toggle('selected_icon_color')
            li.classList.toggle('selected_task_li')
            all.forEach(el => {
                if (el.classList.contains('selected_task_li')){
                    classes.push('selected_task_li');
                }
            })
            if (classes.includes('selected_task_li')){
                document.getElementById('task-toolbar').classList.remove('d-none')
            }else{
                document.getElementById('task-toolbar').classList.add('d-none')
            }
            if(!this.selected_tasks_ids.includes(id)){
                this.selected_tasks_ids.push(id);
            }else{
                if (!li.classList.contains('selected_task_li')){
                    this.selected_tasks_ids.splice(this.selected_tasks_ids.indexOf(id), 1);
                }
            }
            console.log(this.selected_tasks_ids)
        },
    }
}
</script>
