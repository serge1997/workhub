<template>
    <div class="row">
        <div class="col-md-12 d-flex flex-column gap-3">
            <div v-for="(status, index) of execution_status" class="w-100 d-flex flex-column gap-2">
                <div class="w-100 d-flex gap-3">
                    <Button text class="p-1 task-description" @click="listTaskByExecutionStatus(status.id, index, true)">
                        <span><i :class="`pi ${toggleIcon}`" :id="`icon_toggle_${status.id}`"></i></span>
                    </Button>
                    <Tag style="width: 100px;" class="p-2 sprint-list-tag text-white btn-text-nowrap" :style="{'background-color': status.severity}">
                        <span>{{ status.name_ucfirst }}</span>
                    </Tag>
                    <span style="width: 15px;" class="d-flex align-items-center">
                        <Tag :value="status.task_count" class="px-2" severity="secondary" />
                    </span>
                    <Button text class="p-1 task-description">
                        <span><i class="pi pi-ellipsis-h"></i></span>
                    </Button>
                </div>
                <div class="row d-none" :id="`box_list_task_${status.id}`">
                    <TaskListComponent
                        :tasks="tasks[index]"
                        @update-ui="listTaskByExecutionStatus(status.id, index, false)"
                        :task-status="execution_status"
                        @on-selected-task="onSelectedTask"
                    />
                </div>
            </div>
        </div>
        <div class="w-100">
            <TaskToolbarComponent
                :tasks-ids="selected_tasks_ids"
            />
        </div>
    </div>
</template>
<script>
import { useToast } from 'primevue/usetoast';
import { defineAsyncComponent } from 'vue';
export default {
    name: 'TaskListByExecutionStatusComponent',

    components: {
        TaskListComponent: defineAsyncComponent(() =>
            import('./TaskListComponent.vue')
        ),
        TaskToolbarComponent: defineAsyncComponent(() =>
            import('../TaskToolbarComponent.vue')
        )
    },
    props: {
        projectId: Number
    },
    data() {
        return {
            execution_status: [],
            toast: useToast(),
            tasks: [],
            toggleIcon: 'pi-angle-right',
            selected_tasks_ids: []
        }
    },
    methods: {
        onSelectedTask(id){
            const iconTag = document.getElementById(`selected_task_icon_${id}`);
            const li = document.getElementById(`task_list_li_${id}`);
            const all = document.querySelectorAll('.task-list-list-items');
            let classes = [];
            iconTag.classList.toggle('pi-circle');
            iconTag.classList.toggle('pi-circle-fill');
            iconTag.classList.toggle('selected_icon_color')
            li.classList.toggle('selected_task_li')
            all.forEach(el => {
                if (el.classList.contains('selected_task_li')){
                    classes.push('selected_task_li');
                }
            })
            if (classes.includes('selected_task_li')){
                document.getElementById('task-toolbar').classList.remove('d-none')
            }else{
                document.getElementById('task-toolbar').classList.add('d-none')
            }
            if(!this.selected_tasks_ids.includes(id)){
                this.selected_tasks_ids.push(id);
            }else{
                if (!li.classList.contains('selected_task_li')){
                    this.selected_tasks_ids.splice(this.selected_tasks_ids.indexOf(id), 1);
                }
            }
        },
        listAllTaskExecution(){
            this.Api.get('task-execution-status/list-task-by-project/' + this.projectId)
            .then(async response => {
                this.execution_status = await response.data.data;
            })
            .catch(err => {
                console.log(err);
                this.toast.add({ severity: 'error', summary: 'Error', detail: "Error when loaded task status data", life: 3000 });
            })
        },
        listTaskByExecutionStatus(status, index){
            let spanIcon = document.getElementById(`icon_toggle_${status}`);
            this.Api.get(`task/list-by-project/${this.projectId}/status/${status}`)
            .then(async response => {
                this.tasks[index] = await response.data.data;
                document.getElementById(`box_list_task_${status}`).classList.toggle('d-none')
                if (spanIcon.classList.contains('pi-angle-right')){
                    spanIcon.classList.remove('pi-angle-right')
                    spanIcon.classList.add('pi-angle-down')
                }else{
                    spanIcon.classList.remove('pi-angle-down')
                    spanIcon.classList.add('pi-angle-right')
                }
            })
        }
    },
    mounted(){
        this.listAllTaskExecution();
    }
}
</script>
