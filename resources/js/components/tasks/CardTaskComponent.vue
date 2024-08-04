<template>
    <div class="w-100">
        <div v-if="showStatus == 'WAT'" v-for="task in filterAwait(tasks)" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <TaskCardIconsComponent
                    :task="task"
                    @confirm-delete = "$emit('confirmDelete', task.id)"
                    :task-execution-status="taskExecutionStatus"
                />
            </div>
        </div>
        <div v-if="showStatus == 'PRO'" v-for="task in filterInProgress(tasks)" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <TaskCardIconsComponent
                    :task="task"
                    @confirm-delete = "$emit('confirmDelete', task.id)"
                    :task-execution-status="taskExecutionStatus"
                />
            </div>
        </div>
        <div v-if="showStatus == 'CON'" v-for="task in filterConcluded(tasks)" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <TaskCardIconsComponent
                    :task="task"
                    @confirm-delete = "$emit('confirmDelete', task.id)"
                    :task-execution-status="taskExecutionStatus"
                />
            </div>
        </div>
    </div>
</template>
<script>
import ShowTaskComponent from '../ShowTaskComponent.vue';
import TaskCardIconsComponent from '../TaskCardIconsComponent.vue';
import ShowTaskAnnexComponent from '../ShowTaskAnnexComponent.vue';
export default{
    name: 'CardTaskComponent',
    props: {
        showStatus: String,
        tasksProgress: Object,
        tasksWait: Object,
        tasksConcluded: Object,
        taskExecutionStatus: Object,
        tasks: Object
    },
    components: {
        ShowTaskComponent,
        TaskCardIconsComponent,
        ShowTaskAnnexComponent
    },
    data(){
        return {
            task: {
                progress: null,
                waiting: null,
                concluded: null,
            },
            task_finded: null,
            task_await: null
        }
    },
    provide(){
        return {
            task_exec_status: this.taskExecutionStatus
        }
    },
    methods:{
        showTask(id){
            this.task_finded = null;
            this.Api.get('task', {id: id})
            .then(async response => {
                this.task_finded = await response.data;
                console.log(this.task_finded)
            })
            .catch(err => console.log(err));
        },
        filterAwait(tasks){
            const wait = tasks.filter(task => task.execution_status == 'WAT');
            return wait;
        },
        filterInProgress(tasks){
            const progress = tasks.filter(task => task.execution_status == 'PRO');
            return progress;
        },
        filterConcluded(tasks){
            const concluded = tasks.filter(task => task.execution_status == 'CON');
            return concluded;
        }
    },
    mounted(){
    }
}
</script>
