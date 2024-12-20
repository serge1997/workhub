<template>
    <div class="w-100">
        <div v-if="splited_comments" v-for="comment of splited_comments" class="card p-1 shadow-sm border-0 mb-3">
            <div class="card-header bg-white border-0 p-0 border-0 d-flex align-items-center gap-2">
                <small>
                    <img style="width: 35px;" class="img-thumbnail rounded-circle" :src="`/img/users_avatars/${comment.avatar}`">
                </small>
                <small style="font-size: 12px;" class="fw-bold">Serge Gogo</small>
            </div>
            <div class="card-body p-1">
                {{comment.comment}}
            </div>
            <div class="card-footer border-0 bg-transparent d-flex justify-content-between p-0 px-1">
                <span class="d-flex align-items-center">
                    <Button text severity="warning" class="p-0 task-description">
                        <span><i class="pi pi-thumbs-up"></i></span>
                    </Button>
                </span>
                <span class="d-flex align-items-center">
                    <small class="task-description v-small-fs">{{ comment.since }}</small>
                </span>
            </div>
        </div>
        <div class="col-md-10">
            <Button @click="$emit('toggleAllComments')" text class="p-0 task-description">
                <small>{{ btn_toggle_label }}</small>
            </Button>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CommentCardComponent',

    props: {
        comments: Object,
        splited_comments: Object,
        btn_toggle_label: String
    },
    data(){
        return {
        }
    },
    methods: {
    },
    mounted(){
        

    }
}
</script>
