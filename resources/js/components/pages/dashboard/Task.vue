<template>
    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">
        <SidebarComponent />
        <div class="col-md-8 border">
            <h3 class="text-center fw-light">List of tasks</h3>
            <div class="row p-3">
            <div class="col-md-4 card">
                <div class="card-header border-0 bg-white p-1">
                <small>short task description</small>
                </div>
                <div class="card-body border-0">
                <small>user pics, icons</small>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Task',

    components: {

    }
}
</script>
