<template>
    <div class="w-100">
        <ul v-if="showStatus == 'WAT'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in task.waiting">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill text-warning"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <Button class="text-success icon-list-task" text>
                            <i class="pi pi-play-circle icon-list-task"></i>
                        </Button>
                        <Button class="icon-list-task" text>
                            <i class="pi pi-align-center icon-list-task"></i>
                        </Button>
                    </span>
                </div>
            </li>
        </ul>
        <ul v-if="showStatus == 'PRO'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in task.progress">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill text-primary"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <Button class="text-success icon-list-task" text>
                            <i class="pi pi-play-circle icon-list-task"></i>
                        </Button>
                        <Button class="icon-list-task" text>
                            <i class="pi pi-align-center icon-list-task"></i>
                        </Button>
                    </span>
                </div>
            </li>
        </ul>
        <ul v-if="showStatus == 'CON'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in task.concluded">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill text-success"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <Button class="text-success icon-list-task" text>
                            <i class="pi pi-play-circle icon-list-task"></i>
                        </Button>
                        <Button class="icon-list-task" text>
                            <i class="pi pi-align-center icon-list-task"></i>
                        </Button>
                    </span>
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
export default{
    name: 'ListTaskComponent',
    props: ['showStatus'],
    data(){
        return {
            task: {
                progress: null,
                waiting: null,
                concluded: null,
            }
        }
    },
    methods: {
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
        }
    },
    mounted(){
        this.onListAllTask();
    }
}
</script>
<style>


.list-group-item{
    border-bottom: 1px solid #e2e8f0;
}
.icon-list-task {
    font-size: 0.9em;
    color: #64748b;
}
</style>
