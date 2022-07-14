<template>
  <div class="px-2">
    <div v-show="showCurrentModal">
      <div class="flex items-center border-b border-gray-200 p-3">
        <svg-vue icon="search-02" class="h-4 w-4 text-gray-500" />
        <input
          type="text"
          v-model="keyword"
          placeholder="Search"
          class="text-sm border-none bg-none flex-1 focus:outline-none focus:ring-transparent"
        />
      </div>

      <perfect-scrollbar>
        <ul class="mt-3">
          <li
            v-for="student in filterStudents"
            :key="student.id"
            class="flex justify-between items-center px-4 py-3 hover:bg-gray-50 hover:rounded-md text-sm cursor-pointer"
          >
            <div class="flex flex-col space-y-1 flex-1" @click="handleInvite(student)">
              <span>{{ student.name }}</span>
              <span class="text-xs italic text-gray-400">{{ student.email }}</span>
            </div>
            <span @click="openProfile(student)" class="bg-white border border-gray-100 rounded py-1 px-2 text-gray-600 text-xs cursor-pointer"
              >Profile</span
            >
          </li>
        </ul>
      </perfect-scrollbar>
    </div>
    
    <BaseModal :show="showUserProfileModal" @close="closeUserProfileModal" title="Student Profile">
      <student-profile :studentId="studentId" @close="closeUserProfileModal" />
    </BaseModal>
  </div>
</template>

<script>
import { PerfectScrollbar } from 'vue2-perfect-scrollbar';
import BaseModal from '../BaseModal.vue';
import StudentProfile from './StudentProfile.vue';


export default {
  components: {
    BaseModal,
    StudentProfile,
    PerfectScrollbar
  },
  data() {
    return {
      showCurrentModal: true,
      showUserProfileModal: false,
      studentId: false,
      keyword: ''
    };
  },
  props: {
    project: Object,
    students: Array
  },
  computed: {
    filterStudents() {
      return this.students.filter((student) => student.name.toLowerCase().includes(this.keyword.toLowerCase()));
    }
  },
  methods: {
    openProfile(student) {
      this.showUserProfileModal = true
      this.showCurrentModal = false
      this.studentId = student.id
    },
    closeUserProfileModal() {
      this.showUserProfileModal = false
      this.showCurrentModal = true
      this.studentId = '';
    },
    async handleInvite(student) {
      let loader = this.$loading.show({
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel
      });
      try {
        await this.$util.post(`invite`, {
          student_id: student.id,
          project_id: this.project.id
        });
        this.$emit('close');
        Toast.fire('Your invitation was sent', '', 'success');
      } catch (error) {
        if (error) {
          this.$swal('Oop...', error.message, 'error');
        }
      } finally {
        loader.hide();
      }
    }
  }
};
</script>

<style src="vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css" />
<style scoped>
.ps {
  height: 400px;
}
</style>
