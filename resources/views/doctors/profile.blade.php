@extends('layouts.app')
@section('content')
    {{--    @include('doctors.partials.edit')--}}

    <div class="col-md-12 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <svg class="glyph stroked home">
                            <use xlink:href="#stroked-home"></use>
                        </svg>
                    </a></li>
                <li class="active">Icon</li>
                <li> Profile</li>
            </ol>
        </div>
        <br>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12" style="padding: 5%;">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$doctor->first_name}} {{$doctor->last_name}}
                        <a style="margin-left: 8px" class="btn btn-sm btn-primary pull-right" data-toggle="modal"
                           href="{{route('doctor.edit', $doctor->id)}}">
                            <span class="glyphicon glyphicon-edit"></span>
                            Edit Doctor
                        </a>
                        <a class="btn btn-sm btn-default pull-right" href="{{url('doctor')}}">Back
                            <span class="glyphicon glyphicon-share-alt"></span>
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <b>Address: {{$doctor->address}}</b><br>
                            <b></b><br>
                            <b>Phone: {{$doctor->phone}}</b><br>
                            <b></b><br>
                            <label>Email: <a
                                        href="mail:{{$doctor->email}}">{{$doctor->email}}</a></label><br>
                            <b></b><br>
                            <label>Education: {{$doctor->education}}</label><br>
                            <b></b><br>
                        </div>
                        <div class="col-md-6">
                            <label>Speciality: {{$doctor->department->name}}</label><br>
                            <b></b><br>
                            <label>Working Days: {{$doctor->working_day}}</label><br>
                            <b></b><br>
                            <label>Available Time: {{$doctor->in_time}}
                                - {{$doctor->out_time}}</label><br>
                            <b></b><br>
                            <label>Description: {{$doctor->description}}</label><br>
                            <b></b><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding: 5%;">
                <div class="panel panel-default">
                    <div class="panel-heading">Appointments {{$s}}
                        <a class="btn btn-sm btn-primary pull-right" data-toggle="modal" href="#addAppointment"><span
                                    class="glyphicon glyphicon-plus"></span>ADD Appointment</a></div>
                    <div class="panel-body">
                        @if($doctor->opd_sales()->count())
                            <table data-toggle="table" data-show-refresh="true" data-show-toggle="true"
                                   data-show-columns="true" data-search="true" data-select-item-name="toolbar1"
                                   data-pagination="true" data-sort-name="name" data-sort-order="desc">
                                <thead>
                                <tr>
                                    <th data-sortable="true">No.</th>
                                    <th data-sortable="true">Patient Name</th>
                                    <th data-sortable="true">Description</th>
                                    <th data-sortable="true">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$appointment->patient->first_name}}{{$appointment->patient->last_name}}</td>
                                        <td>{{$appointment->description}}</td>
                                        <td>
                                            @if($appointment->status)
                                                <a class="btn btn-sm btn-success"
                                                   href="{{ route('appointment.edit',$appointment->id) }}"><span
                                                            class=" glyphicon glyphicon-ok"></span> Complete</a>
                                            @else
                                                <a class="btn btn-sm btn-warning"
                                                   href="{{ route('appointment.edit',$appointment->id) }}"><span
                                                            class=" glyphicon glyphicon-remove"> </span> Pending</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>

                            </table>

                        @else
                            <h1>No record Found..</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="doctor_delete" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Doctor</h4>
                </div>
                {!! Form::open(['method' => 'DELETE','route' => ['doctor.destroy', $doctor->id]]) !!}
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_id">
                    <label>Are your sure want to delete this doctor?</label>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button"><span
                                class='glyphicon glyphicon-remove'></span> No
                    </button>
                    <button class="btn btn-danger" type="submit"><span class='glyphicon glyphicon-remove'></span> Yes
                    </button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#delete_doctor').click(function () {
            $('#doctor_delete').modal('show');
            $('#editDoctor').modal('hide');

        })
    </script>
@endsection
