<template>
    <div class="w-100">
        <Button class="d-flex gap-1 align-items-center p-1" @click="listFollowers(task.id)" text>
            <span>
                <i class="pi pi-users icon-list-task"></i>
            </span>
            <span class="d-flex gap-1 align-items-center">
                <small class="task-description">
                    <AvatarGroup v-if="task.followers">
                        <Avatar v-for="follower in task.followers" shape="circle" :image="`/img/users_avatars/${follower.avatar}`"/>
                        <Avatar :label="task.followers_count" shape="circle" size="normal" />
                    </AvatarGroup>
                </small>
            </span>
        </Button>
        <Dialog v-model:visible="visibleShowTaskFollowerModal" modal header="Seguidores" :style="{ width: '25rem' }">
            <div class="w-100">
                <ul class="list-group w-100">
                    <li v-for="follower in followers" class="list-group-item w-100 d-flex gap-2 border-0 border-bottom">
                        <div class="w-100 d-flex justify-content-start align-items-center">
                            <small class="task-description">{{ follower.follower_name }}</small>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <img class="img-thumbnail w-25 rounded-circle" :src="`/img/users_avatars/${follower.avatar}`" alt="" srcset="">
                        </div>
                    </li>
                </ul>
            </div>
        </Dialog>
    </div>
</template>
<script>
export default{
    name: 'ShowTaskFollower',

    props: ['task'],

    data(){
        return{
            visibleShowTaskFollowerModal: false,
            followers: null,
        }
    },
    methods: {
        listFollowers(id){
            this.Api.get('followers', {id: id})
            .then(async response => {
                console.log(response.data)
                this.visibleShowTaskFollowerModal = true;
                this.followers = await response.data;
            })
        }
    }
}
</script>
