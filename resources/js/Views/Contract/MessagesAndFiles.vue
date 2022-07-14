<template>
  <div class="flex">
    <div class="flex-1 border-r border-gray-200">
      <div class="max-h-[550px] overflow-y-auto divide-y space-y-5">
        <template v-if="messages.length">
          <div class="text-sm flex justify-between items-center gap-10 py-4 pr-4" v-for="(message, index) in messages" :key="index">
            <div>
              <h4 class="font-semibold mb-2">{{ message.user.name }}</h4>
              <div class="text-gray-600" v-html="message.comment"></div>
            </div>
            <span>{{ message.created_at }}</span>
          </div>
        </template>
        <template v-else>
          <p class="text-center py-8">There is no message yet</p>
        </template>
      </div>
      <div class="mt-5 flex gap-4 bg-gray-100 p-4">
        <button>
          <svg-vue icon="link" class="w-5 h-5" />
        </button>
        <input type="text" class="bg-white border border-gray-200 p-2 grow" v-model="comment" />
        <button @click="sendMessage" :disabled="$v.comment.$invalid || sending" class="rounded-lg px-12 py-2 bg-blue-500 text-white">
          {{ sending ? 'sending...' : 'Send' }}
        </button>
      </div>
    </div>
    <div class="w-[250px]">
      <h2 class="text-xl font-semibold border-b border-gray-200 px-4 py-4">Files & Links</h2>
      <ul v-if="attachments.length" class="text-sm text-blue-400 hover:underline">
        <li v-for="attachment in attachments" :key="attachment.id" class="my-2 px-4">
          <a :href="attachment.attributes.output_path" target="_blank">{{ attachment.attributes.name }}</a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';

export default {
  data() {
    return {
      comment: '',
      messages: [],
      attachments: [],
      disableSendBtn: true,
      sending: false
    };
  },
  props: {
    project: {
      type: Object,
      required: true
    },
    student: {
      type: Object,
      required: true
    },
    owner: {
      type: Object,
      required: true
    },
    files: {
      type: Array,
      default: () => {
        return [];
      }
    }
  },
  computed: {
    user() {
      return this.$util.options.auth || {};
    }
  },
  validations: {
    comment: {
      required
    }
  },
  methods: {
    sendMessage() {
      this.sending = true;
      this.$util.post(`message`, {
        user_id: this.user.id,
        receiver_id: this.user.role === 'poster' ? this.student.id : this.owner.id,
        project_id: this.project.id,
        comment: this.comment
      }).then((res) => {
        Toast.fire('Your message was sent', '', 'success');
        this.getMessages();
      }).catch((error) => {
        if (error.response) {
          Toast.fire('Something went wrong. Please try again', '', 'error');
        }
      }).finally(() => {
        this.comment = '';
        this.sending = false;
      });
    },
    async getMessages() {
      this.messages = await this.$util.get(`message/project/${this.project.id}`);
    },
    async getAttachments() {
      this.attachments = await this.$util.get(`files/project/${this.project.id}`);
    }
  },
  created() {
    this.getMessages();
    this.getAttachments();
  }
};
</script>

<style></style>
