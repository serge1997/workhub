<template>
    <div v-for="comment of comments" class="card p-1 shadow-sm border-0 mb-3">
        <div class="card-header bg-white border-0 p-0 border-0 d-flex align-items-center gap-2">
            <small>
                <img style="width: 35px;" class="img-thumbnail rounded-circle" :src="`/img/users_avatars/${comment.avatar}`">
            </small>
            <small style="font-size: 12px;" class="fw-bold">Serge Gogo</small>
        </div>
        <div class="card-body p-1">
            {{comment.comment}}
        </div>
    </div>
</template>
<script>
export default {
    name: 'CommentCardComponent',

    props: {
        comments: Object
    }
}
</script>
