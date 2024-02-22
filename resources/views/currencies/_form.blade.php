<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.name')</label>
                            <input value="{{$currency->name??''}}" required name="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.code')</label>
                            <select style="width: 100%;" required class="form-control select2" name="code">
                                @foreach($currencyCode as $code)
                                    <option {{isset($currency) && $currency->code==$code?'selected':''}} value="{{$code}}">{{$code}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.symbol')</label>
                            <input placeholder="{{currency()->getCurrency()['symbol']??'ج.م'}}" value="{{$currency->symbol??''}}" required name="symbol" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.format')</label>
                            <input placeholder="1,0.00 {{currency()->getCurrency()['symbol']??'ج.م'}}" value="{{$currency->format??''}}" required name="format" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.exchange rate')</label>
                            <input value="{{isset($currency) ?1/$currency->exchange_rate:''}}" required name="exchange_rate" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.status')</label>
                            <select name="active" class="form-control select2" style="width: 100%;">
                                <option {{(isset($currency) && $currency->active==1)?'selected':''}} value="1">@lang('front.active')</option>
                                <option {{(isset($currency) && $currency->active==0)?'selected':''}}  value="0">@lang('front.notactive')</option>
                            </select>
                        </div>
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
</section>

<script>
    $(function () {
        $(".select2").select2();
        $('form').validator();
    });
</script>
