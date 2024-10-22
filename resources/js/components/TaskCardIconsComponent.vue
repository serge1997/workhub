<template>
    <div class="w-100 d-flex flex-column">
        <div class="w-100">
            <Button class="p-1" text>
                <span class="d-flex align-items-center">
                    <i class="pi pi-user icon-list-task"></i>
                </span>
                <small class="w-25">
                    <img class="img-thumbnail w-50 rounded-circle" :src="`/img/users_avatars/${task.user_name.avatar}`" alt="user avatar">
                </small>
            </Button>
        </div>
        <div class="w-100 d-flex px-1">
            <Chip class="rounded-0 bg-white w-75 p-0">
                <div class="d-flex align-items-center">
                    <span class="task-description d-flex align-items-center gap-2">
                        <i :style="{'color': task.execution_status_severity}" class="pi pi-circle-fill icon-list-task"></i>
                        {{ task.full_task_execution_status }}
                    </span>
                </div>
            </Chip>
            <ListTaskExecutionStatusComponent
                :task="task"
                @list-all-task="$emit('listAllTask')"
                :task-status="taskStatus"
            />
        </div>
        <div class="w-100 icons d-flex align-items-center">
            <Button class="d-flex gap-1 align-items-center p-1" text>
                <span>
                    <i class="pi pi-clock icon-list-task"></i>
                </span>
                <span class="d-flex align-items-center">
                    <small style="font-size: 0.8rem;" class="task-description d-flex align-items-center gap-1">
                        {{ task.execution_delay }}
                    </small>
                </span>
            </Button>
        </div>
        <div class="w-100 icons d-flex gap-1 align-items-center">
            <ShowTaskFollower :task="task" />
        </div>
        <div class="w-100 icons d-flex gap-1 align-items-center">
            <Button class="d-flex gap-1 align-items-center p-1" text>
                <span>
                    <i class="pi pi-paperclip icon-list-task"></i>
                </span>
                <span class="d-flex gap-1 align-items-center">
                    <small class="task-description">
                        {{ task.annex_count }}
                    </small>
                </span>
            </Button>
        </div>
        <div class="w-100 icons d-flex align-items-center">
            <TaskCommentComponent :task="task" />
        </div>
        <div class="w-100 icons d-flex align-items-center">
            <span class="d-flex align-items-center">
                <ShowTaskComponent
                    class="p-0"
                    @show-task="showTask(task.id)"
                    open-modal-icon="pi-align-center"
                    :task-finded="task_finded",
                    :custom-columns="customColumns"
                    @create-custom-value="createCustomValue"
                />
            </span>
        </div>
        <div v-if="task.can_delete" class="w-100 icons d-flex gap-1 align-items-center">
            <Button @click="$emit('confirmDelete', task.id)" class="d-flex gap-1 align-items-center p-1" text>
                <span>
                    <i class="pi pi-trash icon-list-task"></i>
                </span>
            </Button>
        </div>
    </div>
</template>
<script>
import ShowTaskComponent from './ShowTaskComponent.vue';
import ShowTaskFollower from './ShowTaskFollower.vue';
import TaskCommentComponent from './TaskCommentComponent.vue';
import ShowTaskAnnexComponent from './ShowTaskAnnexComponent.vue';
import ListTaskExecutionStatusComponent from './ListTaskExecutionStatusComponent.vue';
import { DateTime } from './../core/DateTime.js';
import { useToast } from 'primevue/usetoast';
export default{
    name: 'TaskCardIconsComponent',
    inject: ['task_exec_status'],
    props: {
        task: Object,
        taskStatus: Object
    },

    components: {
        ShowTaskComponent,
        ShowTaskFollower,
        TaskCommentComponent,
        ShowTaskAnnexComponent,
        ListTaskExecutionStatusComponent
    },

    props: ['task', 'taskStatus'],
    emits:['listAllTask'],

    data(){
        return{
            task_finded: null,
            customColumns: null,
            timing: {
                seconds: 0,
                minutes: 0
            },
            selectedStatus: null,
            task_status: null,
            toast: useToast(),
        }
    },
    methods: {
        showTask(id){
            this.task_finded = null;
            this.Api.get('task', {task_id: id})
            .then(async response => {
                this.task_finded = await response.data;
                this.getAllCustomColumns()
            })
            .catch(err => console.log(err));
        },
        startTiming(event){
            let parent = event.target.offsetParent
            parent.children[1].innerHTML = "Done"
            console.log(parent.children[1].querySelector('.chrono'))
            this.chrono(parent.children[1])
        },
        chrono(DOMElement){
            setInterval(() => {
                this.timing.seconds++;
                if (this.timing.seconds == 59) {
                    this.timing.minutes++;
                    this.timing.seconds = 0
                }
                this.timing.minutes = `${this.timing.minutes}`.padStart(2, '0');
                this.timing.seconds = `${this.timing.seconds}`.padStart(2, '0');
                DOMElement.innerHTML = `${this.timing.minutes}:${this.timing.seconds}`
            }, 1000);
        },
        setSeverity(priority){
            if(priority === "WAT")  return "text-danger";
            if (priority === "PRO") return "text-warning";
            return "text-success";
        },
        getAllCustomColumns(){
            this.Api.get('custom-column-value', {task_id: this.task.id})
            .then(async response => {
                this.customColumns = await response.data;
            })
            .catch(error => {
                console.log(error);
            })

        },
        createCustomValue(column_id, length){
            const value = document.getElementById(`custom-value-${column_id}`).value;
            const data = {
                value: value,
                custom_column_id: column_id,
                task_id: this.task.id
            };
            if (value !== null && value !== undefined && value.length > length || value.length < length){
                this.Api.put('custom-column-value', null, data)
                .then(async response => {
                    this.task_finded = await response.data.data;
                    this.toaster(response.data.message).fire();
                })
            }
        },
        toogleStatusListBox(id){
            let box = document.getElementById(`task-status-listbox-${id}`);
            if (box.classList.contains('d-none')){
                return box.classList.remove('d-none')
            }
            box.classList.add('d-none')

        },
        onListAllTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.task_status = await response.data;
            })
            .catch(err => {
                console.log(err);
            })
        },
        handleTaskStatu(id){
            const data = {
                execution_status_id: this.selectedStatus.id,
                task_id: id
            }
            this.Api.put('task/execution-status', data)
            .then(async response => {
                let box = document.getElementById(`task-status-listbox-${id}`);
                box.classList.add('d-none')
                this.toast.add({ severity: 'success', summary: 'Message', detail: await response.data, life: 3000 });
                return this.$emit('listAllTask');
            })
            .catch(error => {
                console.log(error)
            })
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
    created(){
        this.task_status = this.task_exec_status;
    },
    mounted() {
    }
}
</script>
