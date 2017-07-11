<template>
	<div class="UserActivation">
  		<table class="table table-bordered table-striped table-hover" v-if="userList.length > 0">
    		<thead>
      			<tr>
			        <th>#</th>
			        <th>Name</th>
			        <th>Email</th>
			        <th>Token</th>
			        <th></th>
      			</tr>
    		</thead>
    		<tbody>
    			<tr v-for="(user , index) in userList" :key="user.id">
    				<td v-html="user.id"></td>
    				<td v-html="user.name"></td>
    				<td v-html="user.email"></td>
    				<td v-html=""></td>
    				<td>
    					<div class="pull-left gap-left gap-10 activate-button mr-1">
							 <confirm-modal 
								message="Are you sure You want to Activate this user?"
								btn-text='<i class="fa fa-trash"></i> Activate'
								btn-class="btn-success"
								:end-point="activateUser"
								method="update"
								:post-data="{userId: user.id,id:index}"
								@onConfirm="removeUserFromList"
							>		
							</confirm-modal>
						</div>
						<div class="pull-left gap-left gap-10 activate-button ">
							<confirm-modal 
								message="Are you sure You want to delete this use ?"
								btn-text='<i class="fa fa-trash"></i> Delete'
								btn-class="btn-danger"
								:end-point="deleteUser"
								method="delete"
								:post-data="{userId: user.id,id:index}"
								@onConfirm="removeUserFromList"
							>		
							</confirm-modal>
						</div>
    				</td>
    			</tr>
    		</tbody>
    	</table>
    </div>

</template>

<script>
	//import ''
	//Vue.component('confirm-modal', require('./components/ConfirmModal.vue'));
	import confirmModal from './ConfirmModal';
	
	export default{
		props: ['users'],
		components:{confirmModal},
		data(){
			return {
				userList:[],
				activateUser: '/api/v1/user',
        		deleteUser: '/api/v1/user',
			}
		},
		mounted () {
	      	this.userList = this.users;
		    //console.log(this.userList);
	    },
		methods: {
      		removeUserFromList (id) {
      			alert(id);
      			this.userList.splice(id,1);
      			//removeUserFromList
      			//this.$emit('deleted',id)
      			//remove(index)
        		/*this.userList = _.remove(this.userList, (user) => {
        			//user.id;
          			//return user.id !== userToRemove.id
        		});
        		*/
      		}
    	}
		
	}

</script>