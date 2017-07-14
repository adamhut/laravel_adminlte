@extends('adminlte.html')


@section('breadcrumb')
  <section class="content-header">
    <h1>Dashboard<small>Control panel</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <info-box
                text="Act. Pending"
                number="{{$dashboardData['activation_pending']}}"
                color="bg-red"
                icon="fa-hourglass"
            >
            </info-box>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <info-box
                text="My activities"
                number="{{$dashboardData['my_recent_activities']}}"
                color="bg-green"
                icon="fa-line-chart"
            >
            </info-box>
        </div>
    </div>
    {{--End first row--}}
	
    <div class="row">
        <div class="col-sm-12">
            <activity-graph></activity-graph>
        </div>
    </div>
  
    <div class="row">
        <div class="col-sm-6">
            <form action="{{route('test-upload-image')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <single-image-upload></single-image-upload>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">
                        <i class="fa fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div> 
    </div>

    {{--End second row--}}
 
@endsection