<template>
  <form class="shadow-none">
    <div class="form-group">
      <label for="project.title">Title</label>
      <input type="text" v-model="project.title" class="form-control" />
      <BaseFieldError v-if="errors && errors.title">{{ errors && errors.title[0] }}</BaseFieldError>
    </div>
    <div class="grid gird-cols-1 md:grid-cols-2 gap-4">
      <div class="form-group">
        <label for="project.title">Due Date</label>
        <input type="date" v-model="project.due_date" class="form-control" />
        <BaseFieldError v-if="errors && errors.due_date">{{ errors && errors.due_date[0] }}</BaseFieldError>
      </div>
      <div class="form-group">
        <label for="project.category_id">Category</label>
        <select v-model="project.category_id" class="form-control">
          <optgroup v-for="(cate, i) in categories" :key="i" :label="cate.name">
            <option v-for="(c, k) in cate.subs" :key="k" :value="c.id">
              {{ c.name }}
            </option>
          </optgroup>
        </select>
        <BaseFieldError v-if="errors && errors.category_id">{{ errors && errors.category_id[0] }}</BaseFieldError>
      </div>
    </div>

    <div class="form-group">
      <label for="">Description</label>
      <VueEditor v-model="project.description" placeholder="Enter description" />
      <BaseFieldError v-if="errors && errors.description">{{ errors && errors.description[0] }}</BaseFieldError>
    </div>
    <div class="form-group">
      <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-removed-file="removeFile" @vdropzone-success="getFileUploaded" />
    </div>

    <!-- Modal footer -->
    <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
      <button @click.prevent="submit" type="button" class="btn btn-primary max-w-[180px]">Submit</button>
      <button @click="$emit('close')" type="button" class="btn-cancel">Cancel</button>
    </div>
  </form>
</template>

<script>
import { VueEditor } from 'vue2-editor';
import { mapGetters, mapActions } from 'vuex';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import BaseAlert from '../BaseAlert.vue';
import BaseFieldError from '../BaseFieldError.vue';

export default {
  components: { VueEditor, vueDropzone: vue2Dropzone, BaseAlert, BaseFieldError },
  props: {
    modalId: {
      type: String,
      default: ''
    },
    projectId: {
      type: [String, Number],
      default: ''
    },
  },
  data: () => {
    return {
      errors: '',
      project: {
        title: '',
        category_id: '',
        due_date: '',
        description: '',
        user_id: '',
        files: []
      },
      dropzoneOptions: {
        url: '/upload',
        addRemoveLinks: true,
        disablePreviews: false,
        acceptedFiles: 'image/*, application/pdf, .doc,.docx, .zip',
        maxFilesize: 2048,
        headers: {
          'X-CSRF-TOKEN': document.head.querySelector('[name=csrf-token]').content
        }
      }
    };
  },
  computed: {
    user() {
      return this.$util.options.auth || {};
    },
    ...mapGetters({
      categories: 'category/categories'
    })
  },
  methods: {
    ...mapActions({
      getStaffProject: 'project/getProjectByOwner'
    }),
    submit() {
      this.$util
        .post(this.projectId != '' ? `projects/update/${this.projectId}` : `projects/store`, this.project)
        .then((res) => {
          this.getStaffProject(this.user.id);
          this.resetForm();
          this.$emit('close');
          Toast.fire(res.message, '', 'success');
        })
        .catch((e) => {
          this.errors = e.errors;
        });
    },
    removeFile(file, res) {
      // const fileName = file.upload.filename;
      // axios.post('/removeFile', { fileName }).then((res) => {
      //   this.project.files = this.project.files.filter((item) => item.file !== fileName);
      // });
    },
    getFileUploaded(file, res) {
      // update new file name
      file.upload.filename = res.fileName;
      this.project.files.push({
        file: res.fileName,
        extension: res.extension
      });
    },
    resetForm() {
      this.project.title = '';
      this.project.due_date = '';
      this.project.description = '';
      this.project.category_id = '';
      this.project.files = [];
      //this.$refs.myVueDropzone.removeAllFiles();
    }
  },
  created() {
    this.project.user_id = this.user.id;
    if (this.projectId != '') {
      this.$util
        .get(`projects/${this.projectId}`)
        .then((res) => {
          this.project.title = res.title || '';
          this.project.due_date = new Date(res.due_date * 1000).toISOString().split('T')[0] || '';
          this.project.description = res.description || '';
          this.project.category_id = res.category.id || '';
          this.project.files = [];
        })
        .catch((e) => {
          this.errors = e.errors;
        });
    }

  }
};
</script>

<style></style>
