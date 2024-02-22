@extends('layouts.app')
@section('title','Activity Log')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>سجل النشاطات</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">الفلتر</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>--}}
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <form action="" method="GET" id="filterForm">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>الموديل</label>
                                        <select class="form-control" name="model">
                                            <option value="">إختر الموديل</option>
                                            @foreach(\App\Activity::$logModels as $k=>$v)
                                             <option value="{{$k}}"  @if(request('model')===$k) selected @endif>{{trans("front.$v")}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>المستخدم</label>
                                        <select class="form-control" name="causer">
                                            <option value="">إختر المستخدم</option>
                                            @foreach(\App\User::get() as $user)
                                                <option value="{{$user->id}}" @if(request('causer')==$user->id) selected @endif>{{$user->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>فترة من</label>
                                        <input type="date" class="form-control date" name="from" value="{{ request('from')  }}">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>الفترة الى</label>
                                        <input type="date" class="form-control date" name="to" value="{{ request('to')  }}" >
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <button type="submit" class="btn btn-primary form-control">بحث</button>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <a  type="button" class="btn btn-primary form-control" id="reset">إعادة تعيين</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.row -->
                    </div>

                </div>

                <div class="box">
                    @include('logs._list')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).on('click', "#reset", function () {
            let form = $('#filterForm');
            form[0].reset();
            $('#filterForm input , #filterForm select').val('');
        })
    </script>
@endpush
