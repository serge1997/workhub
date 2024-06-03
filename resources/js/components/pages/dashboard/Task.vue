<template>
    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">
        <SidebarComponent />
        <div class="col-md-8 border">
            <h3 class="text-center fw-light">List of tasks</h3>
            <div class="row p-3">
            <div class="col-md-4 card">
                <div class="card-header border-0 bg-white p-1">
                    <small>Task short title</small>
                </div>
                <div class="card-body border-0 p-1">
                    <small>user pics, icons</small>
                </div>
                <div class="card-footer d-flex justify-content-between border-0 bg-white p-1">
                    <div class="w-100 d-flex gap-0">
                        <Button class="text-warning fw-bold" text icon="pi pi-hourglass" />
                    </div>
                    <div class="w-100 d-flex justify-content-end gap-0">
                        <Button text icon="pi pi-comment" />
                        <Button text icon="pi pi-play" />
                    </div>
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
