<template>
    <div class="w-100">
        <div v-if="showStatus == 'WAT'" v-for="task in task.waiting" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <div class="w-100 d-flex flex-column">
                    <div class="w-100 icons d-flex mb-2">
                        <span>
                            <i class="pi pi-user icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-clock icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-users icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-paperclip icon-list-task"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showStatus == 'PRO'" v-for="task in task.progress" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <div class="w-100 d-flex flex-column">
                    <div class="w-100 icons d-flex mb-2">
                        <span>
                            <i class="pi pi-user icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-clock icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-users icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-paperclip icon-list-task"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showStatus == 'CON'" v-for="task in task.concluded" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
                <div class="w-100 d-flex flex-column">
                    <div class="w-100 icons d-flex mb-2">
                        <span>
                            <i class="pi pi-user icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-clock icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-users icon-list-task"></i>
                        </span>
                    </div>
                    <div class="w-100 icons d-flex">
                        <span>
                            <i class="pi pi-paperclip icon-list-task"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    name: 'CardTaskComponent',
    props: ['showStatus'],
    components: {

    },
    data(){
        return {
            task: {
                progress: null,
                waiting: null,
                concluded: null,
            }
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
        }
    },
    mounted(){
        this.onListAllTask();
    }
}
</script>
