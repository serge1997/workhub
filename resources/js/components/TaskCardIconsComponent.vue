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
        <div class="w-100 icons d-flex gap-1 align-items-center">
            <Button class="d-flex gap-1 align-items-center" text>
                <span>
                    <i class="pi pi-clock icon-list-task"></i>
                </span>
                <span class="d-flex align-items-center">
                    <small style="font-size: 0.8rem;" class="task-description">
                        {{ task.execution_delay }}
                    </small>
                </span>
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
        <div class="w-100 icons d-flex align-items-center">
            <span class="d-flex align-items-center">
                <ShowTaskComponent
                    class="p-0"
                    @show-task="showTask(task.id)"
                    open-modal-icon="pi-align-center"
                    :task-finded="task_finded"
                />
            </span>
        </div>
    </div>
</template>
<script>
import ShowTaskComponent from './ShowTaskComponent.vue';
import ShowTaskFollower from './ShowTaskFollower.vue'
export default{
    name: 'TaskCardIconsComponent',

    components: {
        ShowTaskComponent,
        ShowTaskFollower
    },

    props: ['task'],

    data(){
        return{
            task_finded: null
        }
    },
    methods: {
        showTask(id){
            this.task_finded = null;
            this.Api.get('task', {id: id})
            .then(async response => {
                this.task_finded = await response.data;
                console.log(this.task_finded)
            })
            .catch(err => console.log(err));
        },
    }
}
</script>
