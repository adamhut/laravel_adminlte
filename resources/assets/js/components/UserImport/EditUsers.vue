<template>
	<div class="EditUsers_wrapper">
		<div class="mb10">
			<button class="btn btn-primary" @click="loadTableData">
				<i class="fa fa-edit"></i> Edit Users
			</button>
		</div>
		<div class="mb10" v-if="tableData">
			<table-component 
				:data="tableData" 
				sort-by="name"
				sort-order ="asc"
			>
				<table-column show="name" label="Name"></table-column>
				<table-column show="email" label="Email"></table-column>
				<table-column show="message" label="Error Message"></table-column>
			</table-component>
		</div>
	</div>
</template>

<script>	
	//import {EditErrorUserData} from './../../config';
	import { TableComponent, TableColumn } from 'vue-table-component';
	export default{
		props:['url'],

		components:{
			'table-component':TableComponent,
			'table-column':TableColumn,
		},
		data(){
			return{	
				tableData:null
			}
		},
		mounted(){

		},
		methods:{
			loadTableData(){
				this.message = null;
				axios.get(this.url)
					.then(response=>{
						this.tableData = response.data;

					}).catch(error=>{
						console.log(error);
					});
			},
		}


	}
</script>