<template>
    <div class="col-md-12" v-if="tasks">
        <ul class="list-group w-100 m-auto">
            <li v-for="(task, index) in tasks"
                draggable="true"
                class="list-group-item p-0 w-100 task-list-list-items d-flex flex-column border-0"
                @mouseover="showSelectedButton(task.id)"
                @mouseleave="hiddeSelectedButton(task.id)"
                :id="`task_list_li_${task.id}`"
                @dragstart="onDragstart"
                @dragenter="onDragenter"
                @dragleave="onDragleave"
                @dragover="onDragover"
                @drop="onDrop"
            >
                <div draggable="false" v-if="!task.is_sub_task" class="w-100 border-bottom d-flex gap-2 p-2">
                    <div class="d-flex align-items-center select_btn_div_box">
                        <span class="d-flex align-items-center d-none" :id="`selected_btn_box_${task.id}`">
                        <Button @click="$emit('onSelectedTask', task.id)" class="p-0" text>
                            <i :id="`selected_task_icon_${task.id}`" :class="`pi pi-circle task-description`"></i>
                        </Button>
                        </span>
                    </div>
                    <div class="col-md-12 btn-text-nowrap d-flex justify-content-between">
                        <span class="d-flex justify-content-start gap-3 p-1">
                            <span>
                                <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': task.execution_status_severity}"></i>
                            </span>
                            <span class="task-description">
                                <small>{{ task.title }}</small>
                            </span>
                            <span class="d-flex align-items-center">
                                <Tag class="p-1 v-small-fs" :style="`background-color: ${task.execution_status_severity}`" :value="task.full_task_execution_status" />
                            </span>
                            <span class="d-flex align-items-center p-0" title="Prioridade da tarefa">
                                <Tag severity="warning">
                                    <small class="v-small-fs">{{ task.priority_fullDescription }}</small>
                                </Tag>
                            </span>
                            <span class="task-description" title="Sprint da tarefa">
                                <small class="v-small-fs">{{ task.sprint_name }}</small>
                            </span>
                            <span v-if="task.sub_task_count" class="task-description" title="Sprint da tarefa">
                                <Button @click="listSubTaskByParent(task.id, index)" text  class="p-0 task-description">
                                    <small><i class="pi pi-share-alt v-small-fs"></i></small>
                                </Button>
                            </span>
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <Button class="p-1" @click="showSubTaskForm(task.id)" severity="secondary" text>
                                <i class="pi pi-plus v-small-fs icon-list-task"></i>
                            </Button>
                            <ListTaskExecutionStatusComponent
                                :task="task"
                                @list-all-task="$emit('updateUi')"
                                :task-status="taskStatus"
                            />
                            <Button class="p-1" @click="showTask(task.id)" severity="secondary" text>
                                <i class="pi pi-align-center v-small-fs icon-list-task"></i>
                            </Button>
                        </span>
                    </div>
                </div>
                <div v-if="sub_tasks[index]" class="w-100">
                    <ul class="list-group">
                        <li v-for="sub in sub_tasks[index]" class="list-group-item w-100 task-list-list-items d-flex flex-column border-0 mb-1 p-2 px-4">
                            <div class="w-100 border-bottom d-flex align-items-center gap-2">
                                <span class="cursor-p" @click="detachSubTask(sub)" title="Detach sub task"><Tag icon="pi pi-reply" severity="secondary" /></span>
                                <div class="col-md-12 btn-text-nowrap d-flex justify-content-between">
                                    <span class="d-flex justify-content-start gap-3 p-1">
                                        <span>
                                            <i style="font-size: 0.6em;" class="pi pi-flag-fill" :style="{'color': sub.execution_status_severity}"></i>
                                        </span>
                                        <span class="task-description">
                                            <small>{{ sub.title }}</small>
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <Tag class="p-1 v-small-fs" :style="`background-color: ${sub.execution_status_severity}`" :value="sub.full_task_execution_status" />
                                        </span>
                                        <span class="d-flex align-items-center p-0" title="Prioridade da tarefa">
                                            <Tag severity="warning">
                                                <small class="v-small-fs">{{ sub.priority_fullDescription }}</small>
                                            </Tag>
                                        </span>
                                        <span class="task-description" title="Sprint da tarefa">
                                            <small class="v-small-fs">{{ sub.sprint_name }}</small>
                                        </span>
                                    </span>
                                    <span class="d-flex align-items-center gap-2">
                                        <ListTaskExecutionStatusComponent
                                            :task="sub"
                                            @list-all-task="$emit('updateUi')"
                                            :task-status="taskStatus"
                                        />
                                        <Button class="p-1" @click="showTask(sub.id)" severity="secondary" text>
                                            <i class="pi pi-align-center v-small-fs icon-list-task"></i>
                                        </Button>
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <CreateSubTaskComponent
                    :task-status="taskStatus"
                    :task-id="task.id"
                    @hidden-sub-task-form="hiddenSubTaskForm(task.id)"
                    @update-sub-task-list-ui="listSubTaskByParent(task.id, index)"
                />
            </li>
        </ul>
    </div>
    <ConfirmDialog />
    <Toast />
    <div class="w-100">
        <Dialog v-model:visible="visibleShowTaskModal" maximizable modal header=" " :style="{ width: '95rem' }">
            <ShowTaskComponent
                class="p-0"
                :task-finded="task_finded",
                :task-status="taskStatus"
                @create-custom-value="createCustomValue"
                @update-show-modal-ui="showTask(task_selected_id)"
            />
        </Dialog>
    </div>
</template>
<script>
import { defineAsyncComponent } from 'vue';
import ListTaskExecutionStatusComponent from '../ListTaskExecutionStatusComponent.vue';
import { useToast } from "primevue/usetoast";
import { useConfirm } from 'primevue/useconfirm';

export default {
    name: 'TaskListComponent',
    props: {
        tasks: Object,
        taskStatus: Object
    },
    components: {
        ListTaskExecutionStatusComponent,
        ShowTaskComponent: defineAsyncComponent({
            loader: () => import('../ShowTaskComponent.vue')
        }),
        TaskToolbarComponent: defineAsyncComponent(() =>
            import('../TaskToolbarComponent.vue')
        ),
        CreateSubTaskComponent: defineAsyncComponent(() =>
            import('./../tasks/CreateSubTaskComponent.vue')
        )
    },
    data(){
        return {
            task_finded: null,
            visibleShowTaskModal: false,
            toast: useToast(),
            task_selected_id: null,
            task_selected_action_icon: 'pi-circle',
            selected_tasks_ids: [],
            sub_tasks: [],
            confirm: useConfirm(),
            cloneNode: null
        }
    },
    methods: {
        onDragstart(event){
            let target_id = event.target.getAttribute('id');
            event.dataTransfer.setData('text/plain', target_id);
            //this.cloneNode = event.target.cloneNode(true);
            //document.body.appendChild(this.cloneNode);
            //event.dataTransfer.setDragImage(this.cloneNode, cloneNode.offsetWidth / 2, this.cloneNode.offsetHeight / 2 )
            setTimeout(() => {
                event.target.classList.add('d-none')
            }, 0)
            console.log("drag start...."+target_id)
        },
        onDragenter(event){
            console.log("drag enter....")
            event.preventDefault();
        },
        onDragover(event){
            event.preventDefault();
            event.target.classList.add('li-dragover')
        },
        onDragleave(event){
            event.target.classList.remove('li-dragover')
        },
        onDrop(event){
            event.preventDefault();
            let id = event.dataTransfer.getData('text/plain');
            const dropable = document.getElementById(id);
            dropable.classList.remove('d-none')
            event.target.insertAdjacentElement('afterend', dropable)
            event.target.classList.remove('li-dragover')
            dropable.classList.remove('d-none')
            dropable.classList.remove('li-dragover')
            //this.cloneNode.remove()
        },
        detachSubTask(subTask){
            this.confirm.require({
                message: 'Você quer deletar a relação ?',
                header: 'Atenção !!!',
                icon: 'pi pi-exclamation-triangle',
                rejectLabel: 'Caneclar',
                acceptLabel: 'Confirmar',
                accept: () => {
                    this.Api.delete(`sub-task/detach/${subTask.id}`)
                    .then(async response => {
                        this.toast.add({ severity: 'success', summary: 'successo', detail: await response.data.message, life: 3000 });
                    })
                    .catch(error => {
                        this.toast.add({ severity: 'error', summary: 'error', detail: error.response.data.message, life: 3000 });
                    })

                },
                reject: () => {

                }
            });
        },
        listSubTaskByParent(task_id, index){
            this.Api.get(`sub-task/list-by-parent?task_id=${task_id}`)
            .then(async response => {
                this.sub_tasks[index] = await response.data.data;
            })
            .catch(error => {
                this.toast.add({ severity: 'error', summary: 'error', detail: error.response.data.message, life: 3000 });
            })
        },
        hiddenSubTaskForm(id){
            document.getElementById(`subtask-box-${id}`).classList.add('d-none')
            document.getElementById('sub_task_title-'+id).value = null;
        },
        showSubTaskForm(id){
            document.getElementById(`subtask-box-${id}`).classList.remove('d-none')
        },
        showTask(id){
            this.Api.get('task', {task_id: id})
            .then(async response => {
                this.task_finded = await response.data.data;
                this.visibleShowTaskModal = true;
                this.task_selected_id = id;
            })
            .catch(err => console.log(err));
        },
        createCustomValue(column_id, length){
            const value = document.getElementById(`custom-value-${column_id}`).value;
            const data = {
                value: value,
                custom_column_id: column_id,
                task_id: this.task_finded.id
            };
            if (value !== null && value !== undefined && value.length > length || value.length < length){
                this.Api.put('custom-column-value', null, data)
                .then(async response => {
                    this.toast.add({ severity: 'success', summary: 'successo', detail: await response.data.message, life: 3000 });
                    this.$emit('updateUi');
                })
                .catch(error => {
                    this.toast.add({ severity: 'error', summary: 'error', detail: error.response.data.message, life: 3000 });
                })
            }
        },
        showSelectedButton(id){
            let box = document.getElementById(`selected_btn_box_${id}`);
            box.classList.remove('d-none');
        },
        hiddeSelectedButton(id){
            let box = document.getElementById(`selected_btn_box_${id}`);
            let iconCheck = document.getElementById(`selected_task_icon_${id}`);
            //iconCheck.classList.contains
            if (iconCheck.classList.contains('pi-circle')){
                box.classList.add('d-none');
            }
        },
    },
    mounted(){

    }
}
</script>
<style>
.select_btn_div_box{
    transition: ease-in .3s;
    width: 30px;
}
.selected_icon_color{
    color: #9ca3af;
}
.selected_task_li {
    background-color: #f0f9ff;
}
.li-dragover{
    border-bottom: #3b82f6 2px solid;
}
</style>
