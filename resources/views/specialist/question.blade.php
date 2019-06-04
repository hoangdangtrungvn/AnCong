@extends('adminlte::page')

@section('title', 'Câu Hỏi Bệnh Nhân | Bác Sĩ Chuyên Khoa')

@section('content_header')
<h1>CÂU HỎI BỆNH NHÂN</h1>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @if (session('alert'))
                <div class="alert {{ session('alert')['class'] }} alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon {{ session('alert')['icon'] }}"></i> {{ session('alert')['message'] }}
                </div>
                @endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="data-tables" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Mã bệnh nhân</th>
                            <th>Tên bệnh nhân</th>
                            <th>Địa chỉ email</th>
                            <th>Ngày khám</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $user->code }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($user->created_at)) }}</td>
                        </tr>
                    </tbody>
                </table>
                <table id="data-tables" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Mã câu hỏi</th>
                            <th>Nội dung</th>
                            <th>Ngày gửi</th>
                            <th>Số lượng tư vấn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td>{{ $question->content }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($question->created_at)) }}</td>
                            <td>{{ count($doctor_records) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>HÌNH ẢNH</h4>
                    </div>
                    @foreach ($images as $image)
                    <div class="col-xs-6 col-md-3">
                        <a href="{{ config('api.base_uri').$image->link_path }}" class="thumbnail gallery" data-fancybox="gallery">
                            <div class="question-image" style="background-image: url({{ config('api.base_uri').$image->link_path }});"></div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>DANH SÁCH TƯ VẤN</h4>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#record_to_specialist" data-toggle="tab">Bác Sĩ ({{ count($doctor_records) }})</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="record_to_specialist">
                                    @foreach ($doctor_records as $record)
                                    <div class="panel-group" id="tab_record_{{ $record->id }}">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#tab_record_{{ $record->id }}" href="#collapse_{{ $record->id }}">{{ $record->creator == 1 ? 'Tư vấn của bác sĩ điều trị:' : 'Tư vấn của bác sĩ chuyên khoa:' }} {{ $record->doctor_name }} - Thời gian: {{ date('d-m-Y H:i:s', strtotime($record->created_at)) }}</a>
                                                </h4>
                                            </div>
                                            <div id="collapse_{{ $record->id }}" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <h4>Chỉ định</h4>
                                                    {!! $record->assign !!}
                                                    <h4>Kê đơn</h4>
                                                    {!! $record->prescription !!}
                                                    <h4>Kết luận</h4>
                                                    {!! $record->reasoning !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                    </div>
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#medical-record-modal">
                            <i class="fa fa-edit"></i> GỬI TƯ VẤN MỚI
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<div class="modal fade js-medical-record-modal" id="medical-record-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center bold">GỬI TƯ VẤN MỚI</h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_specialist" data-toggle="tab">Bác sĩ phụ trách</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_specialist">
                            <form action="{{ route('specialists.message') }}" method="POST">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $question->id }}" />
                                <input type="hidden" name="doctor_id" value="{{ $doctor_id }}" />
                                <div class="form-group">
                                    <label>Chỉ định của bác sĩ</label>
                                    <textarea name="assign" class="textarea" placeholder="Nội dung chỉ định"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Bác sĩ kê đơn</label>
                                    <textarea name="prescription" class="textarea" placeholder="Nội dung kê đơn"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kết luận của bác sĩ</label>
                                    <textarea name="reasoning" class="textarea" placeholder="Kết luận của bác sĩ"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Gửi Tư Vấn</button>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
        </div>
    </div>
</div>
<!-- .modal -->
@stop

@section('css')
<link rel="stylesheet" href="/template/backend/css/bootstrap3-wysihtml5.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/template/backend/css/jquery.fancybox.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/template/backend/css/specialist.css" />
@stop

@section('js')
<script type="text/javascript" src="/template/backend/js/wysihtml5x-toolbar.min.js"></script>
<script type="text/javascript" src="/template/backend/js/bootstrap3-wysihtml5.min.js"></script>
<script type="text/javascript" src="/template/backend/js/jquery.fancybox.min.js"></script>
<script src="/template/backend/js/specialist.js"></script>
@stop