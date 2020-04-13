<template>
    <div class="row">
        <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1">
            <AccountToolbarLeft></AccountToolbarLeft>
        </div>

        <div class="col-sm-10 col-md-9 col-lg-8 col-xl-8 pl-0 --bg-danger">

            <div class="container">
                <ProfileHeader v-if="isDataReady" v-bind:user-data="profileData"></ProfileHeader>
                <Spinner v-else></Spinner>
            </div>

            <NewPersonalMessageModal v-if="isShowMessageDialog" v-bind:user="profileData"></NewPersonalMessageModal>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pr-0">
            <FavoritFriends></FavoritFriends>
            <ShortFriends v-bind:user="{}"></ShortFriends>
        </div>
    </div>
</template>

<script>
import AccountToolbarLeft from '../common/AccountToolbarLeft.vue';
import FavoritFriends from '../common/FavoritFriends.vue';
import ShortFriends from '../common/ShortFriends.vue';
import Spinner from '../common/Spinner.vue';

import ProfileHeader from '../components/ProfileHeader.vue';
import NewPersonalMessageModal from '../components/NewPersonalMessageModal.vue';

import PliziUser from '../classes/PliziUser.js';

export default {
name: 'PersonalPage',
props: {
    id : Number|String
},

components: {
    Spinner,
    AccountToolbarLeft, FavoritFriends, ShortFriends,
    ProfileHeader, NewPersonalMessageModal
},

data() {
    return {
        profileData: {},
        isDataReady: false,
        isShowMessageDialog: false,

    }
},

methods: {
    async getUserInfo() {
        let profile = null;

        try {
            profile = await this.$root.$api.infoUser(this.id >>> 0);
        }
        catch (e){
            if (e.status  &&  e.status===401) {
                this.$root.$emit('afterSuccessLogout', {});
            }
            else {
                throw e;
            }
        }

        if (profile) {
            //window.console.info( JSON.parse( JSON.stringify(profile) ), `profile` );

            this.profileData = new PliziUser();
            this.profileData.saveUserData(profile);
            this.isDataReady = true;
        }
    }
},

mounted() {
    this.getUserInfo();

    this.$root.$on('hidePersonalMsgModal', ()=>{
        this.isShowMessageDialog = false;
    });

    this.$root.$on('showPersonalMsgModal', ()=>{
        this.isShowMessageDialog = true;
    });
}

}
</script>
