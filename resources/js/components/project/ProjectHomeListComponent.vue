<template>
    <div class="card border-0">
        <router-link class="card-body d-flex align-items-center justify-content-between nav-link text-dark">
             <div class="icon d-flex gap-1 align-items-center">
                <img style="width: 43px;" class="rounded-circle shadow-sm" src="/img/project-image.png" />
                <h6 class="mt-1">workhub</h6>
             </div>
             <div class="meta-data d-flex gap-2 align-items-center text-secondary">
                <h6>Tarefa(4)</h6>
                <h6>Membros(2)</h6>
             </div>
        </router-link>
    </div>
</template>
<script>
export default {
    name: 'ProjectHomeListComponent',

    data(){
        return {

        }
    }
}
</script>
