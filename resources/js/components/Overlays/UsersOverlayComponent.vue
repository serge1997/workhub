<template>
    <Tag v-if="!isShowComponent && project" @click="toggleUserOverlayPanel" class="cursor-p btn-text-nowrap" :value="tagLabel()" icon="pi pi-users" />
    <Tag v-if="isShowComponent && user" @click="toggleUserOverlayPanel" class="cursor-p btn-text-nowrap">
        <img class="img-thumbnail rounded-circle" style="width: 28px;" :src="`/img/users_avatars/${user.avatar}`" alt="">
        {{ user.name }}
    </Tag>
    <div v-if="!user && isForAddUser" class="d-flex align-items-center">
        <Tag @click="toggleUserOverlayPanel" class="cursor-p task-description bg-transparent">
            <i class="pi pi-user-plus"></i>
        </Tag>
    </div>
    <OverlayPanel ref="visibleOverlayPanel" style="width: 310px;">
        <div class="w-100 p-2 d-flex">
            <IconField iconPosition="left">
                <InputIcon class="pi pi-search"> </InputIcon>
                <InputText @input="searchUserByName" v-model="search" placeholder="pesquisa..." />
            </IconField>
        </div>
        <ul class="list-group">
            <li v-for="member in members" @click="$emit('updateTaskUser', member.id)" class="list-group-item border-0 d-flex gap-1 cursor-p">
                <span style="width: 18%;">
                    <img class="img-thumbnail rounded-circle" style="width: 75%;" :src="`/img/users_avatars/${member.avatar}`" alt="">
                </span>
                <span>{{ member.name }}</span>
            </li>
        </ul>
    </OverlayPanel>
</template>
<script>
import { ref } from 'vue';
export default {
    name: 'UsersOverlayComponent',

    props: {
        project: Object,
        user: String,
        isShowComponent: Boolean,
        isForAddUser: Boolean
    },
    watch: {

    },
    data(){
        return {
            visibleOverlayPanel: ref(null),
            members: null,
            search: null
        }
    },
    methods:{
        toggleUserOverlayPanel(event){
            this.listUsers()
            this.visibleOverlayPanel.toggle(event);
        },
        listUsers(){
            let url = this.isShowComponent ? 'users' : 'user/list-by-poject/' + this.project.id;
            this.Api.get(url)
            .then(async response => {
                this.members = this.project ? await response.data.data : await response.data;
            })
        },
        tagLabel(){
            return this.user ? this.user.name : `membros(${ this.project.members_count})`
        },
        searchUserByName(){
            this.Api.get('user-search', {user_name: this.search})
            .then(async response => {
                this.members = await response.data;
            })
        }
    },
    mounted(){
        this.visibleOverlayPanel = this.$refs.visibleOverlayPanel;
    }
}
</script>
