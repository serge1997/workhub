<template>
    <SidebarComponent>
        <div class="row">
            <div class="col-md-10 mt-3 m-auto p-0">
                <div class="row w-100 p-0 m-auto">
                    <Toolbar class="p-0">
                        <template #start>
                            <div class="w-100 d-flex">
                                <Button @click="componentIs = 'CardTaskComponent'" icon="pi pi-th-large" text/>
                                <Button @click="componentIs = 'ListTaskComponent'" icon="pi pi-list" text />
                            </div>
                        </template>
                    </Toolbar>
                </div>
                <div class="row mt-3">
                    <div style="height: 600px; overflow: scroll;" class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-white">
                                <Tag class="w-100" value="Fila Tarefa" severity="warning" />
                            </div>
                            <div class="card-body mt-4">
                                <keep-alive>
                                    <component show-status="WAT" :is="componentIs"></component>
                                </keep-alive>
                            </div>
                        </div>
                    </div>
                    <div style="height: 600px; overflow: scroll;" class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-transparent">
                                <Tag class="w-100" value="In Progress" severity="primary" />
                            </div>
                            <div class="card-body mt-4">
                                <keep-alive>
                                    <component show-status="PRO" :is="componentIs"></component>
                                </keep-alive>
                            </div>
                        </div>
                    </div>
                    <div style="height: 600px; overflow: scroll;" class="col-md-4">
                        <div class="card w-100">
                            <div class="card-header border-0 bg-transparent">
                                <Tag class="w-100" value="Concluido" severity="success" />
                            </div>
                            <div class="card-body mt-4">
                                <keep-alive>
                                    <component show-status="CON" :is="componentIs"></component>
                                </keep-alive>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SidebarComponent>
</template>
<script>
import ListTaskComponent from './../../tasks/ListTaskComponent.vue';
import CardTaskComponent from './../../tasks/CardTaskComponent.vue';
export default{
    name: 'Sprint',

    components: {
        ListTaskComponent,
        CardTaskComponent
    },
    data(){
        return{
            task: {
                progress: null,
                waiting: null,
                concluded: null,
            },
            componentIs: 'ListTaskComponent',
        }
    },
    methods: {

    },
    mounted(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
    }
}

</script>
