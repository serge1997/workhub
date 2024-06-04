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
                        <Button @click="visible = true" text icon="pi pi-comment" />
                        <Button text icon="pi pi-eye" />
                        <Button text icon="pi pi-play" />
                        <Dialog v-model:visible="visible" modal header="Task comment" :style="{ width: '25rem' }">
                            <div class="w-100 comment-list mb-3">
                                <div class="card border-0 comment-card">
                                    <div class="card-header bg-white border-0 p-0 border-0 d-flex align-items-center gap-2">
                                        <small>
                                            <img style="width: 35px;" class="img-thumbnail rounded-circle" src="/img/avatars/hair0.jpeg" alt="">
                                        </small>
                                        <small style="font-size: 12px;" class="fw-bold">Serge Gogo</small>
                                    </div>
                                    <div class="card-body p-0 px-2">
                                        <span>
                                            <p style="font-size: 0.9rem;" class="">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua
                                            </p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="p-text-secondary block mb-5">Seu commentario</span>
                            <div class="w-100 d-flex">
                                <IconField iconPosition="left" class="p-0">
                                    <InputIcon class="pi pi-comment"> </InputIcon>
                                    <InputText v-model="value1" placeholder="comment..." />
                                </IconField>
                                <Button text icon="pi pi-send" />
                            </div>
                        </Dialog>
                    </div>
                    <div class="w-100 d-flex justify-content-end gap-0">
                        <img class="img-thumbnail rounded-circle w-50" src="/img/avatars/hair0.jpeg" alt="">
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

    },
    data(){
        return {
            visible: false
        }
    },
    methods:{

    }
}
</script>
