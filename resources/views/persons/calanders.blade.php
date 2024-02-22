@extends('layouts.app')
@section('title',trans('front.Installments'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.Installments')
         </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div style="margin-bottom: 5px;" class="row hideprint">
            <form action="">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <select name="filter1" id="category_id" class="form-control select2" style="width: 100% !important;height: 35px !important;">
                            <option value="">@lang('front.all')</option>
                            <option {{request('filter1')=='delayed'?'selected':''}}  value="delayed">@lang('front.Late installments')</option>
                            <option {{request('filter1')=="paid"?'selected':''}}  value="paid">@lang('front.Installments paid')</option>
                            <option {{request('filter1')=="notpaid"?'selected':''}}  value="notpaid">@lang('front.Unpaid installments')</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <input placeholder="@lang('front.from')" autocomplete="off" style="direction: rtl;" name="fromdate" value="{{request()->fromdate}}" type="text" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input placeholder="@lang('front.dateto')" autocomplete="off" style="direction: rtl;" name="todate" value="{{request()->todate}}" type="text" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" style="width: 200px; " type="button" class="btn btn-info btn-flat">@lang('front.search')</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="dataList" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('front.name')</th>
                                <th>@lang('front.date')</th>
                                <th>@lang('front.value')</th>
                                <th>@lang('front.paid')</th>
                                <th class="no-sort"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($calanders as $cal)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$cal->order->client->name}}</td>
                                    <td>{{$cal->date}}</td>
                                    <td>{{$cal->value}}</td>
                                    <td>{!! $cal->is_paid?'<span class="btn btn-success"><i class="fa fa-check"></i></span>':'<span class="btn btn-danger"><i class="fa fa-times"></i></span>' !!}</td>
                                    <td class="actions">
                                        @if(!$cal->is_paid)
                                        <a data-toggle="modal" data-target="#myModal" href="{{route('persons.addPayment',['person'=>$cal->order->client,'calanderId'=>$cal->id])}}" class="btn btn-success btn-xs">
                                            <i class="fa fa-money fa-fw" aria-hidden="true"></i>
                                            تحصيل
                                        </a>
                                        @endif
                                        <a class="btn btn-xs btn-danger remove-record" data-url="{{ route('deleteInstalment',$cal)  }}" data-id="{{$cal->id}}">
                                            <i class="fa fa-trash"></i>
                                            @lang('front.delete')
                                        </a>

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
    </section>
    <!-- /.content -->
    <div id="myModal" class="modal fade" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p class="text-center"><div class="fa-3x text-center"><i class="fa fa-cog fa-spin"></i>                    جارى التحميل ....                </div>                </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",
        });
    </script>
@endpush
