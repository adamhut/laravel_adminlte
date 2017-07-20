<template>
	<div class="ImportUser__wrapper">
		<button class="btn btn-success" @click="importUser">Import Valid Users</button>
	</div>
</template>

<script>
	import swal from 'sweetalert2';
	export default{
		props:['url'],
		data(){
			return {
				message:null,
			}
		},
		methods:{
			importUser(){
				//swal('Success','hello','success');;
				//return;
				this.message = null;
				axios.get(this.url)
					.then(response=>{
						swal('Success',response.data,'success');
					}).catch(error=>{
						swal('Error',error,'error');
					});
					
			}
		}		
	}
</script>