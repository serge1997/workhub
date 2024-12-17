<template>
    <SidebarComponent @watch-route-params="getTask">
        <ShowTaskComponent
            :task-finded="taskFinded"
            :task-status="taskStatus"
            :task_id="paramId"
            @update-show-modal-ui="getTask"
        />
    </SidebarComponent>
</template>
<script>
import ListCustomColumnsComponents from './../../ListCustomColumnsComponents.vue';
import AddTaskRoadMapFastlyComponent from './../../AddTaskRoadMapFastlyComponent.vue';
import AddFileFastlyComponent from './../../AddFileFastlyComponent.vue';
import CommentEditionComponent from './../../CommentEditionComponent.vue';
import TaskCommentComponent from './../../TaskCommentComponent.vue';
import { useToast } from 'primevue/usetoast';
import ShowTaskComponent from '../../ShowTaskComponent.vue';
export default{
    inject: ['taskSeverity', 'taskPrioritySeverity'],
    name: 'TaskShow',

    components:{
        ListCustomColumnsComponents,
        AddTaskRoadMapFastlyComponent,
        AddTaskRoadMapFastlyComponent,
        CommentEditionComponent,
        TaskCommentComponent,
        ShowTaskComponent

    },
    watch:{
        paramId(before, now){
            this.paramId = now;
            console.log(now)
        }
    },

    data(){
        return {
            paramId: this.$route.params.task_id,
            taskFinded: null,
            visibleNofidedCommentModal: false,
            comment: null,
            commentResponse:{
                response: null,
                comment_id: null,
            },
            toast: useToast(),
            task:{
                id: null
            },
            taskStatus: null
        }
    },

    methods:{
        onListAllTaskExecutionStatus(){
            this.Api.get('task-execution-status')
            .then(async response => {
                this.task_status = await response.data;
                this.taskStatus = await response.data;
            })
            .catch(err => {
                console.log(err);
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded task status data", life: 3000 });
            })
        },
        getTask(){
           setTimeout(() => {
            this.Api.get('task', {task_id: this.$route.params.task_id})
            .then(async response => {
                this.task.id = this.$route.params.task_id;
                this.getNotificationContent(this.$route.params.type, this.$route.params.origin_id);
                this.taskFinded = await response.data;
            })
            .catch(err => console.log(err));
           }, 500)
        },
        showAnnex(annex){
            this.annex = annex;
            this.visibleShowAnnex = true;
            setTimeout(() => {
                const iframHeader = document.querySelector('.iframe')
            }, 1000)
        },
        findComment(comment){
            this.Api.get('comment', {comment_id: comment})
            .then(async response => {
                this.comment = await response.data;
                this.visibleNofidedCommentModal = true;
                console.log(await response.data)
            })
            .catch(error => {
                console.log(error)
            })
        },
        getNotificationContent(type, origin_id){
            switch(type) {
                case "comment" :
                    this.findComment(origin_id)
                    break;
            }
        },
        SoftDeleteComment(id){
            let task = document.getElementById('task-id').value;
            this.Api.put('comment', {comment_id: id, task_id: task})
            .then(async response => {
                this.taskComments = await response.data.data;
                this.toaster(response.data.message).fire()
            })
            .catch(error => {
                error.response.status === 403 ? this.toaster(error.response.data, "error").fire() : null
            })
        },
        updateComment(id){
            const data = {
                comment: document.getElementById(`comment-edit-${id}`).value,
                comment_id: id,
                task_id: this.$route.params.task_id
            }
            this.Api.put('comment-content', null, data)
            .then(async response => {
                this.hideCurrentCommentEditBox(id);
                return this.findComment(id);
            })
            .catch(error => {
                console.log(error)
            })
        },
        hideCurrentCommentEditBox(id){
            let editBox = document.getElementById('edit-comment-box-'+id);
            editBox.classList.add('d-none')
        },
        showCommentActionButton(id){
            const box = document.getElementById('action-box-'+id);
            box.classList.remove('d-none')
        },
        showResponseInput(id){
            const inputResponse = document.getElementById(`input-response-box-${id}`);
            const classes = inputResponse.className
            classes.includes("d-none") ?
                inputResponse.classList.remove("d-none")
                    : inputResponse.classList.add("d-none")
        },
        createResponse(id){
            this.commentResponse.comment_id = id;
            Reflect.set(this.commentResponse, "task_id", this.$route.params.task_id);
            this.Api.post("comment-response", this.commentResponse)
            .then(async response => {
                this.showResponseInput(id);
                this.toast.add({ severity: 'success', summary: 'Message', detail: await response.data.message, life: 3000 });
            })
            .catch(err => console.log(err))
        },
    },
    created(){
        this.paramId = this.$route.params.task_id;
        console.log(this.paramId);
    },
    mounted(){
        this.getTask()
        this.onListAllTaskExecutionStatus();
    }
}
</script>
<style scoped>
#show-content{
    background-color: #fff;
}

.task-title{
    font-weight: 600;
}
.custom-column-label{
    font-weight: 600;
}

.custom-column-input{
    background-color: #f1f5f9;
}
.task-activities-box{
    background-color: #f1f5f9;
}
.task-activity {
    font-size: 0.8em;
    color: #64748b;
}
</style>
