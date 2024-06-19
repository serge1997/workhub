<template>
    <SidebarComponent>
        <div class="row">
            <div class="col-md-100 mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-transparent">
                                <Tag value="Fila Tarefa" severity="warning" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-transparent">
                                <Tag value="In Progress" severity="primary" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-transparent">
                                <Tag value="Concluido" severity="success" />
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
    name: 'Sprint',

    components: {

    },
    data(){
        return{
            task: {
                progress: null,
                waiting: null,
                concluded: null,
            }
        }
    },
    methods: {

    },
    mounted(){

    }
}

</script>
