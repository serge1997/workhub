<template>
    <div class="col-md-12 m-auto">
        <div class="row">
            <TaskDataTableComponent
                :url="`bi/list-members-tasks/by-team/${$route.params.id}`"
                :is-by-users="true"
                header-group-label="Membros"
                :header-group-label-has-severity="false"
                :has-concluded-column="true"
                global-header-text-color="gray-pure"
                @selected-task="onSelectedTask"
            />
        </div>
    </div>
    <div class="col-md-auto">
        <TaskToolbarComponent
            :tasks-ids="selected_tasks_ids"
        />
    </div>
</template>
<script>
import DataTable from 'primevue/datatable';
import { defineAsyncComponent } from 'vue';

export default {
    name: 'TeamMembersComponent',
    inject: ['taskPrioritySeverity'],

    components: {
        DataTable,
        TaskDataTableComponent: defineAsyncComponent(() =>
            import('../tasks/TaskDataTableComponent.vue')
        ),
        TaskToolbarComponent: defineAsyncComponent(() =>
            import('../TaskToolbarComponent.vue')
        )
    },

    data(){
        return{
            members_data: [],
            expandedRow: null,
            members: [],
            selected_tasks_ids: []
        }
    },
    mounted(){
        this.listTeamMembers();
    },
    methods: {
        onSelectedTask(id, selectedTarget){
            const toolbar = document.getElementById('task-toolbar');
            if (this.selected_tasks_ids.includes(id)){
                this.selected_tasks_ids.splice(this.selected_tasks_ids.indexOf(id));
            }else{
                this.selected_tasks_ids.push(id);
            }
            if (selectedTarget.length){
                toolbar.classList.remove('d-none')
            }else{
                toolbar.classList.add('d-none')
            }
        },
        onRowExpand(){
           console.log(this.expandedRow)
        },
        listTeamMembers(){
            this.Api.get(`user/list-by-team/${this.$route.params.id}`)
            .then(async response => {
                this.members = await response.data.data;
            })
        },
    }
}

</script>
