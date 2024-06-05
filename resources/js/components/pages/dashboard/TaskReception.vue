<template>
    <SidebarComponent>
        <div class="row m-auto position-relative overflow-scroll">
            <div class="col-md-10 m-auto">
                <h1 class="fw-light text-center p-2">Task reception</h1>
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <div class="row w-100 m-auto">
                            <div class="col-md-3 d-flex align-items-center gap-2">
                                <i class="pi pi-bookmark-fill text-success"></i>
                                <h6>Tarefas</h6>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <small class="fw-medium text-decoration-underline">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                </small>
                            </div>
                            <div class="col-md-2 d-flex align-items-center gap-2 d-flex justify-content-end fw-light">
                                <small class="fw-medium">
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
}
</script>
