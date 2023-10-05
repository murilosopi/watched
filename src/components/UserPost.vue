<template>
    <DarkBox class="d-flex row px-md-5 px-3 py-5">
    <article class="userpost">
        <div id="header" class="row align-items-center mb-2">
            <figure class="col-1 p-0 mb-0">
                <img
                class="user-photo w-100"
                src="/assets/img/users/default.svg"
                :alt="`Foto de perfil de @${userpost.user}`"
                />
            </figure>
            <div class="col">
                <router-link
                    :to="`/usuario/${userpost.user}`"
                    class="text-white fw-bold"
                    >
                    <Title tag="h4">@{{ userpost.user }}</Title>
                </router-link>
            </div>
            <div class="col d-flex">
                <InteractiveIcon title="Denunciar">
                    <i class="bi bi-flag text-danger fs-6"
                    @click="reportPost"></i>
                </InteractiveIcon>
            </div>
        </div>
        <div id="content" class="col-11 ms-auto">
            <p class="fs-6 mb-0 pre post-text">
            {{ userpost.text }}
            </p>
        </div>
        <div id="footer" class="d-flex mt-2">
            <InteractiveIcon class="column" title="Upvote">
                <i class="bi bi-chevron-compact-up text-primary fs-6"
                @click="addUpvote"></i>
                <p class="ms-auto small text-white">{{ counterUp }}</p>
            </InteractiveIcon>
            <InteractiveIcon class="column" title="Downvote">
                <i class="bi bi-chevron-compact-down text-danger fs-6"
                @click="addDownvote"></i>
                <p class="ms-auto small text-white">{{ counterDown }}</p>
            </InteractiveIcon>
            <InteractiveIcon class="column" title="DoComment">
                <i class="bi bi-chat text-white fs-6"></i>
                <p class="ms-auto small text-white">{{ counterComment }}</p>
            </InteractiveIcon>
        </div>
    </article>
    </DarkBox>
</template>
<script>
import Title from "./Title.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
import DarkBox from "./DarkBox.vue";
import AuthMixin from "@/mixins/AuthMixin";
import NotificationMixin from "@/mixins/NotificationMixin";

const counterUp = ref(this.post.upvotes);
const counterDown = ref(this.post.downvotes);
const counterComment = ref(this.post.comments);

export default{
    mixins:[AuthMixin, NotificationMixin],
    data(){
        return{
        upvotes: this.post.upvotes,
        downvotes: this.post.downvotes,
        comments: this.post.comments,
        };
    },
    components:{
    Title,
    InteractiveIcon,
    DarkBox
},
    props:{
        userpost: Object,
        counterUp: Number,
        counterDown: Number,
        counterComment: Number,
    },
    methods:{
        reportPost(){
            if(this.userLogged){
            }
            else{
                this.notifyUser({
                icon: 'x-circle',
                title: 'Ops!',
                text: "Você não está logado...",
                class: 'danger'
              })
            }
        },
        addUpvote: function(){
            if(this.userLogged){
                this.post.upvotes++
            }
            else{
                this.notifyUser({
                icon: 'x-circle',
                title: 'Ops!',
                text: "Você não está logado...",
                class: 'danger'
              })
            }
        },
        addDownvote: function(){
            if(this.userLogged){
                this.post.downvotes++
            }
            else{
                this.notifyUser({
                icon: 'x-circle',
                title: 'Ops!',
                text: "Você não está logado...",
                class: 'danger'
              })
            }
        },
    }
}
</script>
<style scoped>
#footer {
    flex-direction: row;
    align-self: flex-end;
}
</style>