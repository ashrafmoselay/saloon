@extends('layouts.app')
@section('title',trans('app.support').' '.$person->name)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('app.support')
            <small>
                {{$person->name}}
            </small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <form id="personForm" action="{{route('persons.support',$person)}}" method="post">
            {{ csrf_field() }}
            <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.title')</label>
                            <textarea required class="form-control" name="comment"></textarea>
                       </div>
                    </div>
                </div>
                <div class="row">
                    <div style="padding-top: 10px;" class="col-md-3">
                        <div class="form-group">
                            <label>ذكرنى بمراجعة الحساب</label>
                            <input name="remember_review_balance" @if($person->remember_review_balance) checked @endif type="checkbox" class="flat-red ">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input readonly name="remember_date" type="text" value="{{($person->remember_date)?:''}}"  id="datepicker" class="form-control">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
        </form>
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    الملخص
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered dataTableTT">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('front.Employee')</th>
                            <th>@lang('front.title')</th>
                            <th>@lang('front.Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($person->support as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{optional($item->user)->name}}</td>
                            <td>{{$item->comment}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@stop
@push('js')
    <script>
        $('#datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",

        });
    </script>
@endpush
