<template>
    <div class="w-100">
        <div v-if="showStatus == 'WAT'" v-for="task in task.waiting" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <TaskCardIconsComponent
                    :task="task"
                />
            </div>
        </div>
        <div v-if="showStatus == 'PRO'" v-for="task in task.progress" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <TaskCardIconsComponent
                    :task="task"
                />
            </div>
        </div>
        <div v-if="showStatus == 'CON'" v-for="task in task.concluded" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <TaskCardIconsComponent
                    :task="task"
                />
            </div>
        </div>
    </div>
</template>
<script>
import ShowTaskComponent from '../ShowTaskComponent.vue';
import TaskCardIconsComponent from '../TaskCardIconsComponent.vue';
export default{
    name: 'CardTaskComponent',
    props: ['showStatus'],
    components: {
        ShowTaskComponent,
        TaskCardIconsComponent,
    },
    data(){
        return {
            task: {
                progress: null,
                waiting: null,
                concluded: null,
            },
            task_finded: null
        }
    },
    methods:{
        onListAllTask(){
            this.Api.get('tasks')
            .then(async response => {
                this.task.waiting = await response.data.filter(task => task.execution_status === 'WAT');
                this.task.progress = await response.data.filter(task => task.execution_status === 'PRO');
                this.task.concluded = await response.data.filter(task => task.execution_status === 'CON');
                console.log(response)
            })
            .catch(async err => {

            })
        },
        showTask(id){
            this.task_finded = null;
            this.Api.get('task', {id: id})
            .then(async response => {
                this.task_finded = await response.data;
                console.log(this.task_finded)
            })
            .catch(err => console.log(err));
        }
    },
    mounted(){
        this.onListAllTask();
    }
}
</script>
