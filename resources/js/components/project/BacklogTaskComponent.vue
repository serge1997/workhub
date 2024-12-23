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
                @update-ui="$emit('updateBacklogUi')"
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
        }
    },
    methods: {
    }
}
</script>
