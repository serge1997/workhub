<template>
    <SidebarComponent>
        <div class="row m-auto position-relative overflow-scroll">
            <div class="col-md-10">
                <h1 class="fw-light text-center p-2">Task reception</h1>
                <div v-for="task in tasks" class="card rounded-5 w-100 mb-3">
                    <div class="card-body d-flex justify-content-between p-2">
                        <div class="row w-100 m-auto">
                            <div class="col-md-3 d-flex align-items-center gap-2">
                                <i class="pi pi-bookmark-fill text-success"></i>
                                <h6>Tarefas</h6>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <small class="fw-medium text-decoration-underline task-description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                </small>
                            </div>
                            <div class="col-md-2 d-flex align-items-center gap-2 d-flex justify-content-end fw-light">
                                <small class="fw-medium task-description">
                                    20:30 AM
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SidebarComponent>
</template>
<script>
export default{
    name: 'TaskReception',

    data(){
        return {
            tasks: null
        }
    },
    methods:{
        onListTaskByUser(){
            this.Api.get('task-by-user')
            .then(async response => {
                this.tasks = await response.data;
                console.log(response)
            })
            .catch(err => {
                console.log(err)
            })
        },
    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
        this.onListTaskByUser();
    }
}
</script>
