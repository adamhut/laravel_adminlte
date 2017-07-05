<template>
	<div class="Image-upload-wrapper Image-upload">
		<div class="croppie">
			
		</div>
		<div id="upload-wrapper">
			<button class="btn btn-primary btn-sm" @click="modalVisable=true">
				<i class="fa fa-upload"></i>Upload Image
			</button>
			<div class="Modal" v-if="modalVisable"> 
				<h4>Upload an Image</h4>
				<div class="input-file">
					<input type="file" id="upload-image" @change="setupFileUploader">
				</div>
				<button class="btn btn-success" @click="uploadFile">
					<i class="fa fa-upload"></i> Upload
				</button>
				<button class="btn btn-danger" @click="modalVisable=false">
					<i class="fa fa-times"></i> Cancel
				</button>
			</div>
		</div>
	</div>
</template>

<script>

	import Croppie from 'croppie';
	export default{
		props:[
			'imgUrl'
		],
		data(){
			return {
				image:null,
				croppie:null,
				modalVisable:false,
			}
		},
		mounted(){
			this.image = this.imgUrl;
			this.setupCroppie();
			this.$on('imageUploaded', function(imageData){
					console.log('I am here2')
				this.image = imageData;
				this.croppie.destory();
				this.setupCroppie();
			});
		},
		methods:{
			setupCroppie(){
				let el = document.querySelector('.croppie');
				this.croppie = new Croppie(el, {
				    viewport: { width: 200, height: 200, type:'circle' },
				    boundary: { width: 220, height: 220 },
				    showZoomer: true,
				    enableOrientation: true
				});
				this.croppie.bind({
				    url: this.image,
				    orientation: 4
				});
				//on button click
				this.croppie.result('blob').then(function(blob) {
				    // do something with cropped blob
				});	
			},
			setupFileUploader(e){
				let files = e.target.files || e.dataTransfer.files
				if(!files.length)
				{
					return;
				}

				this.createImage(files[0]);
			},
			createImage(file)
			{
				var image = new Image();
				var reader = new FileReader();
				var vm = this;
				reader.onload  = (e)=>{
					vm.image = e.target.result;
					vm.imageUploaded(e.target.result);
				}
				reader.readAsDataURL(file)
			},
			imageUploaded(imageData){
				//console.log('I am here2')
				this.image = imageData;
				this.croppie.destroy();
				this.setupCroppie();
			},
			uploadFile(){
				this.croppie.result({
					type:'canvas',
					size:'viewport'
				}).then(response=>{
					console.log(response);
				})
			}
		}
	}
</script>


<style lang="scss">
  .Image-upload {
    .Modal {
      border-top: 1px solid #f4f4f4;
      margin-top: 10px;
      h4 {
        margin-bottom: 20px;
      }
    }
    div#upload-wrapper {
      text-align: center;
    }
    .input-file {
      text-align: left;
      width: 50%;
      margin: 0px auto;
      margin-bottom: 20px;
    }
  }
</style>