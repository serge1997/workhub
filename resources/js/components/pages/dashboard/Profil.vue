<template>
    <SidebarComponent>
        <div class="row">
            <div class="col-md-10">
                <h1 class="text-center fw-light">User profil</h1>
                <div class="w-100 profil-navbar d-flex justify-content-center border-bottom shadow-sm m-auto">
                    <AvatarEdition />
                    <Button text label="Editar informações" />
                </div>
            </div>
        </div>
    </SidebarComponent>
</template>
<script>
import AvatarEdition from '../../AvatarEdition.vue';
export default {
    name: 'Profil',

    components: {
        AvatarEdition
    }
}
</script>
