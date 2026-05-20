import { defineStore } from 'pinia';

export const useMessageStore = defineStore('message', {
  state: () => ({
    message: '',
  }),
  actions: {
    setMessage(newMessage) {
      this.message = newMessage;
    },
    clearMessage() {
      this.message = '';
    },
  }
});
