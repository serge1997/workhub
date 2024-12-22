<template>
    <div class="w-100">
        <div v-if="showStatus == 'WAT'">
            <div class="mb-2 dropable-target-WAT"></div>
            <div v-for="task in filterAwait(tasks)"
                @dragstart="onDragstart"
                @dragenter="onDragenter"
                @dragleave="onDragleave"
                @dragover="onDragover"
                @drop="onDrop"
                :id="`task-card-${task.id}`"
                draggable="true"
                class="card shadow-sm border-0 mb-3 tttt"
                :class="`${task.execution_status}-target`"
            >
                <div class="card-body" :class="`${task.execution_status}-target`">
                    <div class="w-100 mb-1" :class="`${task.execution_status}-target`">
                        <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                    </div>
                    <TaskCardIconsComponent
                        :class="`${task.execution_status}-target`"
                        :task="task"
                        @confirm-delete = "$emit('confirmDelete', task.id)"
                        @list-all-task="$emit('listAllTask')"
                        :task-status="taskStatus"
                    />
                </div>
            </div>
        </div>
        <div v-if="showStatus == 'PRO'">
            <div class="mb-2 dropable-target-PRO"></div>
            <div draggable="true" v-for="task in filterInProgress(tasks)"
                @dragstart="onDragstart"
                @dragenter="onDragenter"
                @dragleave="onDragleave"
                @dragover="onDragover"
                @drop="onDrop"
                :id="`task-card-${task.id}`"
                :class="`${task.execution_status}-target`"
                class="card shadow-sm border-0 mb-1">
                <div class="mb-2 dropable-target"></div>
                <div class="card-body mb-2" :class="`${task.execution_status}-target`">
                    <div class="w-100 mb-1" :class="`${task.execution_status}-target`">
                        <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                    </div>
                    <TaskCardIconsComponent
                        :class="`${task.execution_status}-target`"
                        :task="task"
                        @confirm-delete = "$emit('confirmDelete', task.id)"
                        @handle-task-status="$emit('handleTaskStatus')"
                        @list-all-task="$emit('listAllTask')"
                        :task-status="taskStatus"

                    />
                </div>
            </div>
        </div>
        <div v-if="showStatus == 'CDR'">
            <div class="mb-2 dropable-target-CDR"></div>
            <div draggable="true" v-for="task in filterCodeReview(tasks)"
                @dragstart="onDragstart"
                @dragenter="onDragenter"
                @dragleave="onDragleave"
                @dragover="onDragover"
                @drop="onDrop"
                :id="`task-card-${task.id}`"
                class="card shadow-sm border-0 mb-1"
                :class="`${task.execution_status}-target`"
            >
                <div class="card-body" :class="`${task.execution_status}-target`">
                    <div class="w-100 mb-1" :class="`${task.execution_status}-target`">
                        <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                    </div>
                    <TaskCardIconsComponent
                        :class="`${task.execution_status}-target`"
                        :task="task"
                        @confirm-delete = "$emit('confirmDelete', task.id)"
                        @handle-task-status="$emit('handleTaskStatus')"
                        @list-all-task="$emit('listAllTask')"
                        :task-status="taskStatus"
                    />
                </div>
            </div>
        </div>
        <div v-if="showStatus == 'TST'">
            <div class="mb-2 dropable-target-TST"></div>
            <div draggable="true" v-for="task in filterTeste(tasks)"
                @dragstart="onDragstart"
                @dragenter="onDragenter"
                @dragleave="onDragleave"
                @dragover="onDragover"
                @drop="onDrop"
                :id="`task-card-${task.id}`"
                class="card shadow-sm border-0 mb-1"
                :class="`${task.execution_status}-target`"
            >
                <div class="card-body"  :class="`${task.execution_status}-target`">
                    <div class="w-100 mb-1" :class="`${task.execution_status}-target`">
                        <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                    </div>
                    <TaskCardIconsComponent
                        :class="`${task.execution_status}-target`"
                        :task="task"
                        @confirm-delete = "$emit('confirmDelete', task.id)"
                        @handle-task-status="$emit('handleTaskStatus')"
                        @list-all-task="$emit('listAllTask')"
                        :task-status="taskStatus"
                    />
                </div>
            </div>
        </div>
        <div v-if="showStatus == 'PRQ'">
            <div class="mb-2 dropable-target-PRQ"></div>
            <div draggable="true"v-for="task in filterPullrequest(tasks)"
                @dragstart="onDragstart"
                @dragenter="onDragenter"
                @dragleave="onDragleave"
                @dragover="onDragover"
                @drop="onDrop"
                :id="`task-card-${task.id}`"
                class="card shadow-sm border-0 mb-1"
                :class="`${task.execution_status}-target`"
            >
                <div class="card-body" :class="`${task.execution_status}-target`">
                    <div class="w-100 mb-1" :class="`${task.execution_status}-target`">
                        <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                    </div>
                    <TaskCardIconsComponent
                        :class="`${task.execution_status}-target`"
                        :task="task"
                        @confirm-delete = "$emit('confirmDelete', task.id)"
                        @handle-task-status="$emit('handleTaskStatus')"
                        @list-all-task="$emit('listAllTask')"
                        :task-status="taskStatus"
                    />
                </div>
            </div>
        </div>
        <div v-if="showStatus == 'CON'">
            <div class="mb-2 dropable-target-CON"></div>
            <div draggable="true" v-for="task in filterConcluded(tasks)"
                @dragstart="onDragstart"
                @dragenter="onDragenter"
                @dragleave="onDragleave"
                @dragover="onDragover"
                @drop="onDrop"
                :id="`task-card-${task.id}`"
                class="card shadow-sm border-0 mb-1"
                :class="`${task.execution_status}-target`"
            >
                <div class="card-body" :class="`${task.execution_status}-target`">
                    <div class="w-100 mb-1" :class="`${task.execution_status}-target`">
                        <small class="fw-medium task-description">{{ task.title.padEnd(20, '...') }}</small>
                    </div>
                    <TaskCardIconsComponent
                        :class="`${task.execution_status}-target`"
                        :task="task"
                        @confirm-delete = "$emit('confirmDelete', task.id)"
                        @handle-task-status="$emit('handleTaskStatus')"
                        @list-all-task="$emit('listAllTask')"
                        :task-status="taskStatus"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TaskCardIconsComponent from '../TaskCardIconsComponent.vue';
import ShowTaskAnnexComponent from '../ShowTaskAnnexComponent.vue';
import { defineAsyncComponent } from 'vue';
export default{
    name: 'CardTaskComponent',
    props: {
        showStatus: String,
        tasksProgress: Object,
        tasksWait: Object,
        tasksConcluded: Object,
        taskExecutionStatus: Object,
        tasks: Object,
        taskStatus: Object
    },
    components: {
        ShowTaskComponent: defineAsyncComponent(() =>
            import('../ShowTaskComponent.vue')
        ),
        TaskCardIconsComponent,
        ShowTaskAnnexComponent
    },
    data(){
        return {
            task: {
                progress: null,
                waiting: null,
                concluded: null,
            },
            task_finded: null,
            task_await: null
        }
    },
    provide(){
        return {
            task_exec_status: this.taskExecutionStatus
        }
    },
    methods:{
        onDragstart(event){
            let target_id = event.target.getAttribute('id');
            event.dataTransfer.setData('text/plain', target_id);
            setTimeout(() => {
                event.target.classList.add('d-none')
            }, 0)
        },
        onDragenter(event){
            event.preventDefault();
        },
        onDragover(event){
            event.preventDefault();
        },
        onDragleave(event){
            let id = event.dataTransfer.getData('text/plain');

        },
        onDrop(event){
            event.preventDefault();
            let id = event.dataTransfer.getData('text/plain');
            const dropable = document.getElementById(id);
            //dropable.classList.toString();
            let targetClass = event.target.parentElement;
            let classe = targetClass.classList.toString().split(' ').pop();
            let classIdentification = classe.split('-').shift();
            console.log(classIdentification)
            //event.target.insertAdjacentElement('afterend', dropable)
            //event.target.appendChild(dropable)
            document.querySelector(`.dropable-target-${classIdentification}`).appendChild(dropable)
            dropable.classList.remove('d-none')
        },
        showTask(id){
            this.task_finded = null;
            this.Api.get('task', {id: id})
            .then(async response => {
                this.task_finded = await response.data;
            })
        },
        filterAwait(tasks){
           if (tasks != null){
                const wait = tasks.filter(task => task.execution_status == 'WAT');
                return wait;
           }
        },
        filterInProgress(tasks){
            if (tasks != null){
                const progress = tasks.filter(task => task.execution_status == 'PRO');
                return progress;
            }
        },
        filterConcluded(tasks){
           if (tasks != null){
                const concluded = tasks.filter(task => task.execution_status == 'CON');
                return concluded;
           }
        },
        filterCodeReview(tasks){
            if (tasks != null){
                const codereview = tasks.filter(task => task.execution_status == 'CDR');
                return codereview;
            }
        },
        filterTeste(tasks){
           if (tasks != null){
                const teste = tasks.filter(task => task.execution_status == 'TST');
                return teste;
           }
        },
        filterPullrequest(tasks){
           if (tasks != null){
                const pullrequest = tasks.filter(task => task.execution_status == 'PRQ');
                return pullrequest;
           }
        },
        filterBacklog(tasks){
            if (tasks != null){
                const backlog = tasks.filter(task => task.execution_status == 'BKL');
                return backlog;
            }
        }
    },
    mounted(){
    }
}
</script>
