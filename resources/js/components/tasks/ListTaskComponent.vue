<template>
    <div class="w-100">
        <ul v-if="showStatus == 'WAT'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in tasksWait">
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
                        <Button @click="handleTaskStatus(task.id)" class="text-success icon-list-task" text>
                            <i class="pi pi-play-circle icon-list-task"></i>
                        </Button>
                        <ShowTaskComponent
                            @show-task="showTask(task.id)"
                            open-modal-icon="pi-align-center"
                            :task-finded="task_finded"
                            @create-custom-value="createCustomValue"
                            :task-execution-status="taskExecutionStatus"
                        />

                    </span>
                </div>
            </li>
        </ul>
        <ul v-if="showStatus == 'PRO'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in tasksProgress">
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
                        <Button v-if="task.task_owner" @click="handleTaskStatus(task.id)" class="text-success icon-list-task" text>
                            <i class="pi pi-step-forward-alt icon-list-task"></i>
                        </Button>
                        <ShowTaskComponent
                            @show-task="showTask(task.id)"
                            open-modal-icon="pi-align-center"
                            :task-finded="task_finded"
                            @create-custom-value="createCustomValue"
                            :task-execution-status="taskExecutionStatus"
                        />
                    </span>
                </div>
            </li>
        </ul>
        <ul v-if="showStatus == 'CON'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in tasksConcluded">
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
                            <i class="pi pi-trophy icon-list-task text-warning"></i>
                        </Button>
                        <ShowTaskComponent
                            @show-task="showTask(task.id)"
                            open-modal-icon="pi-align-center"
                            :task-finded="task_finded"
                            @create-custom-value="createCustomValue"
                            :task-execution-status="taskExecutionStatus"
                        />
                    </span>
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
import ShowTaskComponent from '../ShowTaskComponent.vue';
export default{
    name: 'ListTaskComponent',
    props: {
        showStatus: String,
        tasksProgress: Object,
        tasksWait: Object,
        tasksConcluded: Object,
        taskExecutionStatus: Object
    },

    components: {
        ShowTaskComponent
    },
    data(){
        return {
            task_finded: null,
        }
    },
    methods: {
        showTask(id){
            this.task_finded = null;
            this.Api.get('task', {task_id: id})
            .then(async response => {
                this.task_finded = await response.data;
            })
            .catch(err => console.log(err));
        },
        handleTaskStatus(id){
            this.Api.put('task/execution-status', {task_id: id})
            .then(async response => {
                this.toaster(response.data).fire();
                return this.onListAllTask()
            })
            .catch(err => console.log(err));
        },
        createCustomValue(column_id, length){
            const value = document.getElementById(`custom-value-${column_id}`).value;
            const data = {
                value: value,
                custom_column_id: column_id,
                task_id: this.task_finded.id
            };
            if (value !== null && value !== undefined && value.length > length || value.length < length){
                this.Api.put('custom-column-value', null, data)
                .then(async response => {
                    this.task_finded = await response.data.data;
                    this.toaster(response.data.message).fire();
                })
            }
        },
        toaster(response){
            const Toast = this.$swal.mixin({
                text: response,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                icon: "success",
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            return Toast
        },
    },
    mounted(){
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
