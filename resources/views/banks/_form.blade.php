@php
    $type = $bank->type?:$type;
@endphp
<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                @if($type==1)
                <div class="row">
                    <div class="col-md-4">
                        <input name="type" type="hidden" value="{{$bank->type?:$type}}">
                        <div class="form-group">
                            <label>@lang('front.bankname')</label>
                            <input value="{{$bank->name}}" required name="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('front.accountNumber')</label>
                            <input value="{{$bank->number}}" required name="number" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('front.currency')</label>
                            <select style="width: 100%" name="currency" class="form-control select2">
                            @foreach(currency()->getActiveCurrencies() as $currency)
                                <option  {{$bank->currency==$currency['code']?'selected':''}} value="{{$currency['code']}}">{{$currency['name']}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.balance')</label>
                            <input {{$bank->id?'readonly':''}}  value="{{$bank->balance}}" required name="balance" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.discountvisa')</label>
                            <div class="input-group">
                                <input value="{{$bank->percent}}" required name="percent" type="number" step="0.01"  class="form-control">
                                <div class="input-group-addon">
                                    <i class="fa fa-percent"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <input name="type" type="hidden" value="{{$bank->type?:$type}}">
                            <div class="form-group">
                                <label>@lang('front.name')</label>
                                <input value="{{$bank->name}}" required name="name" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('front.balance')</label>
                                <input {{$bank->id?'readonly':''}}    value="{{$bank->balance}}" required name="balance" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('front.currency')</label>
                                <select style="width: 100%" name="currency" class="form-control select2">
                                    @foreach(currency()->getActiveCurrencies() as $currency)
                                        <option  {{$bank->currency==currency()->getUserCurrency()?'selected':''}} value="{{$currency['code']}}">{{$currency['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
</section>
<script>
    $('form').validator();
    $(".select2").select2();
</script>
