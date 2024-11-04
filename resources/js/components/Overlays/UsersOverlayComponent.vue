<template>
    <Tag @click="toggleUserOverlayPanel" class="cursor-p" :value="`membros(${ project.members_count})`" icon="pi pi-users" />
    <OverlayPanel ref="visibleOverlayPanel" style="width: 300px;">
        <ul class="list-group">
            <li v-for="member in members" class="list-group-item border-0 d-flex gap-1 cursor-p">
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
        project: Object
    },
    data(){
        return {
            visibleOverlayPanel: ref(null),
            members: null
        }
    },
    methods:{
        toggleUserOverlayPanel(event){
            this.visibleOverlayPanel.toggle(event);
            this.listProjectMembers()
        },
        listProjectMembers(){
            this.Api.get('user/list-by-poject/' + this.project.id)
            .then(async response => {
                this.members = await response.data.data;
            })
        }
    },
    mounted(){
        this.visibleOverlayPanel = this.$refs.visibleOverlayPanel;
    }
}
</script>
