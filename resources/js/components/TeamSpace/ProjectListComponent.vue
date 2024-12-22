<template>
    <div class="container-fluid">
        <div class="row">
            <div v-for="project in projects" class="col-md-12 p-1">
                <div class="col-md-10 d-flex align-items-center gap-2">
                    <Button text class="task-description" icon="pi pi-play" />
                    <Tag :style="`background-color: #${project?.severity};`" :value="project.name" />
                    <Badge severity="secondary" :value="project.tasks_count"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProjectListComponent',

    props: {
        projects: Object
    },
    data(){
        return {

        }
    },
    mounted(){

    },
    methods:{

    }
}
</script>
