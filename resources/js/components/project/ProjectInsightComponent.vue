<template>
    <div class="col-md-12">
        <h1>Insight by project</h1>
        <Knob v-model="value" valueColor="#34d399" :strokeWidth="5"/>
    </div>
</template>
<script>
export default {
    name: 'ProjectInsightComponent',

    data(){
        return {
            value: 30
        }
    }
}
</script>
