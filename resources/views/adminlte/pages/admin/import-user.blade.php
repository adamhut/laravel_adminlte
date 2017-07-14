@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Import users<small> Import bulk users to the system.</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Import users</li>
    </ol>
  </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Select a file to import</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="{{route('bulk-import-user')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="file">CSV file to upload</label>
                            <input type="file" name="file" id="file" class="form-control">
                            <div class="HelpText error">{{$errors->first('file')}}</div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary">
                                <i class="fa fa-upload"></i> Upload
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            @if($uuid = Session::get('error_rows_id'))
                <div class="mb-10">
                <a href="{{route('get-import-data',$uuid)}}" class="btn btn-warning">Download Invalid Rows</a>
                </div>
            @endif

            @if($uuid = Session::get('valid_rows_id'))
                {{--<a href="{{route('persist-incomplete-data',$uuid)}}" class="btn btn-success">Persist Valid Rows</a>--}}
                <div class="mb-10">
                <import-users url="{{route('persist-incomplete-data',$uuid)}}"></import-users>
                </div>
            @endif
            {{--
            @if($rows = Session::get('valid_rows') )
                
                @component('adminlte.pages.admin.partials.import_user_info')
                    @slot('heading')
                        Valid Data
                    @endslot
                    @slot('tablebHeading')
                        @foreach($rows[0] as $key =>$val)
                            <th>{{ucfirst($key)}}</th>
                        @endforeach 
                    @endslot
                    @slot('tablebBody')
                       @foreach($rows as $key =>$val)
                        <tr>
                            @foreach($val as $data)
                                <td>{{$data}}</td>
                            @endforeach    
                        </tr>
                        @endforeach
                    @endslot
                @endcomponent   
            @endif

            @if($rows = Session::get('error_rows'))
                 @component('adminlte.pages.admin.partials.import_user_info')
                    @slot('heading')
                        Error Data
                    @endslot
                    @slot('tablebHeading')
                        @foreach($rows[0] as $key =>$val)
                            <th>{{ucfirst($key)}}</th>
                        @endforeach 
                    @endslot
                    @slot('tablebBody')
                       @foreach($rows as $key =>$val)
                        <tr>
                            @foreach($val as $data)
                                <td>{{$data}}</td>
                            @endforeach    
                        </tr>
                        @endforeach
                    @endslot
                @endcomponent
            @endif
             --}}
        </div>
    </div>
@endsection