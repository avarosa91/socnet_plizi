<template>
    <div class="modal" id="chatVideoModal" tabindex="-1" role="dialog" aria-labelledby="chatVideoModal"
         aria-hidden="true" style="display: block; background-color: rgba(0, 0, 0, .7);"
         @click.stop="hideChatVideoModal">

        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" @click.stop="">
            <div class="modal-content bg-white-br20">
                <VideoPlayer :videoLink="videoLink"/>
            </div>
        </div>
    </div>
</template>

<script>
import VideoPlayer from '../../common/VideoPlayer.vue';

export default {
name: 'ChatVideoModal',
props: {
    videoLink: {
        type: String,
        default: null,
    },
},
components: {
    VideoPlayer,
},
methods: {
    hideChatVideoModal() {
        this.$emit('HideChatVideoModal', {});
    },
},
}
</script>

<style scoped>

</style>
