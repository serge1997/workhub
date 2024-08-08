<template>
    <div class="w-100">
        <ul v-if="showStatus == 'BKL'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in filterBacklog(tasks)">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex align-items-center">
                        <ListTaskExecutionStatusComponent
                            :task="task"
                            @list-all-task="$emit('listAllTask')"
                        />
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
        <ul v-if="showStatus == 'WAT'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in filterAwait(tasks)">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <ListTaskExecutionStatusComponent
                            :task="task"
                            @list-all-task="$emit('listAllTask')"
                        />
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
            <li class="list-group-item border-0 border-bottom" v-for="task in filterInProgress(tasks)">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <ListTaskExecutionStatusComponent
                            :task="task"
                            @list-all-task="$emit('listAllTask')"
                        />
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
        <ul v-if="showStatus == 'CDR'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in filterCodeReview(tasks)">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <ListTaskExecutionStatusComponent
                            :task="task"
                            @list-all-task="$emit('listAllTask')"
                        />
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
        <ul v-if="showStatus == 'TST'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in filterTeste(tasks)">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <ListTaskExecutionStatusComponent
                            :task="task"
                            @list-all-task="$emit('listAllTask')"
                        />
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
        <ul v-if="showStatus == 'PRQ'" class="list-group">
            <li class="list-group-item border-0 border-bottom" v-for="task in filterPullrequest(tasks)">
                <div class="w-100 d-flex justify-content-between">
                    <span class="d-flex gap-2 p-1">
                        <span>
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <ListTaskExecutionStatusComponent
                            :task="task"
                            @list-all-task="$emit('listAllTask')"
                        />
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
                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                        </span>
                        <span class="task-description">
                            <small>{{ task.title }}</small>
                        </span>
                    </span>
                    <span class="d-flex">
                        <ListTaskExecutionStatusComponent
                            :task="task"
                            @list-all-task="$emit('listAllTask')"
                        />
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
import ListTaskExecutionStatusComponent from '../ListTaskExecutionStatusComponent.vue';
export default{
    name: 'ListTaskComponent',
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
        ListTaskExecutionStatusComponent
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
        },
        filterCodeReview(tasks){
            const codereview = tasks.filter(task => task.execution_status == 'CDR');
            return codereview;
        },
        filterTeste(tasks){
            const teste = tasks.filter(task => task.execution_status == 'TST');
            return teste;
        },
        filterPullrequest(tasks){
            const pullrequest = tasks.filter(task => task.execution_status == 'PRQ');
            return pullrequest;
        },
        filterBacklog(tasks){
            const backlog = tasks.filter(task => task.execution_status == 'BKL');
            return backlog;
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
