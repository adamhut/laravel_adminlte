@extends('adminlte.html')

@section('breadcrumb')
  	<section class="content-header">
    	<h1>Activations Pending<small>Users in the system whose's activation is pending</small></h1>
	    <ol class="breadcrumb">
      		<li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      		<li><a href="#"><i class="fa fa-gear"></i> Configuration</a></li>
      		<li class="active">User activation pending</li>
    	</ol>
  	</section>
@endsection

@section('content')
	<div class="row">
	    <div class="col-sm-12">
	      	<div class="box box-primary">
	        	<div class="box-header with-border">
	         		<h3 class="box-title">Application settings</h3>
	        	</div>
	        	<!-- /.box-header -->
	        	<div class="box-body">
	          		<user-activation :users="{{$users}}"></user-activation>
	        	</div>
	        	<!-- /.box-body -->

	        	<div class="box-footer">
	        	</div>
	      	</div>
	    </div>
	</div>
	{{--
	<user-activation :users={{$users}}></user-activation>
	<table class="table table-bordered table-striped table-hover">
		<thead>	
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>	
			@foreach($users as $user)
				<tr>
					<td>
						{{$user->name}}
					</td>
					<td>
						{{$user->email}}
					</td>
					<td>
						<div class="pull-left gap-left gap-10 activate-button mr-1">
							 <confirm-modal 
								message="Are you sure You want to Activate this user {{$user->name}}?"
								btn-text='<i class="fa fa-trash"></i> Activate'
								btn-class="btn-success"
								end-point="{{url('api/v1/user')}}"
								method="update"
								post-data="{{json_encode($user)}}"
								:onConfirm="handleConfirmSuccess"
							>		
							</confirm-modal>
						</div>
						<div class="pull-left gap-left gap-10 activate-button ">
							<confirm-modal 
								message="Are you sure You want to delete this user {{$user->name}}?"
								btn-text='<i class="fa fa-trash"></i> Delete'
								btn-class="btn-danger"
								end-point="{{url('api/v1/user')}}"
								method="delete"
								post-data="{{json_encode($user)}}"
								:onConfirm="handleConfirmSuccess"
							>		
							</confirm-modal>
						</div>
					</td>
				</tr>
			@endforeach

		</tbody>
	</table>--}}	
@endsection