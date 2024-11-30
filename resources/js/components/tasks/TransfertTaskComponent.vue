<template>
    <div class="card">
        {{ tasksIds }}
    </div>
</template>
<script>
export default {
    name: 'TransfertTaskComponent',

    props:{
        tasksIds: Object
    }
}
</script>
