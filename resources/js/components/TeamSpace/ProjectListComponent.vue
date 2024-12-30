<template>
    <div class="container-fluid">
        <div class="row">
            <TaskDataTableComponent
                :url="`project/list-by-team-space/${$route.params.id}`"
                :is-by-users="false"
                header-group-label="Projetos"
                :header-group-label-has-severity="true"
                :has-concluded-column="true"
            />
        </div>
        <div class="row d-none">
            <div v-if="projects.length" v-for="(project, index) in projects" class="col-md-12 p-1">
                <div class="col-md-10 d-flex align-items-center gap-2">
                    <Button @click="$emit('listTaskByProject', project.id, index)" text class="task-description btn-list-task-by-project">
                        <i :id="`project-icon-toggle-${project.id}`" :class="`pi pi-chevron-right v-small-fs`"></i>
                    </Button>
                    <Tag class="p-2 px-4" :style="`background-color: #${project?.severity};`" :value="project.name" />
                    <Badge severity="secondary" :value="project.tasks_count"/>
                </div>
                <div v-if="tasks" class="col-md-12 d-none" :id="`project-list-box-${project.id}`">
                    <TaskListComponent
                        :tasks="tasks[index]"
                        :task-status="taskStatus"
                        @on-selected-task="onSelectedTask"
                    />
                </div>
            </div>
            <div v-else class="col-md-10 m-auto">
                <h4 class="text-center text-secondary d-flex align-items-center gap-2 justify-content-center">
                    <i class="pi pi-ban mt-1"></i>
                    <span>
                        Envolvido em nenhum projeto
                    </span>
                </h4>
            </div>
        </div>
    </div>
</template>
<script>
import { defineAsyncComponent } from 'vue';
import TaskDataTableComponent from '../tasks/TaskDataTableComponent.vue';
export default {
    name: 'ProjectListComponent',

    components: {
        TaskListComponent: defineAsyncComponent(() =>
            import('./../project/TaskListComponent.vue')
        ),
        TaskToolbarComponent: defineAsyncComponent(() =>
            import('./../TaskToolbarComponent.vue')
        ),
        TaskDataTableComponent
    },

    props: {
        url: String,
        projects: Object,
        tasks: Object,
        taskStatus: Object,
        icon: String
    },
    data(){
        return {
            selected_tasks_ids: []
        }
    },
    mounted(){
       const tooggleFirstTaskListInterval = setInterval(() => {
            const btnListTask = document.querySelector('.btn-list-task-by-project');
            if (btnListTask){
                btnListTask.click();
                clearInterval(tooggleFirstTaskListInterval);
            }
       }, 200)
    },
    methods:{

    }
}
</script>
