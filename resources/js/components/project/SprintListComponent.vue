<template>
    <div class="row">
        <div class="col-md-12 mb-">
            <h6 class="d-flex align-items-center gap-1">
                <Tag :value="projectName" icon="pi pi-briefcase" severity="secondary" />
                <span>Sprint</span>
            </h6>
        </div>
        <div class="col-md-8 d-flex flex-column gap-3">
            <div v-for="(sprint, index) of sprints" class="w-100 d-flex flex-column gap-2">
                <div class="w-100 d-flex gap-3">
                    <Button text class="p-1 task-description" @click="listTaskBySprint(sprint.id, index, true)">
                        <span><i :class="`pi ${toggleIcon}`" :id="`icon_toggle_${sprint.id}`"></i></span>
                    </Button>
                    <Tag class="p-2 w-25 sprint-list-tag text-white">
                        <span>{{ sprint.name }}</span>
                    </Tag>
                    <span style="width: 15px;" class="d-flex align-items-center">
                        <Tag severity="secondary" class="px-2":value="sprint.count_tasks"/>
                    </span>
                    <Button text class="p-1 task-description">
                        <span><i class="pi pi-ellipsis-h"></i></span>
                    </Button>
                </div>
                <div class="row d-none" :id="`box_list_task_${sprint.id}`">
                    <TaskListComponent
                        :tasks="tasks[index]"
                        @update-ui="listTaskBySprint(sprint.id, index, false)"
                        :task-status="taskStatus"
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
        sprints: Object,
        projectId: Number,
        projectName: String,
        taskStatus: Object
    },

    components: {
        TaskListComponent
    },

    data() {
        return {
            toggleIcon: 'pi-angle-right',
            tasks: []
        }
    },

    methods: {
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

        },
    },
    mounted(){
    }
}
</script>
<style scoped>
.sprint-list-tag{
    background-color: #0284c7;
}
</style>
