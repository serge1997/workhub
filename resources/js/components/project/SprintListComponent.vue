<template>
    <div class="row">
        <div class="col-md-6 d-flex flex-column gap-3">
            <div v-for="sprint of sprints" class="w-100 d-flex flex-column gap-2">
                <div class="w-100 d-flex gap-3">
                    <Button text class="p-1 task-description" @click="listTaskBySprint(sprint.id)">
                        <span><i :class="`pi ${toggleIcon}`" :id="`icon_toggle_${sprint.id}`"></i></span>
                    </Button>
                    <Tag class="p-2 w-25 sprint-list-tag text-white">
                        <span>{{ sprint.name }}</span>
                    </Tag>
                    <span style="width: 15px;" class="d-flex align-items-center">
                        <small class="task-description">{{ sprint.count_tasks }}</small>
                    </span>
                    <Button text class="p-1 task-description">
                        <span><i class="pi pi-ellipsis-h"></i></span>
                    </Button>
                </div>
                <div class="row d-none" :id="`box_list_task_${sprint.id}`">
                    <TaskListComponent
                        :tasks="tasks"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TaskListComponent from './TaskListComponent.vue';
export default {
    name: 'SprintListComponent',

    props: {
        sprints: Object
    },

    components: {
        TaskListComponent
    },

    data() {
        return {
            sprints: null,
            toggleIcon: 'pi-angle-right',
            tasks: null
        }
    },

    methods: {
        listSprintByProject(){
            this.Api.get('sprint/list-by-project/1')
            .then(async response => {
                //this.sprints = await response.data.data;
            })
            .catch(error => {

            })
        },
        listTaskBySprint(sprint_id){
            this.Api.get('tasks/by-sprint', {sprint_id: sprint_id})
            .then(async response => {
                this.tasks = await response.data;
                this.toggleTaskListBySprint(sprint_id)
            })
        },
        toggleTaskListBySprint(box_id){
            let box = document.getElementById(`box_list_task_${box_id}`);
            let i = document.getElementById(`icon_toggle_${box_id}`);
            box.classList.toggle('d-none');
            if (!box.classList.contains('d-none')){
                i.classList.remove('pi-angle-right')
                i.classList.add('pi-angle-down')
            }else{
                i.classList.remove('pi-angle-down')
                i.classList.add('pi-angle-right')
            }

        }
    },
    mounted(){
        this.listSprintByProject();
    }
}
</script>
<style scoped>
.sprint-list-tag{
    background-color: #0284c7;
}
</style>
