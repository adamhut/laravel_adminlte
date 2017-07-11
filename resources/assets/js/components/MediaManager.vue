<template>
	<div class="MediaManager__Wrapper">
	  	<div class="Uploader__Wrapper" v-if="showUploader">
	    	<p>
	    		<span class="pull-right">
	    			<i class="fa fa-times" @click="showUploader = false"></i>
	    		</span>
	    	</p>
	    	<dropzone id="myVueDropzone"
	              class="margin-bottom-10"
	              :headers="csrfHeaders"
	              :url="mediaUploadUrl"
	              :use-font-awesome="true"
	              accepted-file-types="image/*"
	              :thumbnail-height="100"
	              :thumbnail-width="100"
	              :vdropzone-success="showSuccess"
	              :vdropzone-error="onError"
	    	>
	    	</dropzone>
	  	</div>
		
	  	<div class="Meta_row margin-bottom-10">
	    	<button class="btn btn-primary" @click="showUploader = true" v-if="!showUploader">Add new</button>
	  	</div>

	</div>
</template>
<script>
	import Dropzone from 'vue2-dropzone';

	export default{
		components:{
			Dropzone
		},
		data(){
			return {
				showUploader:false,
				csrfHeaders:null,
				mediaUploadUrl:'http://larainferno.dev/api/v1/media-upload',
			}
		},
		created(){

			this.csrfHeaders = {
		    	'X-CSRF-TOKEN': window.Laravel.csrfToken
		    }
		},
		methods: {
	       	showSuccess(file){
	        	console.log('A file was successfully uploaded',file);
	      	},
	      	onError(){
	      		console.log('I am error');
	      	}

	    }
	}

</script>

<style lang="scss">
  .galleryWrapper {
    li {
      list-style: none;
      float: left;
      padding: 8px;
      margin: 0;
      .thumbnail {
        position: relative;
        width: 150px;
        height: 150px;
        overflow: hidden;
        img {
          position: absolute;
          left: 50%;
          top: 50%;
          height: 100%;
          width: auto;
          -webkit-transform: translate(-50%,-50%);
          -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);
        }
      }
    }
  }
  .media-manager-details {
    .modal-content {
      width: 80%;
      .big-image {
        img {
          max-width: 660px;
        }
      }
    }
  }
</style>