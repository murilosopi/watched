<template>
  <ul class="list-unstyled m-0">
    <li
      class="rounded chat-message"
      v-for="msg in messages"
      :key="msg.id"
      :class="{
        right: msg.from == loggedData.id,
        left: msg.from != loggedData.id,
      }"
    >
      <template v-for="(text, idx) in msg.paragraphs">
        <p
          class="text-break text"
          v-if="text"
          
          :key="`${msg.id}${idx}`"
        >
          {{ text }}
        </p>
        <br v-else :key="`_${msg.id}${idx}`">
      </template>

      <small class="date text-white-50">{{ msg.time }}</small>
    </li>
  </ul>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
  computed: mapGetters('chat', ['messages'])
};
</script>

<style>
.chat-message {
  background-color: rgb(33, 33, 33);
  width: fit-content;
  max-width: 70%;
  padding: 0.45rem 1.5em;
  margin-bottom: 12px;
  position: relative;
}

.chat-message.left {
  margin-right: auto;
}

.chat-message.right + .chat-message.left,
.chat-message.left + .chat-message.right {
  margin-top: 1.3rem;
}

.chat-message.right {
  margin-left: auto;
}

.chat-message .text {
  font-size: 0.9em;
  margin-bottom: 0.075rem;
}

.chat-message .text:last-child {
  margin-bottom: 0 !important;
}

.chat-message .date {
  position: absolute;
  visibility: hidden;
  width: max-content;
  opacity: 0;
  transition: .2s opacity ease-in-out;
  bottom: 0.25rem;
}

.chat-message.left .date {
  left: 105%;
}

.chat-message.right .date {
  right: 105%;
}


.chat-message:hover  .date {
  visibility: visible;
  opacity: 1;
}
</style>
