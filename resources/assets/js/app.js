/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component('sidebar-collapse', require('./components/SidebarCollapse.vue'));
Vue.component('image-upload', require('./components/ImageUpload.vue'));

const app = new Vue({
  el: '#app',
  data: {
    message: 'Hello World!'
  }
})