<template>
    <SidebarComponent>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <Toolbar class="p-0">
                        <template #start>
                            <div class="w-100 d-flex">
                                <Button class="task-description" label="Commentarios" text/>
                                <Button icon="pi pi-list" text />
                            </div>
                        </template>
                    </Toolbar>
                </div>
                <div class="row gg">
                    <div class="col-md-11 m-auto mt-3" id="comment-trashed">
                        <ul class="list-group w-100">
                            <li class="list-group-item bg-transparent border-0 p-0 border-bottom w-100 lid" v-for="comment in comments">
                                <div class="w-100 d-flex justify-content-between list-items p-2">
                                    <small class="task-description d-flex gap-2 align-items-center">
                                        <span><i class="pi pi-circle"></i></span>
                                        <span>{{ comment.deleted_at }}</span>
                                    </small>
                                    <small class="task-description">{{ comment.comment }}</small>
                                    <small class="task-description">
                                        <span>
                                            <Button @click="refreshComment(comment.id)" icon="pi pi-sync" text class="task-description" />
                                        </span>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </SidebarComponent>
</template>
<script>
export default {
    name: 'Trash',

    components: {
    },

    data(){
        return{
            comments: null,
        }
    },
    methods:{
        getSoftDeletedComment(){
            this.Api.get('comments/soft-deleted')
            .then(async response => {
                this.comments = await response.data;
            })
            .catch(error => {
                console.log(error)
            })
        },
        refreshComment(id){
            this.Api.put('comments/refresh', {comment_id: id})
            .then(async response => {
                console.log(response.data)
                this.getSoftDeletedComment()
            })
            .catch(error => {
                console.log(error)
            })
        }
    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
        this.getSoftDeletedComment()
    }
}
</script>
<style scoped>
.list-items:hover{
    background-color: #fff;
    transition: .3s ease-in;
    cursor: pointer;
}
</style>
