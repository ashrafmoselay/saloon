
<div class="row hideprint" style="margin-top: 10px;">
    <div class="col-md-12">
        <form action="" method="get">
            <div class="col-md-3">
                <div class="form-group ">
                    <input id="keyword" placeholder="الاسم او رقم الموبيل" autocomplete="off" style="direction: rtl;" name="keyword" value="{{request()->keyword}}" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group ">
                    <input id="fromdate" placeholder="@lang('front.datefrom')" autocomplete="off" style="direction: rtl;" name="fromdate" value="{{request()->fromdate}}" type="text" class="form-control datepicker">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input id="todate" placeholder="@lang('front.dateto')" autocomplete="off" style="direction: rtl;" name="todate" value="{{request()->todate}}" type="text" class="form-control datepicker">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select id="status" name="status" class="form-control">
                        <option value="">@lang('front.all')</option>
                        @foreach($statusList as $status)
                        <option {{request('status')==$status?'selected':''}} value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select id="employee_id" data-placeholder="@lang('front.all')" name="employee_id" class="form-control select2 " style="width:100%;">
                        <option value="">@lang('front.all')</option>
                        @foreach($employees as $id=>$name)
                            <option {{request('employee_id')==$id?'selected':''}} value="{{$id}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select id="product_id" data-placeholder="@lang('front.all')" name="product_id" class="form-control select2 " style="width:100%;">
                        <option value="">@lang('front.all')</option>
                        @foreach($products as $id=>$name)
                            <option {{request('product_id')==$id?'selected':''}} value="{{$id}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button  type="submit" class="btn btn-primary form-control"><i class="fa fa-search"></i> @lang('front.search')</button>
            </div>


        </form>
    </div>
</div>
@push('js')
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",
        });
        $(".select2").select2({allowClear: true});
    </script>
@endpush
