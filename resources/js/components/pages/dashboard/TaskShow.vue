<template>
    <SidebarComponent @watch-route-params="getTask">
        <div class="row position-relative" id="show-content">
            <div v-if="taskFinded" class="row">
                <div class="col-md-8">
                    <input type="hidden" id="task-id-show" :value="taskFinded.id">
                    <div class="row">
                        <div v-if="taskFinded.user_name" class="col-md-12 mb-3 d-flex align-items-center gap-2 border-bottom p-2" id="task-header">
                            <span>
                                <Chip :image="`/img/users_avatars/${taskFinded.user_name.avatar}`" :label="taskFinded.user_name.name" />
                            </span>
                            <span class="d-flex">
                                <span><Chip class="rounded-0" label="prioridade"/></span>
                                <Tag :severity="taskPrioritySeverity(taskFinded.priority)" :value="taskFinded.priority_fullDescription" />
                            </span>
                            <span class="d-flex">
                                <span><Chip class="rounded-0" label="status"/></span>
                                <Tag class="py-0" :severity="taskSeverity(taskFinded.execution_status)" :value="taskFinded.full_task_execution_status" />
                            </span>
                            <span class="d-flex">
                                <Tag class="py-2 bg-secondary" icon="pi pi-clock" :value="taskFinded.execution_delay" />
                            </span>
                            <span>
                                <AddTaskRoadMapFastlyComponent
                                    :task="taskFinded"
                                />
                            </span>
                            <span>
                                <AddFileFastlyComponent
                                    :task="taskFinded"
                                />
                            </span>
                        </div>
                        <div class="col-md-12 mb-1">
                            <h2 class="task-title text-capitalize">{{ taskFinded.title }}</h2>
                        </div>
                        <div class="col-md-12 p-2">
                            <p>{{ taskFinded.description }}</p>
                        </div>
                    </div>
                    <div v-if="taskFinded.roads_map" class="row" id="road-map">
                        <div v-for="road of taskFinded.roads_map" class="col-md-12">
                            <h6 class="fw-bolder">{{ road.title }}</h6>
                            <div class="w-75">
                                <p>{{ road.description }}</p>
                            </div>
                        </div>
                    </div>
                    <div v-if="taskFinded.annexes" class="row d-flex justify-content-center flex-wrap mt-3" id="task-annexes">
                        <div class="row border-bottom mb-3">
                            <h4 class="">Annexos</h4>
                        </div>
                        <div class="row d-flex justify-content-center flex-wrap gap-2">
                            <Button v-for="annex of taskFinded.annexes" @click="showAnnex(annex.annex)" class="border rounded-2 p-3 d-flex flex-column col-md-2 gap-1" text>
                                <span>
                                    <i class="pi pi-file-pdf fs-3 task-description"></i>
                                </span>
                                <span>
                                    <small class="task-description">{{ annex.annex_type }}</small>
                                </span>
                            </Button>
                        </div>
                    </div>
                    <div v-if="taskFinded.customColumnValue" class="row mt-4">
                        <div class="com-md-12 mb-3 border-0 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <h4 class="">Colunas personalizadas</h4>
                                <ListCustomColumnsComponents :task_id="taskFinded.id"/>
                            </div>
                        </div>
                        <div v-for="custom in taskFinded.customColumnValue" class="col-md-10 d-flex justify-content-between align-items-center gap-2 mb-4">
                            <label class="text-capitalize custom-column-label" for="">{{ custom.label}}</label>
                            <InputText @blur="$emit('createCustomValue', custom.custom_column_id, custom.value.length)" :id.trim="`custom-value-${custom.custom_column_id}`" class="w-75 border-0 border-bottom rounded-0 custom-column-input" :value="custom.value"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 task-activities-box rounded-1">
                    <div class="row">
                        <div class="col-md-10 p-4">
                            <h6>Atividades no task</h6>
                        </div>
                        <div v-for="activity in taskFinded.activities " class="col-md-12 mb-2">
                            <span class="d-flex align-items-center gap-1">
                                <span class="d-flex align-items-center">
                                    <i style="font-size: 0.3em;" class="pi pi-circle-fill task-description text-success"></i>
                                </span>
                                <span class="d-flex align-items-center">
                                    <small class="task-activity"><b>{{ activity.author }}</b> {{ activity.activity }} {{ activity.created_at }}</small>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
           <div class="row">
                <Dialog v-model:visible="visibleNofidedCommentModal" modal style="border-radius: 18px;" :style="{ width: '25rem' }">
                    <div v-if="comment" class="card border-0 comment-card">
                        <div class="row mb-3">
                            <TaskCommentComponent :task="task" icon="pi pi-arrow-up-right" />
                        </div>
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
                                    <p style="font-size: 0.9rem;" class="" id="comment-content" @mouseover="showCommentActionButton(comment.id)">
                                        {{ comment.comment }}
                                        <br>
                                        <div :id="`action-box-${comment.id}`" class="w-100 d-none">
                                            <CommentEditionComponent
                                                :comment="comment"
                                                @soft-delete-comment="SoftDeleteComment"
                                                :isComment="true"
                                                @update-comment="updateComment(comment.id)"
                                                @hide-current-comment-edit-box="hideCurrentCommentEditBox"
                                            />
                                        </div>
                                        <br>
                                        <Button @click="showResponseInput(comment.id)" style="font-size: 0.8rem;" class="p-0" text label="Responder..." />
                                    </p>
                                    <span class="d-flex mb-1 d-none" :id="`input-response-box-${comment.id}`">
                                        <input style="font-size: 0.8rem;" v-model="commentResponse.response" class="form-control p-1 text-secondary" type="text" placeholder="your response....">
                                        <Button @click="createResponse(comment.id)" class="p-0" text icon="pi pi-send" />
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </Dialog>
           </div>
        </div>
    </SidebarComponent>
</template>
<script>
import ListCustomColumnsComponents from './../../ListCustomColumnsComponents.vue';
import AddTaskRoadMapFastlyComponent from './../../AddTaskRoadMapFastlyComponent.vue';
import AddFileFastlyComponent from './../../AddFileFastlyComponent.vue';
import CommentEditionComponent from './../../CommentEditionComponent.vue';
import TaskCommentComponent from './../../TaskCommentComponent.vue';
import { useToast } from 'primevue/usetoast';
export default{
    inject: ['taskSeverity', 'taskPrioritySeverity'],
    name: 'TaskShow',

    components:{
        ListCustomColumnsComponents,
        AddTaskRoadMapFastlyComponent,
        AddTaskRoadMapFastlyComponent,
        CommentEditionComponent,
        TaskCommentComponent

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
            }
        }
    },

    methods:{
        getTask(){
           this.taskFinded = null;
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
        console.log(this.paramId);
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
