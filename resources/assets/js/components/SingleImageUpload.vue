<template>
	<div class="Field__wrapper">
		<img :src="imagePreview" class="preview-image" @click="openUpload">
		<input name="image" 
			type="file" 
			id="file-field" 
			@change="updatePreview" 
			style="display:none"
		/>
	</div>
</template>

<script>
export default{

	data(){
		return {
			imagePreview:'/adminlte/upload_image.png'
		}
	},
	methods:{
		openUpload(){
			document.querySelector('#file-field').click();
		},
		updatePreview(e){
			var reader;
			var file = e.target.files;
			if(file.length===0)
			{
				console.log('it is empty');
				return;
			}
			reader =  new FileReader();
			reader.onload= (e)=>{
				this.imagePreview = e.target.result;
			}
			console.log(reader);
			reader.readAsDataURL(file[0]);

		}
	}
}
</script>

<style type="text/css">
	img.preview-image{
		width: 327px;
		height:184px;
	}
</style>