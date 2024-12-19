<template>
    <div class="container-fluid p-0 mb-4">
        <Toolbar class="p-0 border-0 bg-transparent border-bottom">
            <template #start>
                <div class="d-flex gap-2 w-100">
                    <Button class="task-description btn-text-nowrap  d-flex gap-1" label="Projeto" text>
                        <span class="d-flex align-items-center">
                            <i class="pi pi-users small-icon"></i>
                        </span>
                        <span class="small-fw"><small>Teams</small></span>
                    </Button>
                    <Button class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
                        <span class="d-flex align-items-center">
                            <i class="pi pi-tags small-icon"></i>
                        </span>
                        <span class="small-fw"><small>Sprints</small></span>
                    </Button>
                    <Button class="task-description d-flex gap-1 btn-text-nowrap" label="Projeto" text>
                        <span class="d-flex align-items-center">
                            <i class="pi pi-tags small-icon"></i>
                        </span>
                        <span class="small-fw"><small>Projetos</small></span>
                    </Button>
                    <Button class="task-description d-flex gap-1 btn-text-nowrap " label="Projeto" text>
                        <span class="d-flex align-items-center">
                            <i class="pi pi-cog small-icon"></i>
                        </span>
                        <span class="small-fw"><small>Configurações</small></span>
                    </Button>
                </div>
            </template>
        </Toolbar>
    </div>
</template>
<script>
export default {
    name: 'SubNavbarComponent',

    data(){
        return{

        }
    },
    methods: {

    }
}
</script>
