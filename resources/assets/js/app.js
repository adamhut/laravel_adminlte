/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component('sidebar-collapse', require('./components/SidebarCollapse.vue'));
Vue.component('image-upload', require('./components/ImageUpload.vue'));

Vue.component('info-box', require('./components/InfoBox.vue'));
Vue.component('media-manager', require('./components/MediaManager.vue'));
Vue.component('user-image', require('./components/UserImage.vue'));
Vue.component('user-activation', require('./components/UserActivation.vue'));
Vue.component('activity-graph', require('./components/ActivityGraph/ActivityGraph.vue'));

Vue.component('single-image-upload', require('./components/SingleImageUpload.vue'));

Vue.component('import-users', require('./components/UserImport/ImportUsers.vue'));

Vue.component('edit-users', require('./components/UserImport/EditUsers.vue'));

const app = new Vue({
  	el: '#app',
  	data: {
    	message: 'Hello World!'
  	},
  	methods:{
  		handleConfirmSuccess(){

  		}
  	}

});

$('ul.sidebar-menu').tree(options)