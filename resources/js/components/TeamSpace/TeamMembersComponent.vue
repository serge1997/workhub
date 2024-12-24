<template>
    <div class="col-md-12 m-auto">
        <DataTable v-model:expandedRows="expandedRow" :value="members_data"  @rowExpand="onRowExpand">
            <Column style="width: 3rem"  expander />
            <Column>
                <template #header="{data}">
                     <small class="task-description">Members</small>
                </template>
                    <template #body="{data}">
                        {{ data.name }}
                    </template>
            </Column>
            <Column>
                <template #header="{data}">
                     <small class="task-description">Total tarefas</small>
                </template>
                    <template #body="{data}">
                        {{ data.task_count }}
                    </template>
            </Column>
            <Column>
                <template #header="{data}">
                     <small class="task-description">Concluidos</small>
                </template>
                    <template #body="{data}">
                        {{ data.concluded }}
                    </template>
            </Column>
            <template #expansion="slotProps">
                {{ slotProps.data.name }}
            </template>
        </DataTable>
    </div>
</template>
<script>
import DataTable from 'primevue/datatable';

export default {
    name: 'TeamMembersComponent',

    components: {
        DataTable
    },

    data(){
        return{
            members_data: [
                {
                    name: 'Serge',
                    task_count: '100',
                    concluded: '74'
                },
                {
                    name: 'Adriem',
                    task_count: '100',
                    concluded: '14'
                }
            ],
            expandedRow: null
        }
    },
    methods: {
        onRowExpand(){
           console.log(this.expandedRow)
        }
    }
}

</script>
