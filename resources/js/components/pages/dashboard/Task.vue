<template>
    <SidebarComponent>
        <div class="row m-auto min-vh-100 position-relative">
            <div class="w-100">
                <div class="col-md-10">
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
                                <ShowTaskComponent />
                                <Button text icon="pi pi-play" />
                                <ShowTaskAnnexComponent />
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
                                                <div class="comment d-flex flex-column gap-0">
                                                    <span>
                                                        <p style="font-size: 0.9rem;" class="">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                            tempor incididunt ut labore et dolore magna aliqua<br>
                                                            <Button @click="showCommentResponseInput = !showCommentResponseInput" style="font-size: 0.8rem;" class="p-0" text label="Responder..." />
                                                        </p>
                                                        <span v-if="showCommentResponseInput" class="d-flex mb-1">
                                                            <input style="font-size: 0.8rem;" class="form-control p-1 text-secondary" type="text" placeholder="your response....">
                                                            <Button class="p-0" text icon="pi pi-send" />
                                                        </span>
                                                        <span class="comment-response-content">
                                                            <div class="card w-75 m-auto border-0 mt-1">
                                                                <div class="card-header bg-white border-0 p-0 border-0 d-flex align-items-center gap-2">
                                                                    <small>
                                                                        <img style="width: 35px;" class="img-thumbnail rounded-circle" src="/img/avatars/white-woman.jpeg" alt="">
                                                                    </small>
                                                                    <small style="font-size: 12px;" class="fw-bold">Andressa Lacerda</small>
                                                                </div>
                                                                <div class="card-body p-0 px-2">
                                                                    <p style="font-size: 0.9rem;" class="text-rigth">
                                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="p-text-secondary block mb-5">Seu comentario</span>
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
    </SidebarComponent>
</template>
<script>
import ShowTaskAnnexComponent from './../../ShowTaskAnnexComponent.vue';
import ShowTaskComponent from './../../ShowTaskComponent.vue';
export default {
    name: 'Task',

    components: {
        ShowTaskAnnexComponent,
        ShowTaskComponent
    },
    data(){
        return {
            visible: false,
            showCommentResponseInput: false
        }
    },
    methods:{

    }
}
</script>
