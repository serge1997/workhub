<template>
    <Button @click="visibleAvatarEditionModal = !visibleAvatarEditionModal" text label="Editar avatar do perfil" />
    <Dialog v-model:visible="visibleAvatarEditionModal" modal header="Choose your avatar" :style="{ width: '55rem' }">
        <div class="row">
            <div class="col-md-10 m-auto d-flex flex-wrap gap-3">
                <Button text v-for="avatar of avatars">
                    <img @click="loadAvatarAsFile(file = `/img/avatars/${avatar.avatar}`)" style="width: 70px;" class="img-thumbnail rounded-circle" :src="`/img/avatars/${avatar.avatar}`" alt="">
                </Button>
            </div>
            <input type="file" class="form-control d-none" id="avatar-input"/>
        </div>
    </Dialog>
</template>
<script>
export default{
    name: 'AvatarEdition',

    data(){
        return {
            visibleAvatarEditionModal: false,
            avatars: [
                {avatar: 'hair0.jpeg'},
                {avatar: 'white-woman.jpeg'},
                {avatar: 'black-woman.jpeg'},
            ],
            user_avatar: {
                    avatar: null,
                }
        }
    },
    methods: {
        loadAvatarAsFile(path){
            return new Promise((resolve, reject) => {
                let ph = path;
                axios.get(path, { responseType: 'blob' })
                    .then(response => {
                        if (response.status === 200) {
                            const blob = response.data;
                            const extension = ph.split('.').pop();
                            const fileName = ph.split('/').pop()
                            const mimeType = extension == 'bin' ? 'application/octet-stream' : `image/${extension}`;
                            const file = new File([blob], fileName, {type: mimeType})
                            const avatarInput = document.querySelector('#avatar-input');
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            avatarInput.files = dataTransfer.files;
                            this.handleFileChange();
                            resolve(true);
                        }
                    });
            });
        },
        handleFileChange(){
            const avatarInput = document.querySelector('#avatar-input');
            const event = new Event('change', { bubbles: true });
            avatarInput.addEventListener('change', (event) => {
                const avatarFormData = new FormData();
                avatarFormData.append('avatar', event.target.files[0]);
                this.createAvatar(avatarFormData);
            }, { once: true });
            avatarInput.dispatchEvent(event);
        },
        createAvatar(avartFileData){
            this.$swal.fire({
                text: "está sendo trocando a seu avatar. clique em ok para confirmar.",
                confirmButtonColor: "#38bdf8",
                confirmButtonText: "Confirmar",
                icon: 'warning',
                showCancelButton: true
            })
            .then(result => {
                if (result.isConfirmed){
                    this.Api.post('user-avatar', avartFileData)
                        .then(async response => {
                            this.toaster(response.data).fire();
                            this.visibleAvatarEditionModal = false;
                        })
                }
            })
        },
        toaster(response){
            const Toast = this.$swal.mixin({
                text: response,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                icon: "success",
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            return Toast
        },
    },
    mounted(){

    }
}
</script>
