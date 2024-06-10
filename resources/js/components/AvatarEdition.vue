<template>
    <Button @click="visibleAvatarEditionModal = !visibleAvatarEditionModal" text label="Editar avatar do perfil" />
    <Dialog v-model:visible="visibleAvatarEditionModal" modal header="Edit your avatar" :style="{ width: '55rem' }">
        <div class="row">
            <div class="col-md-10 m-auto d-flex flex-wrap gap-3">
                <Button text v-for="avatar of avatars">
                    <img @click="setAvatarFileURL(file = `/img/avatars/${avatar.avatar}`)" style="width: 70px;" class="img-thumbnail rounded-circle" :src="`/img/avatars/${avatar.avatar}`" alt="">
                </Button>
            </div>
            <input type="file" class="form-control" id="avatar-input" />
            <Button label="Salvar" @click="setAvatarFileURL" />
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
                {avatar: 'black-woman.jpeg'}
            ]
        }
    },
    methods: {
        loadAvatarAsFile(path){
            return new Promise((resolve, reject) => {
                let ph = path;
                axios.get(path)
                    .then(res => {
                        if (res.status === 200) {
                            const avatarInput = document.querySelector('#avatar-input');
                            const blob = res.data;
                            const fileName = ph.split('/').pop()
                            const file = new File([blob], fileName, {type: blob.type})
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            avatarInput.files = dataTransfer.files;
                            console.log(avatarInput)
                            resolve(file);
                        }
                    });
            });
        },

        setAvatarFileURL(file) {
            this.loadAvatarAsFile(file)
                .then(res => {
                    console.log(res);
                })
        }
    }
}
</script>
