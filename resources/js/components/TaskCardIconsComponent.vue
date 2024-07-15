<template>
    <div class="w-100 d-flex flex-column">
        <div class="w-100">
            <Button class="" text>
                <span class="d-flex align-items-center">
                    <i class="pi pi-user icon-list-task"></i>
                </span>
                <small class="w-25">
                    <img class="img-thumbnail w-50 rounded-circle" :src="`/img/users_avatars/${task.user_name.avatar}`" alt="user avatar">
                </small>
            </Button>
        </div>
        <div class="w-100">
            <Button class="d-flex gap-2" text>
                <span class="d-flex align-items-center">
                    <i :class="setSeverity(task.priority)" class="pi pi-circle-fill icon-list-task"></i>
                </span>
                <span class="d-flex align-items-center">
                    <small style="font-size: 0.8rem;" class="task-description d-flex align-items-center gap-1">
                        {{ task.priority_fullDescription }}
                    </small>
                </span>
            </Button>
        </div>
        <div class="w-100 icons d-flex align-items-center">
            <Button class="d-flex gap-1 align-items-center" text>
                <span>
                    <i class="pi pi-clock icon-list-task"></i>
                </span>
                <span class="d-flex align-items-center">
                    <small style="font-size: 0.8rem;" class="task-description d-flex align-items-center gap-1">
                        {{ task.execution_delay }}
                    </small>
                </span>
            </Button>
            <Button @click="startTiming" class="p-0 task-description d-flex gap-1" text>
                <span>
                    <i class="pi pi-play-circle"></i>
                </span>
                <span class="chrono">{{timing.minutes}}:{{ timing.seconds }}</span>
            </Button>
        </div>
        <div class="w-100 icons d-flex gap-1 align-items-center">
            <ShowTaskFollower :task="task" />
        </div>
        <div class="w-100 icons d-flex gap-1 align-items-center">
            <Button class="d-flex gap-1 align-items-center" text>
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
        <div class="w-100 icons d-flex gap-1 align-items-center">
            <TaskCommentComponent :task="task.id" />
        </div>
        <div class="w-100 icons d-flex align-items-center">
            <span class="d-flex align-items-center">
                <ShowTaskComponent
                    class="p-0"
                    @show-task="showTask(task.id)"
                    open-modal-icon="pi-align-center"
                    :task-finded="task_finded",
                    :custom-columns="customColumns"
                />
            </span>
        </div>
    </div>
</template>
<script>
import ShowTaskComponent from './ShowTaskComponent.vue';
import ShowTaskFollower from './ShowTaskFollower.vue';
import TaskCommentComponent from './TaskCommentComponent.vue';
import ShowTaskAnnexComponent from './ShowTaskAnnexComponent.vue';
import { DateTime } from './../core/DateTime.js';
export default{
    name: 'TaskCardIconsComponent',

    components: {
        ShowTaskComponent,
        ShowTaskFollower,
        TaskCommentComponent,
        ShowTaskAnnexComponent
    },

    props: ['task'],

    data(){
        return{
            task_finded: null,
            customColumns: null,
            timing: {
                seconds: 0,
                minutes: 0
            },
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
            if(priority === "ALT")  return "text-danger";
            if (priority === "MED") return "text-warning";
            return "text-success";
        },
        getAllCustomColumns(){
            this.Api.get('custom-column')
            .then(async response => {
                this.customColumns = await response.data;
            })
            .catch(error => {
                console.log(error);
            })

        },

    },
    mounted() {
    }
}
</script>
