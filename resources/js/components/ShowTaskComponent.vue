<template>
    <div v-if="taskFinded" class="row">
        <div class="col-md-9">
            <input type="hidden" id="task-id-show" :value="taskFinded.id">
            <div class="row">
                <div class="col-md-12 mb-3 d-flex align-items-center gap-1 border-bottom p-1" id="task-header">
                    <span>
                        <UsersOverlayComponent
                           :is-show-component="true"
                           :user="taskFinded.user_name"
                           @update-task-user="updateTaskUser"
                           :is-for-add-user="true"
                        />
                        <Chip v-if="taskFinded.user_name" class="d-none" :image="`/img/users_avatars/${taskFinded.user_name.avatar}`" :label="taskFinded.user_name.name" />
                    </span>
                    <span class="d-flex">
                        <PriorityOverlayComponent
                            :severity="taskPrioritySeverity(taskFinded.priority)"
                            :entity-priority="taskFinded.priority_fullDescription"
                            :entity-priority-value="taskFinded.priority"
                            :task="taskFinded"
                            @update-ui="$emit('updateShowModalUi')"
                        />
                        <span><Chip class="rounded-0 d-none" label="prioridade"/></span>
                        <Tag class="rounded-0 d-none" :severity="taskPrioritySeverity(taskFinded.priority)" :value="taskFinded.priority_fullDescription" />
                    </span>
                    <span class="d-flex">
                        <Tag icon="pi pi-clock" :value="taskFinded.execution_delay" />
                    </span>
                    <span>
                        <AddTaskRoadMapFastlyComponent
                            :task="taskFinded"
                            @update-ui="$emit('updateShowModalUi')"
                        />
                    </span>
                    <span>
                        <AddFileFastlyComponent
                            :task="taskFinded"
                            @update-ui="$emit('updateShowModalUi')"
                        />
                    </span>
                    <span class="d-flex align-items-center">
                        <div class="position-relative m-auto" style="width: 270px;">
                            <ListTaskExecutionStatusComponent
                                :task="taskFinded"
                                :task-status="taskStatus"
                                component-name="show"
                                :btn-label="taskFinded.full_task_execution_status"
                                :tag-severity="taskSeverity(taskFinded.execution_status)"
                                :tag-value="taskFinded.full_task_execution_status"
                                @list-all-task="$emit('updateShowModalUi')"
                            />
                       </div>
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
                <div class="row d-flex flex-wrap gap-2">
                    <div v-for="annex of taskFinded.annexes" @click="showAnnex(annex.annex)" class="card border rounded-2 col-md-2 gap-1 p-0 annex-card">
                        <div v-if="annex.annex_type == 'image'" class="card-body annex-button-image position-relative p-5" :style="`background-image: url('/task-annex/${annex.annex}');background-repeat: no-repeat;background-size: cover;`">
                        </div>
                        <div v-else class="card-body p-0">
                            <Button
                                @click="showAnnex(annex.annex)"
                                class="d-flex flex-column w-100 gap-1"
                                text>
                                <span>
                                    <i class="pi pi-file-pdf fs-3 task-description"></i>
                                </span>
                                <span>
                                    <small class="task-description">{{ annex.annex_type }}</small>
                                </span>
                            </Button>
                        </div>
                        <div class="card-footer p-1">
                            <div class="w-100 d-flex align-items-center mb-1">
                                <span class="w-100 d-flex justify-content-between gap-1">
                                    <span style="font-size: 0.7em;" class="fw-light">{{ annex.annex_type }}</span>
                                    <span style="font-size: 0.7em;" class="fw-light">{{ annex.created_at }}</span>
                                </span>
                            </div>
                            <div class="w-100 d-flex align-items-center gap-1">
                                <span class="d-flex align-item-center">
                                    <img class="img-thumbnail rounded-circle" style="width: 30px;" :src="`/img/users_avatars/${taskFinded.user_name.avatar}`" alt="">
                                </span>
                                <span class="d-flex align-item-center">
                                    <small style="font-size: 0.8em;">{{ taskFinded.user_name.name }}</small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="taskFinded.customColumnValue" class="row mt-4">
                <div class="com-md-12 mb-3 border-0 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <h4 class="">Colunas personalizadas</h4>
                        <ListCustomColumnsComponents
                            :task_id="taskFinded.id"
                            @update-ui="$emit('updateShowModalUi')"
                        />
                    </div>
                </div>
                <div v-for="custom in taskFinded.customColumnValue" class="col-md-10">
                    <div v-if="custom.label.includes('review')" class="w-100">
                        <div class="w-100 d-flex justify-content-between align-items-center gap-2 mb-4">
                            <label class="text-capitalize custom-column-label" :for="`custom-value-${custom.custom_column_id}`">{{ custom.label}}</label>
                            <InputText @input="seachReviewers(custom.custom_column_id)" :id.trim="`custom-value-${custom.custom_column_id}`" class="w-75 border-0 border-bottom rounded-0 custom-column-input-reviewers custom-column-input" :value="custom.value"/>
                        </div>
                        <div id="reviewers-list-box" style="left: 25%; bottom: 18%; width: 35%; z-index: 10;"class="position-absolute bg-white border shadow-sm p-2 d-none search-reviewer-box rounded-2">
                        </div>
                    </div>
                    <div v-else class="w-100 d-flex justify-content-between align-items-center gap-2 mb-4">
                        <label class="text-capitalize custom-column-label" for="">{{ custom.label}}</label>
                        <InputText @blur="$emit('createCustomValue', custom.custom_column_id, custom.value !== null ? custom.value.length : 0)" :id.trim="`custom-value-${custom.custom_column_id}`" class="w-75 border-0 border-bottom rounded-0 custom-column-input" :value="custom.value"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 rounded-1 d-flex flex-column justify-content-evently">
            <div style="height: 380px;" class="w-100 mb-3 overflow-scroll container">
                <div v-if="taskFinded.activities.length" class="row task-activities-box mb-3 rounded-3">
                    <div class="col-md-10 p-4">
                        <h6>Atividades no task</h6>
                    </div>
                    <div v-for="activity in handleTaskActivitiesData(taskFinded.activities)" class="col-md-12 mb-2">
                        <span class="d-flex align-items-center gap-1">
                            <span class="d-flex align-items-center">
                                <i style="font-size: 0.3em;" class="pi pi-circle-fill task-description text-success"></i>
                            </span>
                            <span class="d-flex align-items-center">
                                <small class="task-activity"><b>{{ activity.author }}</b> {{ activity.activity }} {{ activity.created_at }}</small>
                            </span>
                        </span>
                    </div>
                    <div class="row mt-2 px-2">
                        <div class="col-md-6">
                            <Button @click="listAllActivities(taskFinded.id)" class="task-description fw-normal p-0 d-flex gap-1 align-items-center" text>
                                <span><i style="font-size: 0.8em" :class="`pi ${activitiesBtn.icon}`"></i></span>
                                <span style="font-size: 0.8em">{{ activitiesBtn.label }}</span>
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-11">
                <CommentCardComponent
                    :comments="taskComments"
                    :splited_comments="task_splited_comment"
                    :btn_toggle_label="btn_list_comment_toggle_label"
                    @toggle-all-comments="toggleAllComments"
                />
              </div>
            </div>
            <div class="row p-1">
                <div class="col-md-10">
                    <label class="form-label">Adicionar um comentario: </label>
                    <Textarea @input="onInputCommentValidate" v-model="comment.comment" class="w-100 mb-2 border-0" placeholder="digite o seu comentarios..."/>
                    <div class="w-100 d-flex align-items-center mb-3 gap-2 p-1 border shadow-sm rounded-pill d-none">
                        <Button class="px-0 py-0 task-description" icon="pi pi-file-plus" text/>
                        <Button class="px-0 py-0 task-description" icon="pi pi-image" text/>
                            <Button class="px-0 py-0 task-description" icon="pi pi-at" text/>
                    </div>
                    <Button id="post-comment-btn" @click="postComment(taskFinded.id)" class="rounded-pill w-50 p-disabled" label="Enviar" />
                </div>
            </div>
        </div>
    </div>
    <Button text icon="pi pi-map" />
    <Dialog v-model:visible="visibleShowAnnex" class="min-vh-100 vw-100" maximizable modal header=" " :style="{ width: '100%' }">
        <div class="w-100 vh-100 m-auto d-flex justify-content-center align-items-center">
            <iframe class="iframe border z-4" :src="`/task-annex/${annex}`" width="80%" height="70%" frameborder="0"></iframe>
        </div>
    </Dialog>
</template>
<script>
import ListCustomColumnsComponents from './ListCustomColumnsComponents.vue';
import AddTaskRoadMapFastlyComponent from './AddTaskRoadMapFastlyComponent.vue';
import AddFileFastlyComponent from './AddFileFastlyComponent.vue';
import ListTaskExecutionStatusComponent from './ListTaskExecutionStatusComponent.vue';
import PriorityOverlayComponent from './Overlays/PriorityOverlayComponent.vue';
import UsersOverlayComponent from './Overlays/UsersOverlayComponent.vue'
import CommentCardComponent from './CommentCardComponent.vue';
import { useToast } from 'primevue/usetoast';
export default {
    inject: ['taskSeverity', 'taskPrioritySeverity'],
    name: 'ShowTaskComponent',

    props: ['openModalIcon', 'task_id', 'taskFinded', 'customColumns', 'taskStatus'],
    components: {
        ListCustomColumnsComponents,
        AddTaskRoadMapFastlyComponent,
        AddFileFastlyComponent,
        ListTaskExecutionStatusComponent,
        PriorityOverlayComponent,
        UsersOverlayComponent,
        CommentCardComponent
    },

    data(){
        return {
            visibleShowTaskModal: false,
            visibleShowAnnex: false,
            task: {
                progress: "PRO",
                waiting: "WAT",
                concluded: "CON",
                height: "ALT",
                medium: "MED",
                low: "BAX"
            },
            annex: null,
            reviewersSeleteced: [],
            reviewers: null,
            hasSearchReviewerSymbol: false,
            comment: {
                comment: null,
                task_id: null
            },
            toast: useToast(),
            allTaskActivities: null,
            activitiesBtn:{
                label: 'Ver mais...',
                icon: 'pi-chevron-right',
                actionToggle: false
            },
            taskComments: null,
            task_splited_comment: null,
            btn_list_comment_toggle_label: "todos comentarios..."
        }
    },
    methods:{
        toggleAllComments(){
            if (this.task_splited_comment.length === this.taskComments.length){
                this.btn_list_comment_toggle_label = "Todos comentarios..."
                return this.task_splited_comment = this.taskComments.slice(0, 2);
            }
            this.task_splited_comment = this.taskComments;
            this.btn_list_comment_toggle_label = "ver menos comentarios..."
        },
        listAllCommentByTask(){
            let paramId = this.taskFinded ? this.taskFinded.id : this.task_id;
            this.Api.get('comments', {task_id: paramId})
            .then(async response => {
                this.taskComments = await response.data;
                this.task_splited_comment = this.taskComments.slice(0, 2);
            })
            .catch(err => {
                this.toast.add({ severity: 'error', summary: 'Task', detail: err.response.data.message , life: 3000 });
            })
        },
        updateTaskUser(user_id){
            this.Api.put('task/user', {user_id: user_id, task_id: this.taskFinded.id})
            .then(async response => {
                this.toast.add({ severity: 'success', summary: 'Task', detail: response.data.message , life: 3000 });
                this.$emit('updateShowModalUi');
                this.listAllActivities(this.taskFinded.id);
            })
            .catch(error => {
                this.toast.add({ severity: 'error', summary: 'Task', detail: error.response.data.message, life: 3000 });
            })
        },
        executionStatus(status){
            switch(status) {
                case this.task.waiting :
                    return "danger"
            }
        },
        handleTaskStatus(){

        },
        showAnnex(annex){
            this.annex = annex;
            this.visibleShowAnnex = true;
            setTimeout(() => {
                const iframHeader = document.querySelector('.iframe')
            }, 1000)
        },
        seachReviewers(id){
            let input = document.getElementById(`custom-value-${id}`);
            input.style.color = "#1275d8";
            console.log(input.value)
            if (input.value.includes("@")){
                let param = input.value;
              this.listReviewers(param)
            }
        },
        listReviewers(param){
            this.Api.get('user-search', {user_name: param})
            .then(async response => {
                this.reviewers = await response.data;
                let box = document.getElementById('reviewers-list-box');
                if (box.hasChildNodes()){
                    document.querySelector('#reviewers-list-box .list-group').remove();
                }
                let ul = document.createElement('ul');
                ul.classList.add('list-group')
                for(let user of this.reviewers){
                    let li = document.createElement('li');
                    li.setAttribute('class', 'list_reviewer_item')
                    let content = `<img src="/img/users_avatars/${user.avatar}" style='width: 30px' class='img-thumbnail rounded-circle' />
                        <span data-desc='${user.name}' data-id='${user.id}'>${user.name}</span>`;
                    li.classList.add('list-group-item')
                    li.classList.add('border-0')
                    li.classList.add('d-flex')
                    li.classList.add('gap-2')
                    li.style.cursor = 'pointer'
                    li.innerHTML = content;
                    ul.appendChild(li)
                }
                box.appendChild(ul);
                box.classList.remove('d-none')
                this.onSelectReviewers()
            })
        },
        onSelectReviewers(){
            let self = this;
            setTimeout(() => {
                let els = document.querySelectorAll('.list_reviewer_item');
                let input = document.querySelector('.custom-column-input-reviewers');
                els.forEach((el, index) => {
                    el.addEventListener('click', function(e) {
                       let reviewer_name = e.target.getAttribute('data-desc');
                       if (!self.reviewersSeleteced.includes(reviewer_name)){
                            self.reviewersSeleteced.push(reviewer_name);
                       }
                       input.value = `@${self.reviewersSeleteced.toString().replaceAll(',', ' @')}`;
                    })
                })
            }, 100)
        },
        onInputCommentValidate(){
            let btn = document.querySelector('#post-comment-btn');
            if (this.comment.comment != null){
                btn.classList.remove('p-disabled')
            }else{
                btn.classList.add('p-disabled')
            }
        },
        postComment(taskId){
            this.comment.task_id = taskId;
            this.Api.post('comments', this.comment)
            .then(async response => {
                this.comment.comment = null;
                this.onInputCommentValidate()
                this.toast.add({ severity: 'success', summary: 'commentario', detail: await response.data.message, life: 3000 });
                this.taskComments = await response.data.data;
                this.task_splited_comment = this.taskComments.slice(0, 2);

            })
            .catch(error => {
                this.toast().add({ severity: 'error', summary: 'commentario', detail: 'error o addicionar o commentario', life: 3000 });
            })
        },
        listAllActivities(id){
            this.Api.get('task-activity/list-by-task/' + id)
            .then(async response => {
                this.allTaskActivities = await response.data;
                this.activitiesBtn.label = 'Ver menos...';
                this.activitiesBtn.icon = 'pi-chevron-up';
                if (this.activitiesBtn.actionToggle){
                    this.activitiesBtn.icon = 'pi-chevron-right';
                    this.activitiesBtn.label = 'Ver mais...';
                    this.allTaskActivities = this.taskFinded.activities;
                }
                this.activitiesBtn.actionToggle = !this.activitiesBtn.actionToggle;
            })
        },
        handleTaskActivitiesData(limitedData){
            return this.allTaskActivities == null ? limitedData : this.allTaskActivities;
        },
    },
    created(){

    },
    mounted(){
        this.listAllCommentByTask()
    }
}
</script>
<style scoped>
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
.li-reviewer{
    cursor: pointer;
}
.annex-button-image::before{
    content: '';
    position: absolute;
    width: 100%;
    height: 103%;
    top: 0%;
    left: 0;
    bottom: 0;
    background-color: #64748b;
    z-index: 10;
    opacity: 0.3;
}
.annex-card{
    cursor: pointer;
}
</style>
