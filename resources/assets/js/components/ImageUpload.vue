<template>
	<div class="Image-upload-wrapper Image-upload">
		<div class="croppie">
			
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
			}
		},
		mounted(){
			this.image = this.imgUrl;
			this.setupCroppie();
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