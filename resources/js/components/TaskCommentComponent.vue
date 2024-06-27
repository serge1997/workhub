<template>
    <div class="w-100 p-1">
        <Button class="icon-list-task" @click="listAllCommentByTask(task)" text icon="pi pi-comment" />
         <Dialog v-model:visible="visibleShowTaskCommentModal" modal header="Task comment" :style="{ width: '25rem' }">
             <div class="w-100 comment-list mb-3">
                <input type="hidden" id="task-id" :value="task">
                <div v-for="(comment, index) of taskComments" class="card border-0 comment-card">
                    <input type="hidden" :id="`comment-${comment.id}`" :value="comment.id">
                    <div class="card-header bg-white border-0 p-0 border-0 d-flex align-items-center gap-2">
                         <small>
                             <img style="width: 35px;" class="img-thumbnail rounded-circle" :src="`/img/users_avatars/${comment.avatar}`" alt="">
                         </small>
                         <small style="font-size: 12px;" class="fw-bold">{{ comment.user_name }}</small>
                     </div>
                     <div class="card-body p-0 px-2">
                         <div class="comment d-flex flex-column gap-0">
                             <span>
                                 <p style="font-size: 0.9rem;" class="">
                                    {{ comment.comment }}
                                    <br>
                                    <Button @click="showResponseInput(comment.id)" style="font-size: 0.8rem;" class="p-0" text label="Responder..." />
                                 </p>
                                 <span class="d-flex mb-1 d-none" :id="`input-response-box-${comment.id}`">
                                     <input style="font-size: 0.8rem;" v-model="commentResponse.response" class="form-control p-1 text-secondary" type="text" placeholder="your response....">
                                     <Button @click="createResponse(comment.id)" class="p-0" text icon="pi pi-send" />
                                 </span>
                                 <span v-if="comment.response" class="comment-response-content">
                                     <div v-for="response in comment.response" class="card w-75 m-auto border-0 mt-1">
                                         <div class="card-header bg-white border-0 p-0 border-0 d-flex align-items-center gap-2">
                                             <small>
                                                <img style="width: 35px;" class="img-thumbnail rounded-circle" :src="`/img/users_avatars/${response.avatar}`" alt="">
                                             </small>
                                             <small style="font-size: 12px;" class="fw-bold">{{response.user_name}}</small>
                                        </div>
                                        <div class="card-body p-0 px-2">
                                            <p style="font-size: 0.9rem;" class="text-rigth">
                                                {{ response.response }}
                                            </p>
                                        </div>
                                    </div>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <span class="p-text-secondary block mb-5">Seu comentario</span>
            <div class="w-100 d-flex">
                <IconField iconPosition="left" class="p-0">
                    <InputIcon class="pi pi-comment"> </InputIcon>
                    <InputText v-model="commentData.comment" placeholder="comment..." />
                </IconField>
                <Button @click="createComment" text icon="pi pi-send" />
            </div>
        </Dialog>
    </div>
</template>
<script>
export default {
    name: 'TaskCommentComponent',
    props: ['task'],

    data(){
        return {
            visibleShowTaskCommentModal: false,
            showCommentResponseInput: false,
            taskComments: null,
            commentData: {
                comment: null,
                task_id: null
            },
            commentResponse:{
                response: null,
                comment_id: null,
            }
        }
    },
    methods: {
        createComment(){
            this.commentData.task_id = document.getElementById('task-id').value;
            this.Api.post("comments", this.commentData)
            .then(async response =>{
                this.commentData.comment = null;
                this.toaster(await response.data.message).fire();
                this.taskComments = await response.data.data
            })
            .catch(err => console.log(err))
        },
        showResponseInput(id){
            const inputResponse = document.getElementById(`input-response-box-${id}`);
            const classes = inputResponse.className
            classes.includes("d-none") ?
                inputResponse.classList.remove("d-none")
                    : inputResponse.classList.add("d-none")
        },
        createResponse(id){
            this.commentData.task_id = document.getElementById('task-id').value;
            this.commentResponse.comment_id = document.getElementById(`comment-${id}`).value;
            //this.commentResponse.response = this.commentResponse.response;
            Reflect.set(this.commentResponse, "task_id", this.commentData.task_id);
            this.Api.post("comment-response", this.commentResponse)
            .then(async response => {
                this.showResponseInput(id);
                this.toaster(response.data.message).fire()
                this.taskComments = await response.data.data
                this.commentResponse.response = []
            })
            .catch(err => console.log(err))
        },

        listAllCommentByTask(id){
            this.Api.get('comments', {task_id: id})
            .then(async response => {
                this.taskComments = await response.data;
                this.visibleShowTaskCommentModal = true;
            })
            .catch(err => console.log(err))
        },

        toaster(response, severity="success"){
            const Toast = this.$swal.mixin({
                text: response,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                icon: severity,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            return Toast
        },
    }
}
</script>
