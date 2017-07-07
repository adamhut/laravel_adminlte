@extends('adminlte.html')

@section('content')
	<table class="table ">
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
						<confirm-modal 
							message="Are you sure You want to delete this user {{$user->name}}?"
							btn-text='<i class="fa fa-trash"></i> Delete'
							btn-class="btn-danger"
							end-point="{{url('api/v1/user')}}"
							post-data="{{json_encode($user)}}"
							:onConfirm="handleConfirmSuccess"
						>		
						</confirm-modal>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>	
@endsection