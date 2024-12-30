<template>
    <div class="container">
        <div class="row mt-3">
            <DataTable
                :value="users"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                currentPageReportTemplate="{first} até {last} de {totalRecords} registros"
            >
                <template #header>
                    <div class="w-100">
                        <h6>Usuarios</h6>
                    </div>
                </template>
                <Column>
                    <template #header>
                        <div>
                            <small class="task-description">#</small>
                        </div>
                    </template>
                    <template #body="{ data }">
                        <div>
                            <small>
                                <img style="width: 35px;" class="img-thumbnail rounded-circle" :src="`/img/users_avatars/${data.avatar}`" alt="">
                            </small>
                        </div>
                    </template>
                </Column>
                <Column>
                    <template #header>
                        <div>
                            <small class="task-description">Nome</small>
                        </div>
                    </template>
                    <template #body="{ data }">
                        <div>
                            <p class="small-fw">{{ data.name }}</p>
                        </div>
                    </template>
                </Column>
                <Column>
                    <template #header>
                        <div>
                            <small class="task-description">Team</small>
                        </div>
                    </template>
                    <template #body="{ data }">
                        <div>
                            <p class="small-fw">{{ data.team_name }}</p>
                        </div>
                    </template>
                </Column>
                <Column>
                    <template #header>
                        <div>
                            <small class="task-description">Actions</small>
                        </div>
                    </template>
                    <template #body="{ data }">
                        <div class="d-flex gap-1">
                            <Button text class="p-0 task-description">
                                <small><i class="pi pi-pencil small-fw"></i></small>
                            </Button>
                            <Button text class="p-0 task-description">
                                <small><i class="pi pi-arrow-right-arrow-left small-fw"></i></small>
                            </Button>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>
<script>
export default {
    name: 'UsersListComponent',

    props: {

    },
    data(){
        return {
            users: []
        }
    },
    mounted(){
        this.listAllUsers();
    },
    methods: {
        listAllUsers(){
            this.Api.get('users')
            .then(async response => {
                this.users = await response.data;
            })
        }
    }
}

</script>
