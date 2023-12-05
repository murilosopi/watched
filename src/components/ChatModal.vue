<template>
  <Dialog
    data-bs-focus="false"
    id="modal-chat"
    size="lg"
    :scroll="true"
    :customHeader="true"
    :fullHeight="true"
  >
    <template v-if="hasChat">
      <template slot="header">
        <InteractiveIcon class="me-1" @click.native="removeActiveChat">
          <i class="bi bi-chevron-left fs-5"></i>
        </InteractiveIcon>
        <h1 class="modal-title fs-5">{{ titleChat }}</h1>
        <InteractiveIcon class="ms-auto me-1" @click.native="report">
          <i class="bi bi-flag text-danger fs-5"></i>
        </InteractiveIcon>
        <InteractiveIcon data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg text-danger fs-5"></i>
        </InteractiveIcon>
      </template>

      <ChatForm
        :to="chatId"
        slot="footer"
        @newMessage="
          (msg) => {
            sendMessage(msg);
            $forceUpdate();
          }
        "
      />

      <div slot="content" class="row align-items-strech">
        <div class="col d-flex flex-column" v-if="hasChat">
          <ChatMessages />
        </div>
      </div>
    </template>

    <template v-else>
      <template slot="header">
        <Title tag="h2">Bate-Papo</Title>
        <InteractiveIcon data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg fs-5"></i>
        </InteractiveIcon>
      </template>

      <div slot="content" class="row align-items-strech h-100">
        <div class="col-lg-6" v-if="recentChats.length">
          <Title tag="h3" class="opacity-50 fs-4 mb-2">Recentes</Title>
          <ListGroup class="mb-4">
            <TransitionGroup
              leave-active-class="animate__animated animate__fadeIn animate__faster"
            >
              <ListGroupItem
                v-for="chat in recentChats"
                :key="chat.id"
                @click.native="setActiveChat(chat)"
              >
                <div class="chat-item-icon me-2">
                  <UserAvatar :username="chat.participants[0].username" />
                </div>
                <Title tag="span">{{
                  chat.participants.map((p) => p.username).join(", ")
                }}</Title>
              </ListGroupItem>
            </TransitionGroup>
          </ListGroup>
        </div>
        <div class="col-lg-6" v-if="followingChats.length">
          <Title tag="h3" class="opacity-50 fs-4 mb-2">Sua Rede</Title>
          <ListGroup class="mb-4">
            <ListGroupItem
              v-for="(chat, idx) in followingChats"
              :key="chat.participants[0].username"
              @click.native="newChatHandler(chat, idx)"
            >
              <div class="chat-item-icon me-2">
                <UserAvatar :username="chat.participants[0].username" />
              </div>
              <Title tag="span">{{
                chat.participants.map((p) => p.username).join(", ")
              }}</Title>
            </ListGroupItem>
          </ListGroup>
        </div>
      </div>
    </template>
  </Dialog>
</template>

<script>
import ChatMixin from "@/mixins/ChatMixin";
import ChatForm from "./ChatForm.vue";
import ChatMessages from "./ChatMessages.vue";
import Dialog from "./Dialog.vue";
import InteractiveIcon from "./InteractiveIcon.vue";
import ListGroup from "./ListGroup.vue";
import ListGroupItem from "./ListGroupItem.vue";
import Title from "./Title.vue";
import UserAvatar from "./UserAvatar.vue";
import Swal from 'sweetalert2';

export default {
  components: {
    Dialog,
    ChatMessages,
    UserAvatar,
    Title,
    ChatForm,
    InteractiveIcon,
    ListGroupItem,
    ListGroup,
  },
  mixins: [ChatMixin],
  data() {
    return {
      modal: null,
      dialogBody: null,
      c: 0
    };
  },

  methods: {
    async newChatHandler(chat, originPosition) {
      this.newChat(chat).then(res => {

        if(res) {
          this.followingChats.splice(originPosition, 1);
  
          this.setActiveChat(chat)
        } else {
          throw(res);
        }
      }).catch(() => {
        Swal.fire('Ops', 'Não é possível participar desse bate-papo no momento...', 'warning')
      })
    },

    async report() {
      let { value } = await Swal.fire({
        input: "textarea",
        title: "Denunciar",
        inputPlaceholder: "Descreva o motivo da sua denúncia...",
        inputAttributes: {
          "aria-label": "Descreva o motivo da sua denúncia"
        },
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar',
        inputValidator(value) {
          if(value.length < 15) {
            return 'A sua denúncia deve conter, no mínimo, 15 caracteres.'
          }
        }
      });

      if(value) Swal.fire('Denúncia Registrada', 'Sua denúncia foi registrada e logo será analisada pela nossa equipe.', 'info')
    }
  },

  updated() {
    this.dialogBody.scrollTop = this.dialogBody.scrollHeight;
  },

  mounted() {
    this.dialogBody = this.$el.querySelector(".modal-body");

    this.modal = this.$el;

    this.modal.addEventListener('show.bs.modal', () => {
      this.getFollowingChats();
    });
  },
};
</script>

<style scoped>
.chat-item-icon {
  width: calc(2vw + 40px);
}
</style>
