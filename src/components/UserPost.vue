<template>
    <DarkBox class="px-4 py-3">
        <article class="userpost">
            <div class="row align-items-center mb-2">
                <UserAvatar :username="userpost.user" class="col-1 d-none d-sm-block p-0 mb-0"/>
                <div class="col">
                    <router-link :to="`/usuario/${userpost.user}`" class="text-white fw-bold">
                        <Title tag="h4">@{{ userpost.user }}</Title>
                    </router-link>
                </div>
                <div class="col d-flex justify-content-end">
                    <InteractiveIcon title="Denunciar">
                        <i class="bi bi-flag text-danger fs-6" @click="reportPost"></i>
                    </InteractiveIcon>
                </div>
            </div>
            <div class="text-wrap text-break row">
                <p class="col-sm-11 ms-auto fs-6 mb-0 pre userpost-text">
                    {{ userpost.text }}
                </p>
            </div>
            <div class="row mt-2">
                <div class="col column-gap-3 d-flex justify-content-end">
                    <InteractiveIcon title="Upvote">
                        <i class="bi bi-chevron-compact-up text-primary fs-4" @click="addUpvote"></i>
                        <p class="text-center small text-white">{{ counterUp }}</p>
                    </InteractiveIcon>
                    <InteractiveIcon title="Downvote">
                        <i class="bi bi-chevron-compact-down text-danger fs-4" @click="addDownvote"></i>
                        <p class="text-center small text-white">{{ counterDown }}</p>
                    </InteractiveIcon>
                    <InteractiveIcon title="DoComment">
                        <i class="bi bi-chat text-white fs-5"></i>
                        <p class="text-center small text-white">{{ counterComment }}</p>
                    </InteractiveIcon>
                </div>
            </div>
        </article>
    </DarkBox>
</template>
<script>
import Title from "./Title.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
import DarkBox from "./DarkBox.vue";
import UserAvatar from "./UserAvatar.vue";

export default {

    data() {
        return {
            counterUp: 0,
            counterDown: 0,
            counterComment: 0,
        };
    },
    components: {
        Title,
        InteractiveIcon,
        DarkBox,
        UserAvatar
    },
    props: {
        userpost: Object,
    },
    methods: {
        reportPost() {
        },
        addUpvote() {
        },
        addDownvote() {
        },
    }
}
</script>
<style scoped>
</style>