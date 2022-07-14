import Vue from 'vue';
import util from "./helper/util.js";
import Vuelidate from 'vuelidate';
import Vuex from 'vuex';
import SvgVue from 'svg-vue';
import VueSweetalert2 from 'vue-sweetalert2';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.min.css';

import VueTippy, { TippyComponent } from 'vue-tippy';

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import { store } from './store/store';

Vue.use(VueTippy);
Vue.component(TippyComponent);
Vue.use(Loading);
Vue.use(Vuelidate);
Vue.use(Vuex);
Vue.use(VueSweetalert2);
Vue.use(SvgVue);
Vue.prototype.$util = util
store.$util = util

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  timer: 5000,
  timerProgressBar: true,
  showConfirmButton: false
});
window.Toast = Toast;

Vue.component('rating', require('./components/Rating').default);
Vue.component('Home', require('./components/Home/Home').default);

Vue.component('header-component', require('./components/TheHeader.vue').default);
//Vue.component('the-footer', require('./Views/TheFooter.vue').default);

// Staff dashboard
Vue.component('StaffDashboard', require('./components/Staff/StaffDashboard').default);
Vue.component('ViewStaffSetting', require('./Views/ViewStaffSetting').default);
Vue.component('Contracts', require('./Views/Contract/Contract').default);
Vue.component('ContractShow', require('./Views/Contract/ContractShow').default);

// student
Vue.component('ListInvited', require('./Page/ListInvited').default);
Vue.component('ListApplicated', require('./Page/ListApplicated').default);

// Authenticate
Vue.component('RegisterForm', require('./components/Auth/RegisterForm').default);
Vue.component('LoginForm', require('./components/Auth/LoginForm').default);

// Task
Vue.component('list-tasks', require('./components/task/List').default);
Vue.component('task-detail', require('./components/task/Detail').default);
Vue.component('TaskProposal', require('./components/task/Proposal/TaskProposal').default);

const app = new Vue({
  el: '#app',
  store,
  data() {
    return {
      fullPage: true
    };
  }
});
