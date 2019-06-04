@extends('adminlte::page')

@section('title', 'Danh Sách Câu Hỏi | Bác Sĩ Chuyên Khoa')

@section('content_header')
<h1>DANH SÁCH CÂU HỎI</h1>
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
                            <th>Mã câu hỏi</th>
                            <th>Nội dung</th>
                            <th>Ngày tạo</th>
                            <th>Bác sĩ phụ trách</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specialist_questions as $specialist_question)
                        <tr>
                            <td>{{ $specialist_question->id }}</td>
                            <td>{{ $specialist_question->content }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($specialist_question->created_at)) }}</td>
                            <td>{{ $specialist_question->doctor_name }}</td>
                            <td><a href="{{ route('specialists.question', $specialist_question->id) }}">XEM</a></td>
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
@stop

@section('css')
<link rel="stylesheet" href="/template/backend/css/specialist.css" />
@stop

@section('js')
<script src="/template/backend/js/specialist.js"></script>
@stop