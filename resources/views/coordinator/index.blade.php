@extends('adminlte::page')

@section('title', 'Danh Sách Bệnh Nhân | Điều Phối Viên')

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
                <div class="col-lg-2 mb-10 pd-0">
                    <div class="has-feedback">
                        <input type="text" class="form-control input-sm" placeholder="Tìm kiếm...">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-lg-8 text-center mb-10 pd-0">
                    Trạng thái:
                    <i class="fa fa-check-circle {{ app('request')->input('status') == 'true' ? 'text-success' : '' }} pointer ml-10 js-status-true"></i>
                    <i class="fa fa-times-circle {{ app('request')->input('status') == 'false' ? 'text-danger' : '' }} pointer ml-10 js-status-false"></i>
                </div>
                <div class="col-lg-2 mb-10 pd-0">
                    <div class="has-feedback">
                        <select id="order" class="form-control" name="order">
                            <option value="newest" {{ app('request')->input('order') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ app('request')->input('order') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        </select>
                    </div>
                </div>
                <table id="data-tables" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td colspan="8">Tổng số bệnh nhân: 15</td>
                        </tr>
                        <tr>
                            <th>Mã bệnh nhân</th>
                            <th>Tên bệnh nhân</th>
                            <th>Địa chỉ email</th>
                            <th>Câu hỏi dinh dưỡng</th>
                            <th>Câu hỏi điều trị</th>
                            <th>Bác sĩ dinh dưỡng</th>
                            <th>Bác sĩ điều trị</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user['code'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['question_dieticians'] }}</td>
                            <td>{{ $user['question_doctors'] }}</td>
                            <td>
                                @if (!$user['dieticians'])
                                <select data-user-id="{{ $user['id'] }}" data-doctor-uri="/assign/dietician" class="js-dieticians-dropdown" name="dietician_id" {{ !$user['question_dieticians'] ? 'disabled' : '' }}>
                                    <option value="0">-- Chọn bác sĩ --</option>
                                    @foreach ($dieticians as $dietician)
                                    <option value="{{ $dietician['id'] }}">{{ $dietician['name'] }}</option>
                                    @endforeach
                                </select>
                                @else
                                @foreach ($user['dieticians'] as $dietician)
                                {{ $loop->first ? '' : ', ' }}
                                {{ $dietician['name'] }}
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @if (!$user['doctors'])
                                <select data-user-id="{{ $user['id'] }}" data-doctor-uri="/assign/doctor" class="js-doctors-dropdown" name="doctor_id" {{ !$user['question_doctors'] ? 'disabled' : '' }}>
                                    <option value="0">-- Chọn bác sĩ --</option>
                                    @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor['id'] }}">{{ $doctor['name'] }}</option>
                                    @endforeach
                                </select>
                                @else
                                @foreach ($user['doctors'] as $doctor)
                                {{ $loop->first ? '' : ', ' }}
                                {{ $doctor['name'] }}
                                @endforeach
                                @endif
                            </td>
                            <td>
                                {!! $user['status'] ? '<i class="fa fa-check-circle text-success ml-5"></i> <span class="text-success">Đã gán</span>' : '<i class="fa fa-times-circle text-danger ml-5"></i> <span class="text-danger">Chưa gán</span>' !!}
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
<div class="modal fade js-coordinator-modal" id="coordinator-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Gán Bác Sĩ</h4>
            </div>
            <div class="modal-body">
                <p>Đồng ý gán bác sĩ cho bệnh nhân?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('coordinators.assign') }}" method="POST">
                    @csrf
                    <input type="hidden" class="js-user-id-input" name="user_id" />
                    <input type="hidden" class="js-doctor-id-input" name="doctor_id" />
                    <input type="hidden" class="js-doctor-uri-input" name="doctor_uri" />
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
<link rel="stylesheet" href="/template/backend/css/coordinator.css" />
@stop

@section('js')
<script src="/template/backend/js/coordinator.js"></script>
@stop