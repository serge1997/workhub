<template>
    <div class="row">
        <TaskDataTableComponent
            :url="`sprint/list-by-project/${$route.params.id}`"
            header-group-label="Sprints"
            :header-group-label-has-severity="false"
            :has-concluded-column="true"
            global-header-text-color="gray-pure"
        />
    </div>
    <div class="row d-none">
        <div class="col-md-12 mb-">
            <h6 class="d-flex align-items-center gap-1">
                <Tag :value="projectName" icon="pi pi-briefcase" severity="secondary" />
                <span>Sprint</span>
            </h6>
        </div>
        <div class="col-md-12 d-flex flex-column gap-3">
            <div v-for="(sprint, index) of sprints" class="w-100 d-flex flex-column gap-2">
                <div class="w-100 d-flex gap-3">
                    <Button text class="p-1 task-description btn-list-task-by-sprint-sprint-list" :data-id="sprint.id" @click.prevent="listTaskBySprint(sprint.id, index, true)">
                        <span><i :class="`pi ${toggleIcon}`" :id="`icon_toggle_${sprint.id}`"></i></span>
                    </Button>
                    <Tag class="p-2 px-4 sprint-list-tag text-white">
                        <span>{{ sprint.name }}</span>
                    </Tag>
                    <span style="width: 15px;" class="d-flex align-items-center">
                        <Tag severity="secondary" class="px-2":value="sprint.count_tasks"/>
                    </span>
                    <Button text class="p-1 task-description">
                        <span><i class="pi pi-ellipsis-h"></i></span>
                    </Button>
                </div>
                <div class="row d-none" :id="`box_list_task_by_sprint_${sprint.id}`">
                    <TaskListComponent
                        :tasks="tasks[index]"
                        @update-ui="listTaskBySprint(sprint.id, index, false)"
                        :task-status="taskStatus"
                        :tasks-ids="selected_tasks_ids"
                        @onSelectedTask="onSelectedTask"
                    />
                </div>
            </div>
        </div>
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
        TaskDataTableComponent
    },

    data() {
        return {
            toggleIcon: 'pi-angle-right',
            tasks: [],
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
