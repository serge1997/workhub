<template>
    <Button class="p-1" @click="visibleShowTaskModal = !visibleShowTaskModal; $emit('showTask', task_id)" text>
        <i :class="`pi ${openModalIcon} icon-list-task`"></i>
    </Button>
    <Dialog v-model:visible="visibleShowTaskModal" maximizable modal header=" " :style="{ width: '95rem' }">
        <div v-if="taskFinded" class="row">
            <div class="col-md-9">
                <input type="hidden" id="task-id-show" :value="taskFinded.id">
                <div class="row">
                    <div v-if="taskFinded.user_name" class="col-md-12 mb-3 d-flex align-items-center gap-2 border-bottom p-2" id="task-header">
                        <span>
                            <Chip :image="`/img/users_avatars/${taskFinded.user_name.avatar}`" :label="taskFinded.user_name.name" />
                        </span>
                        <span class="d-flex">
                            <span><Chip class="rounded-0" label="prioridade"/></span>
                            <Tag :severity="setSeverity(taskFinded.priority)" :value="taskFinded.priority_fullDescription" />
                        </span>
                        <span class="d-flex">
                            <Tag class="py-2 bg-secondary text-white" icon="pi pi-clock" :value="taskFinded.execution_delay" />
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
                        <span class="d-flex align-items-center">
                            <span><Chip class="rounded-3 border" label="status"/></span>
                            <div class="position-relative m-auto" style="width: 270px;">
                                <ListTaskExecutionStatusComponent
                                    :task="taskFinded"
                                    :task-status="taskStatus"
                                    component-name="show"
                                    :btn-label="taskFinded.full_task_execution_status"
                                    :tag-severity="setStatusSeverity(taskFinded.execution_status)"
                                    :tag-value="taskFinded.full_task_execution_status"
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
                            <InputText @blur="$emit('createCustomValue', custom.custom_column_id, custom.value.length)" :id.trim="`custom-value-${custom.custom_column_id}`" class="w-75 border-0 border-bottom rounded-0 custom-column-input" :value="custom.value"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 rounded-1 d-flex flex-column justify-content-between">
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
                <div class="row p-1">
                    <div class="col-md-10">
                        <label class="form-label">Adicionar um comentario: </label>
                        <InputText @input="onInputCommentValidate" v-model="comment.comment" class="w-100 mb-2" placeholder="digite o seu comentarios..."/>
                        <div class="w-100 d-flex align-items-center mb-3 gap-2 p-1 border shadow-sm rounded-pill">
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
        <Dialog v-model:visible="visibleShowAnnex" class="min-vh-100" maximizable modal header="" :style="{ width: '100%' }">
            <iframe class="iframe min-vh-100" :src="`/task-annex/${annex}`" width="100%" height="100%" frameborder="0"></iframe>
        </Dialog>

    </Dialog>
</template>
<script>
import ListCustomColumnsComponents from './ListCustomColumnsComponents.vue';
import AddTaskRoadMapFastlyComponent from './AddTaskRoadMapFastlyComponent.vue';
import AddFileFastlyComponent from './AddFileFastlyComponent.vue';
import ListTaskExecutionStatusComponent from './ListTaskExecutionStatusComponent.vue';
import { useToast } from 'primevue/usetoast';
export default {
    name: 'ShowTaskComponent',

    props: ['openModalIcon', 'task_id', 'taskFinded', 'customColumns', 'taskStatus'],
    components: {
        ListCustomColumnsComponents,
        AddTaskRoadMapFastlyComponent,
        AddFileFastlyComponent,
        ListTaskExecutionStatusComponent
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
        }
    },
    methods:{
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
        setSeverity(priority){
            if(priority === "ALT")  return "danger";
            if (priority === "MED") return "warning";
            return "success";
        },
        setStatusSeverity(status){
            if(status === "WAT")  return "warning";
            if (status === "PRO") return "primary";
            return "success";
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
            let btn = document.querySelector('#post-comment-btn')
            console.log(btn)
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
</style>
