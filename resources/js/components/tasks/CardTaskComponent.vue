<template>
    <div class="w-100">
        <div v-if="showStatus == 'WAT'" v-for="task in task.waiting" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
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
                        <Button class="d-flex gap-1 align-items-center" text>
                            <span>
                                <i class="pi pi-users icon-list-task"></i>
                            </span>
                            <span class="d-flex gap-1 align-items-center">
                                <small class="task-description">
                                    <AvatarGroup v-if="task.followers">
                                        <Avatar v-for="follower in task.followers" shape="circle" :image="`img/users_avatars/${follower.avatar}`"/>
                                        <Avatar :label="task.followers_count" shape="circle" size="normal" />
                                    </AvatarGroup>
                                </small>
                            </span>
                        </Button>
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
            </div>
        </div>
        <div v-if="showStatus == 'PRO'" v-for="task in task.progress" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
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
                        <Button class="d-flex gap-1 align-items-center" text>
                            <span>
                                <i class="pi pi-users icon-list-task"></i>
                            </span>
                            <span class="d-flex gap-1 align-items-center">
                                <small class="task-description">
                                    <AvatarGroup v-if="task.followers">
                                        <Avatar v-for="follower in task.followers" shape="circle" :image="`img/users_avatars/${follower.avatar}`"/>
                                        <Avatar :label="task.followers_count" shape="circle" size="normal" />
                                    </AvatarGroup>
                                </small>
                            </span>
                        </Button>
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
            </div>
        </div>
        <div v-if="showStatus == 'CON'" v-for="task in task.concluded" class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="w-100 mb-3">
                    <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                </div>
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
                        <Button class="d-flex gap-1 align-items-center" text>
                            <span>
                                <i class="pi pi-users icon-list-task"></i>
                            </span>
                            <span class="d-flex gap-1 align-items-center">
                                <small class="task-description">
                                    <AvatarGroup v-if="task.followers">
                                        <Avatar v-for="follower in task.followers" shape="circle" :image="`img/users_avatars/${follower.avatar}`"/>
                                        <Avatar :label="task.followers_count" shape="circle" size="normal" />
                                    </AvatarGroup>
                                </small>
                            </span>
                        </Button>
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
            </div>
        </div>
    </div>
</template>
<script>
import ShowTaskComponent from '../ShowTaskComponent.vue';
export default{
    name: 'CardTaskComponent',
    props: ['showStatus'],
    components: {
        ShowTaskComponent
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
        },
    },
    mounted(){
        this.onListAllTask();
    }
}
</script>
