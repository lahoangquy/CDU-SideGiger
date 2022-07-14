<template>
  <view-dashboard-layout>
    <h1 class="dashboard__heading">List Invites Pending</h1>
    <white-box>
      <white-box-content>
        <div v-if="invites.length" class="flex flex-col">
          <div class="sm:-mx-6 lg:-mx-8">
            <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
              <table class="min-w-full">
                <thead class="bg-gray-100 dark:bg-gray-700">
                  <tr>
                    <th scope="col" width="450">Project Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Due Date</th>
                    <th scope="col" class="relative py-3 px-6">
                      <span class="sr-only">Action</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(invite, i) in invites" :key="i">
                    <td>{{ invite.project.title }}</td>
                    <td>{{ invite.project.category.name }}</td>
                    <td>{{ invite.project.due_date }}</td>
                    <td>
                      <button
                        @click.prevent="acceptOrDecline(invite, 'accepted')"
                        class="rounded-lg text-sm bg-blue-400 text-white px-2 py-1 border border-gray-200"
                      >
                        Accept
                      </button>
                      <button
                        @click.prevent="acceptOrDecline(invite, 'declined')"
                        class="rounded-lg text-sm bg-gray-50 px-2 py-1 border border-gray-200"
                      >
                        Decline
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div v-else class="py-6 text-center">There was no project yet.</div>
      </white-box-content>
    </white-box>
  </view-dashboard-layout>
</template>

<script>
import WhiteBox from '../components/shared/WhiteBox.vue';
import WhiteBoxContent from '../components/shared/WhiteBoxContent.vue';
import ViewDashboardLayout from '../Views/ViewDashboardLayout.vue';

export default {
  components: { ViewDashboardLayout, WhiteBox, WhiteBoxContent },
  data() {
    return {
      invites: []
    };
  },
  computed: {
    user() {
      return this.$util.options.auth || {};
    }
  },
  methods: {
    async getInvites() {
      this.invites = await this.$util.get(`invite/by-student/${this.user.id}`);
    },
    async acceptOrDecline(invite, status) {
      let loader = this.$loading.show({
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel
      });
      try {
        await this.$util.post(`invite/accept-or-decline`, {
          status: status,
          invite_id: invite.id
        });

        this.$swal({
          title: 'Congratulation!',
          text: 'Your contract was created. You now can be started on your contract.',
          icon: 'success',
          showCancelButton: false,
          confirmButtonText: 'I got it.'
        }).then(async (result) => {
          if (result.isConfirmed) {
            window.location.href = '/dashboard/manage-contract';
          }
        });
      } catch (error) {
        if (error.response) {
          Toast.fire('Something went wrong', '', 'error');
        }
      } finally {
        loader.hide();
      }
    }
  },
  created() {
    this.getInvites();
  }
};
</script>

<style></style>
