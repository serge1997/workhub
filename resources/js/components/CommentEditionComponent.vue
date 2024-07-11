<template>
    <span>
        <input id="task-id" type="hidden" :value="task_id">
        <span class="d-flex gap-1 align-items-center d-none" :id="`edit-comment-box-${comment.id}`">
            <input style="font-size: 0.8rem;" :id="`comment-edit-${comment.id}`" class="form-control p-1 text-secondary" type="text">
            <span>
                <small class="d-flex align-items-center gap-1">
                    <Button @click="updateComment(comment.id)" class="p-0" text>
                        <i style="font-size: .8rem;" class="pi pi-save task-description"></i>
                    </Button>
                    <Button @click="hideCurrentCommentEditBox(comment.id)" class="text-danger p-0" text>
                        <i style="font-size: .8rem;" class="pi pi-times task-description"></i>
                    </Button>
                </small>
            </span>
        </span>
        <small v-if="comment.owner" class="d-flex gap-3 mt-1">
            <Button @click="$emit('softDeleteComment', comment.id)" class="text-danger p-0" text>
                <i style="font-size: .8rem;" class="pi pi-trash task-description"></i>
            </Button>
            <Button @click="getComment(comment.id)" class="p-0" text>
                <i style="font-size: .8rem;" class="pi pi-pencil task-description"></i>
            </Button>
        </small>
    </span>
</template>
<script>
export default{
    name: 'CommentEditionComponent',

    props:{
        task_id: Number,
        isOwner: Boolean,
        response: String,
        comment: Object,
        isComment: Boolean
    },
    data(){
        return {
            commentData: {
                comment_edit: null
            }
        }
    },
    methods: {
        hideCurrentCommentEditBox(id){
            let editBox = document.getElementById('edit-comment-box-'+id);
            editBox.classList.add('d-none')
        },
        getComment(id){
            this.Api.get('comment', {comment_id: id})
            .then(async response => {
                let editBox = document.getElementById('edit-comment-box-'+id);
                let EditInput = document.getElementById(`comment-edit-${id}`)
                this.commentData.comment_edit = await response.data;
                EditInput.value = await this.commentData.comment_edit.comment
                editBox.classList.remove("d-none")
            })
            .catch(err => {
                console.log(err)
            })
        },
        updateComment(id){
            const data = {
                comment: document.getElementById(`comment-edit-${id}`).value,
                comment_id: id,
                task_id: document.getElementById('task-id').value,
            }
            this.Api.put('comment-content', null, data)
            .then(async response => {
                this.hideCurrentCommentEditBox(id);
                this.toaster(response.data.message).fire();
            })
            .catch(error => {
                console.log(error)
            })
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
    },
    mounted() {

    },
}
</script>
