@extends('adminlte::page')

@section('title', 'Danh Sách Bệnh Nhân | Bác Sĩ Điều Trị')

@section('content_header')
<h1>DANH SÁCH BỆNH NHÂN</h1>
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
                            <th>Số câu hỏi</th>
                            <th>Ngày khám</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr data-toggle="collapse" data-target="#questions-{{ $user->id }}">
                            <td>{{ $user->code }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->question_count }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($user->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td class="pd-0" colspan="5">
                                <div class="collapse p-10" id="questions-{{ $user->id }}">
                                    <table id="data-tables" class="table table-bordered table-hover m-0">
                                        <thead>
                                            <tr>
                                                <th>Mã câu hỏi</th>
                                                <th>Nội dung</th>
                                                <th>Ngày tạo</th>
                                                <th>Gán bác sĩ</th>
                                                <th>Bác sĩ chuyên khoa</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->questions as $question)
                                            <tr>
                                                <td>{{ $question->id }}</td>
                                                <td>{{ $question->content }}</td>
                                                <td>{{ date('d-m-Y H:i:s', strtotime($question->created_at)) }}</td>
                                                <td>
                                                    <select data-question-id="{{ $question->id }}" data-specialist-uri="/assign/specialist" class="js-specialists-dropdown" name="specialist_id">
                                                        <option value="0">-- Chọn bác sĩ --</option>
                                                        @foreach ($specialists as $specialist)
                                                        <option value="{{ $specialist->id }}">{{ $specialist->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    @foreach ($question->specialists as $specialist)
                                                    {{ $loop->first ? '' : ', ' }}
                                                    {{ $specialist->name }}
                                                    @endforeach
                                                </td>
                                                <td><a href="{{ route('doctors.question', $question->id) }}">XEM</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<div class="modal fade js-doctor-modal" id="doctor-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Gán Bác Sĩ</h4>
            </div>
            <div class="modal-body">
                <p>Đồng ý gán bác sĩ cho câu hỏi?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('doctors.assign') }}" method="POST">
                    @csrf
                    <input type="hidden" class="js-question-id-input" name="question_id" />
                    <input type="hidden" class="js-specialist-id-input" name="specialist_id" />
                    <input type="hidden" class="js-specialist-uri-input" name="specialist_uri" />
                    <button type="submit" class="btn btn-primary">Đồng Ý</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy Bỏ</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- .modal -->
@stop

@section('css')
<link rel="stylesheet" href="/template/backend/css/doctor.css" />
@stop

@section('js')
<script src="/template/backend/js/doctor.js"></script>
@stop