<template>
    <span v-if="response.owner">
        <input id="task-id" type="hidden" :value="task_id">
        <input id="comment-id" type="hidden" :value="response.comment_id">
        <span class="d-flex gap-1 align-items-center d-none" :id="`edit-response-box-${response.id}`">
            <input style="font-size: 0.8rem;" :id="`response-edit-${response.id}`" class="form-control p-1 text-secondary" type="text">
            <span>
                <small class="d-flex align-items-center gap-1">
                    <Button @click="$emit('updateCommentResponse', response.id)" class="p-0" text>
                        <i style="font-size: .8rem;" class="pi pi-save task-description"></i>
                    </Button>
                    <Button @click="$emit('hideCurrentCommentResponseEditBox', response.id)" class="text-danger p-0" text>
                        <i style="font-size: .8rem;" class="pi pi-times task-description"></i>
                    </Button>
                </small>
            </span>
        </span>
        <small class="d-flex gap-3 mt-1">
            <Button @click="$emit('softDeleteCommentResponse', response.id)" class="text-danger p-0" text>
                <i style="font-size: .8rem;" class="pi pi-trash task-description"></i>
            </Button>
            <Button @click="getCommentResponse(response.id)" class="p-0" text>
                <i style="font-size: .8rem;" class="pi pi-pencil task-description"></i>
            </Button>
        </small>
    </span>
</template>
<script>
export default{
    name: 'CommentResponseEditionComponent',

    props:{
        task_id: Number,
        isOwner: Boolean,
        response: Object,
        isComment: Boolean
    },
    data(){
        return {
            commentResponseData: {
                response_edit: null
            }
        }
    },
    methods: {
        getCommentResponse(id){
            this.Api.get('comment-response/response', {response_id: id})
            .then(async response => {
                let editBox = document.getElementById('edit-response-box-'+id);
                let EditInput = document.getElementById(`response-edit-${id}`)
                this.commentResponseData.response_edit = await response.data;
                EditInput.value = await this.commentResponseData.response_edit.response
                editBox.classList.remove("d-none")
            })
            .catch(err => {
                console.log(err)
            })
        },
        // updateCommentResponse(id){
        //     const data = {
        //         response: document.getElementById(`response-edit-${id}`).value,
        //         response_id: id,
        //         task_id: document.getElementById('task-id').value,
        //         comment_id: document.getElementById('comment-id').value
        //     }
        //     this.Api.put('comment-response', null, data)
        //     .then(async response => {
        //         this.hideCurrentCommentResponseEditBox(id);
        //         this.toaster(response.data.message).fire();
        //     })
        //     .catch(error => {
        //         console.log(error)
        //     })
        // },
        SoftDeleteCommentResponse(id){
            let comment_id = document.getElementById('comment-id').value;
            this.Api.delete('comment-response', {response_id: id, comment_id: comment_id})
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
