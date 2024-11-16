<template>
    <div class="row" v-if="tasks">
        <ul class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in tasks">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-3 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                        <span class="d-flex align-items-center">
                            <Tag class="p-1 v-small-fs" :style="`background-color: ${task.execution_status_severity}`" :value="task.full_task_execution_status" />
                        </span>
                        <span class="d-flex align-items-center p-0">

                        </span>
                    </span>
                    <span class="d-flex align-items-center">
                        <ListTaskExecutionStatusComponent
                            :task="task"
                            @list-all-task="$emit('updateUi')"
                            :task-status="taskStatus"
                        />
                        <Button class="p-1" @click="showTask(task.id)" text>
                            <i class="pi pi-align-center icon-list-task"></i>
                        </Button>
                    </span>
                </div>
            </li>
        </ul>
    </div>
    <div class="w-100">
        <Dialog v-model:visible="visibleShowTaskModal" maximizable modal header=" " :style="{ width: '95rem' }">
            <ShowTaskComponent
                class="p-0"
                :task-finded="task_finded",
                :task-status="taskStatus"
            />
        </Dialog>
    </div>
</template>
<script>
import ListTaskExecutionStatusComponent from '../ListTaskExecutionStatusComponent.vue';
import ShowTaskComponent from '../ShowTaskComponent.vue';
export default {
    name: 'TaskListComponent',
    props: {
        tasks: Object,
    },
    components: {
        ListTaskExecutionStatusComponent,
        ShowTaskComponent
    },
    data(){
        return {
            task_finded: null,
            visibleShowTaskModal: false,
            taskStatus: null,
        }
    },
    methods: {
        showTask(id){
            this.Api.get('task', {task_id: id})
            .then(async response => {
                this.task_finded = await response.data;
                this.visibleShowTaskModal = true;
            })
            .catch(err => console.log(err));
        },
        onListAllTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.taskStatus = await response.data;
            })
            .catch(err => {
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded task status data", life: 3000 });
            })
        },
    },
    mounted(){
        this.onListAllTaskExecutionStatus();
    }
}
</script>
