@php
    $checkqty = $settings['can_order_unavilable_qty'] ?: 2;
@endphp
<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label>رقم الشحنة</label>
                    @php
                        $shipmentNum = $shipment->id;
                        if(!$shipmentNum){
                            $shipmentNum = \App\Shipment::max('id')+1;
                        }
                    @endphp
                    <input value="{{$shipmentNum}}" readonly  type="text" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>@lang('front.date')</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input required readonly name="shipment[created_at]" type="text" value="{{($shipment->created_at)?$shipment->created_at->format('Y-m-d'):(old('shipment')['created_at']??date('Y-m-d'))}}" id="datepicker" class="form-control">
                    </div>
                    <!-- /.input group -->
                </div>
                <div class="form-group col-md-3">
                    <label>مكتب الشحن</label>
                    <input value="{{(isset(old('shipment')['shipping_office']))?old('shipment')['shipping_office']:$shipment->shipping_office}}" name="shipment[shipping_office]" type="text" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>تكلفة الشحن للعميل</label>
                    <input id="shipping_cost" step="any" type="number" class="form-control">
                </div>
            </div>
            @if(isset($settings['use_two_shipping_cost']) && $settings['use_two_shipping_cost']==1)
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>تكلفة الشحن لمكتب الشحن</label>
                        <input id="shipping_cost2" step="any" type="number" class="form-control">
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="form-group col-md-6">
                    <label>رقم المتابعة</label>
                    <input value="{{(isset(old('shipment')['follow_up_mobile']))?old('shipment')['follow_up_mobile']:($shipment->follow_up_mobile?:($settings['FollowMobiles']??''))}}" required name="shipment[follow_up_mobile]" type="text" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>حالة الشحنة</label>
                    @php
                        $statusList = ['تأجيل','لم يتم التسليم','تم التسليم','معلقة'];
                    @endphp
                    <select name="shipment[shipping_status]" class="form-control">
                        @foreach($statusList as $status)
                            <option {{(isset(old('shipment')['shipping_office']) && old('shipment')['shipping_status']==$status) || ($shipment->shipping_status==$status)?'selected':''}} value="{{$status}}">{{$status}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row shipmentCompany">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>
                            الشركة
                            <a href="#" class="clearItem">
                                <i class="fa fa-eraser"></i>
                            </a>
                        </label>

                        <div class="input-group">
                            <select data-ajax--url="{{route('companies.index')}}" data-ajax--cache="true" data-placeholder="@lang('front.select')" id="companyList"  class="form-control select2">
                                <option data-mobile="" value="">@lang('front.select')</option>
                            </select>
                            <div class="input-group-addon no-print" style="padding: 2px 5px;">
                                <a href="{{route('companies.create')}}?fromshipment=1" class="external" data-toggle="modal" data-target="#addPersonModal">
                                    <i class="fa fa-2x fa-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>
                        اسم العميل
                        <a href="#" class="clearItem2">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </label>
                    <input id="client_name" type="text" class="form-control needClear">
                </div>
                <div class="form-group col-md-3">
                    <label>الموبيل</label>
                    <input id="client_mobile" type="text" class="form-control needClear">
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>@lang('front.region')</label>
                        <select id="regionList" class="form-control" style="width: 100%;">
                            <option value="">@lang('front.select region')</option>
                            @foreach(\App\Region::get() as $region)
                                <option value="{{$region->id}}">{{$region->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label>العنوان</label>
                    <input id="client_address" type="text" class="form-control needClear">
                </div>
                <div class="form-group col-md-2">
                    <label>ملحوظة</label>
                    <input id="note" value="" type="text" class="form-control needClear" >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="">@lang('front.store')</label>
                    <select id="productStores" class="form-control storeList" required="required">
                        @foreach(auth()->user()->stores as $s)
                            <option value="{{$s->id}}">{{$s->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>@lang('front.product')</label>
                    <input name="search_input" autocomplete="off" class="typeahead form-control selectProduct" type="text">
                    <input type="hidden" value="" id="productID">
                    <input type="hidden" value="" id="productName">
                    <i class="fa fa-circle-o-notch fa-spin loader hide"></i>
                </div>
                <div class="form-group col-md-2">
                    <label for="">السعر</label>
                    <div class="input-group">
                        <input id="unitPrice" autocomplete="off" class="form-control" type="text">
                        <input id="unitCost" type="hidden">
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label>@lang('front.quantity')</label>
                    <input style=" min-width: 120px; " id="productQty" value="1" min="0"  step="any" type="number" class="form-control qty" >
                </div>
                <div class="form-group col-md-2">
                    <label>اللون</label>
                    @if(isset($settings['use_color_size_qty']) && $settings['use_color_size_qty']==1)
                        <select id="productColor" class="form-control combinationsList">
                            <option value="">---</option>
                            @foreach(\App\Combination::latest()->get() as $combin)
                                <option value="{{$combin->id}}">{{$combin->title}}</option>
                            @endforeach
                            <option class="allcolor" value="m">كل الألوان - M</option>
                            <option class="allcolor" value="l">كل الألوان - L</option>
                            <option class="allcolor" value="xl">كل الألوان - XL</option>
                            <option class="allcolor" value="xxl">كل الألوان - XXL</option>
                            <option class="allcolor" value="xxxl">كل الألوان - 3XL</option>
                            <option class="allcolor" value="4xl">كل الألوان - 4XL</option>
                            <option class="allcolor" value="دستة">دستة</option>
                            <option class="allcolor" value="سريا">سريا</option>

                        </select>
                    @else
                        <input style=" min-width: 120px; " id="productColor" value="" type="text" class="form-control" >
                    @endif
                </div>
            </div>
            <div class="row">
                <div style="overflow: auto;" class="col-md-12">
                    <table class="table table-bordered table-responsive">
                    <thead>
                    <tr style=" background: #5d7e8e; color: #ffffff;">
                        <th class="fit">#</th>
                        <th class="shipmentCompany">الشركة</th>
                        <th class="fit">العميل</th>
                        <th class="fit">العنوان</th>
                        <th class="fit">الموبيل</th>
                        <th class="fit">الصنف</th>
                        <th class="fit">اللون</th>
                        <th class="fit">ملحوظة</th>
                        <th class="fit">العدد</th>
                        <th class="fit">السعر</th>
                        <th class="fit">الشحن</th>
                        <th class="fit">الإجمالى</th>
                        @if($shipment->id)
                        <th class="fit">المرتجع</th>
                        <th class="fit">الحالة</th>
                        @endif
                        <th class="shipmentCompany">غرامة</th>
                        <th class="fit"></th>
                    </tr>
                    </thead>
                    <tbody id="invoiceTable">
                        @php
                            $productsListIds=[];
                            $num=0;
                        @endphp
                        @foreach($shipment->details->groupBy('client_mobile') as $details)
                            @php
                                $i = $loop->iteration;
                            @endphp
                            @foreach($details as $prod)
                                @php
                                    $num++;
                                    $rowClass = "rowelement".$prod->id.'_'.$prod->store_id.'_'.$prod->client_mobile;
                                    $productsListIds[]=$prod->product_id;
                                @endphp
                                <tr class="{{$rowClass}} bg-success">
                                    @if($loop->iteration==1)
                                        <td rowspan="{{count($details)}}">
                                            {{$i}}
                                        </td>
                                    @endif
                                    <td class="shipmentCompany">
                                        <input type="hidden" class="rowIndex" value="{{$num}}">
                                        <input autocomplete="off" type="hidden" name="product[{{$num}}][sender_id]" value="{{$prod->sender_id}}">
                                        <input autocomplete="off" type="hidden" name="product[{{$num}}][sender]" value="{{$prod->sender}}">
                                        <input autocomplete="off" type="hidden" name="product[{{$num}}][region_id]" value="{{$prod->region_id}}">

                                        {{$prod->sender}}
                                    </td>
                                    <td>
                                        <input autocomplete="off" class="tdinput" type="text" name="product[{{$num}}][client_name]" value="{{$prod->client_name}}">
                                    </td>
                                    <td><input autocomplete="off" class="tdinput" type="text" name="product[{{$num}}][client_address]" value="{{$prod->client_address}}"></td>
                                    <td><input autocomplete="off" class="tdinput" type="text" name="product[{{$num}}][client_mobile]" value="{{$prod->client_mobile}}"></td>
                                    <td>
                                        <input type="hidden" name="product[{{$num}}][store_id]" value="{{$prod->store_id}}">
                                        <input type="hidden" name="product[{{$num}}][cost]" value="{{$prod->cost}}">
                                        <input type="hidden" name="product[{{$num}}][product_name]" value="{{optional($prod->product)->name}}">
                                        <input type="hidden" name="product[{{$num}}][combination_id]" value="{{$prod->combination_id}}">

                                        <input type="hidden" name="product[{{$num}}][product_id]" value="{{$prod->product_id}}">{{optional($prod->product)->name}}
                                    </td>
                                    <td>
                                        <input class="tdinput" type="text" name="product[{{$num}}][color]" value="{{$prod->color}}">
                                    </td>
                                    <td>
                                        <input class="tdinput" type="text" name="product[{{$num}}][note]" value="{{$prod->note}}">
                                    </td>

                                    <td><input {{$prod->status=='مستلم' && $checkqty==2?'readonly':''}}  autocomplete="off" class="itemQty tdinput" type="text" name="product[{{$num}}][qty]" value="{{$prod->qty}}"></td>
                                    <td><input autocomplete="off" class="itemPrice tdinput" min="0"  step="any" type="number" name="product[{{$num}}][price]" value="{{$prod->price}}"></td>
                                    <td><input autocomplete="off" class="shipping_cost tdinput" step="any" type="number" name="product[{{$num}}][shipping_cost]" value="{{$prod->shipping_cost}}"></td>
                                    <td>
                                        @php
                                            $total = (($prod->qty - $prod->returned_qty) * $prod->price) + $prod->shipping_cost;
                                        @endphp
                                        <input class="itemTotal tdinput" type="number" step="any" name="product[{{$num}}][total]" value="{{$total}}">
                                    </td>
                                    @if($shipment->id)
                                    <td>
                                        <input {{$prod->status=='مستلم' && $checkqty==2?'readonly':''}} autocomplete="off" class="returned_qty tdinput" min="0" step="any" type="number" name="product[{{$num}}][returned_qty]" value="{{$prod->returned_qty}}">
                                    </td>
                                    <td>
                                        @if($prod->status=='مستلم' && $checkqty==2)
                                            <input type="hidden" value="مستلم" name="product[{{$num}}][status]">
                                        @endif
                                        <select class="itemStatusList" {{$prod->status=='مستلم' && $checkqty==2?'disabled':''}}  name="product[{{$num}}][status]">
                                        
                                            <option value="">----</option>
                                            @foreach ($prodStatusList as $pstatus)
                                                <option {{$prod->status==$pstatus?'selected':''}} class="{{ $pstatus=='تفاوض'?'tfawdshow':'' }}" value="{{ $pstatus }}" >{{ $pstatus }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @endif
                                    <td class="shipmentCompany">
                                        <input class="tdinput" type="text" name="product[{{$num}}][fee]" value="{{$prod->fee}}">
                                    </td>
                                    <td>
                                        @if($prod->status!='مستلم')
                                            <a rel="{{$prod->id}}" href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        @endif
                                        @if(auth()->user()->can('Transfer ShipmentsController'))
                                            <a data-toggle="modal" data-target="#myModal" title="نقل هذا الصنف الى شحنة أخرى" href="{{route('shipments.transfer',$prod->id)}}" class="btn btn-sm btn-warning transferItem"><i class="fa fa-copy"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                        @if(old('product'))
                            @foreach(old('product') as $oldProd)
                                @php
                                    $rowClass = "rowelement".$oldProd['product_id'].'_'.$oldProd['client_mobile'];
                                @endphp
                                @if(empty($productsListIds) || (!empty($productsListIds) && !in_array($oldProd['product_id'],$productsListIds))){
                                <tr class="{{$rowClass}} bg-success">
                                    <td>
                                        <input type="hidden" class="rowIndex" value="{{$loop->iteration}}">
                                        {{$loop->iteration}}
                                    </td>
                                    <td>
                                        <input autocomplete="off" type="hidden" name="product[{{$loop->iteration}}][sender_id]" value="{{$oldProd['sender_id']}}">
                                        <input autocomplete="off" type="hidden" name="product[{{$loop->iteration}}][sender]" value="{{$oldProd['sender']}}">
                                        <input autocomplete="off" type="hidden" name="product[{{$loop->iteration}}][region_id]" value="{{$oldProd['region_id']}}">
                                        {{$oldProd['sender']}}
                                    </td>
                                    <td>
                                        <input autocomplete="off" class="tdinput" type="text" name="product[{{$loop->iteration}}][client_name]" value="{{$oldProd['client_name']}}">
                                    </td>
                                    <td><input autocomplete="off" class="tdinput" type="text" name="product[{{$loop->iteration}}][client_address]" value="{{$oldProd['client_address']}}"></td>
                                    <td><input autocomplete="off" class="tdinput" type="text" name="product[{{$loop->iteration}}][client_mobile]" value="{{$oldProd['client_mobile']}}"></td>
                                    <td>
                                        <input type="hidden" name="product[{{$loop->iteration}}][store_id]" value="{{$oldProd['store_id']}}">
                                        <input type="hidden" name="product[{{$loop->iteration}}][cost]" value="{{$oldProd['cost']}}">
                                        <input type="hidden" name="product[{{$loop->iteration}}][product_name]" value="{{$oldProd['product_name']}}">
                                        <input type="hidden" name="product[{{$loop->iteration}}][combination_id]" value="{{$oldProd['combination_id']}}">
                                        <input type="hidden" name="product[{{$loop->iteration}}][product_id]" value="{{$oldProd['product_id']}}">{{$oldProd['product_name']}}
                                    </td>

                                    <td>
                                        <input class="tdinput" type="text" name="product[{{$loop->iteration}}][color]" value="{{$oldProd['color']}}">
                                    </td>
                                    <td>
                                        <input class="tdinput" type="text" name="product[{{$loop->iteration}}][note]" value="{{$oldProd['note']}}">
                                    </td>
                                    <td><input autocomplete="off" class="itemQty tdinput" type="text" name="product[{{$loop->iteration}}][qty]" value="{{$oldProd['qty']}}"></td>
                                    <td><input autocomplete="off" class="itemPrice tdinput" min="0"  step="any" type="number" name="product[{{$loop->iteration}}][price]" value="{{$oldProd['price']}}"></td>
                                    <td><input autocomplete="off" class="shipping_cost tdinput" min="0"  step="any" type="number" name="product[{{$loop->iteration}}][shipping_cost]" value="{{$oldProd['shipping_cost']}}"></td>
                                    <td>
                                        @php
                                            $total = (($oldProd['qty'] - ($oldProd['returned_qty']??0)) * $oldProd['price']) + $oldProd['shipping_cost'];
                                        @endphp
                                        <input class="itemTotal tdinput" type="number" step="any" name="product[{{$loop->iteration}}][total]" value="{{$total}}">
                                    </td>
                                    <td>
                                        <input autocomplete="off" class="returned_qty tdinput" min="0" step="any" type="number" name="product[{{$loop->iteration}}][returned_qty]" value="{{$oldProd['returned_qty']??0}}">
                                    </td>
                                    <td>
                                        <select class="itemStatusList" name="product[{{$loop->iteration}}][status]">
                                            <option value="">----</option>
                                            @foreach ($prodStatusList as $pstatus)
                                                <option {{isset($oldProd['status']) && $oldProd['status']==$pstatus?'selected':''}} class="{{ $pstatus=='تفاوض'?'tfawdshow':'' }}" value="{{ $pstatus }}" >{{ $pstatus }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="shipmentCompany">
                                        <input class="tdinput" type="text" name="product[{{$loop->iteration}}][fee]" value="{{$oldProd['fee']??0}}">
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endif
                        </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="box-footer" style="position: absolute;top: -55px;background: none;{{(\Session::get ('locale') == 'ar')?'left: 15px;':'right:15px;'}}">
            <button type="submit" class="btn btn-primary "><i class="fa fa-save"></i> @lang('front.save') </button>
        </div>
    </div>
</section>
@push('css')
    <style>

        .clearItem .fa.fa-eraser:hover,.clearItem2 .fa.fa-eraser:hover{
            font-size:2em;
            transition: .1s ease-in-out;
        }
        .loader{
            position: relative;
            float: left;
            top: -25px;
            z-index: 1070;
            color: #3c8dbc;
            font-size: 30px!important;
            left: 0px;
        }
        .table tr th,.table tr>td{
            vertical-align: middle!important;
            text-align: center;
            font-weight: bold;
        }
        .typeahead {
            z-index: 1051;
            direction: rtl;
        }
        .twitter-typeahead {
            width: 100%;
            height: 28px;
        }
        .tt-query {
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }
        .tt-hint {
            color: #999
        }
        .tt-menu {    /* used to be tt-dropdown-menu in older versions */
            width: 100%;
            margin-top: 2px;
            padding: 4px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
            -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
            box-shadow: 0 5px 10px rgba(0,0,0,.2);
        }
        .tt-suggestion {
            padding: 3px 20px;
            line-height: 24px;
            direction: rtl;
        }
        .tt-suggestion.tt-cursor,.tt-suggestion:hover {
            color: #fff;
            background-color: #0097cf;

        }
        .tt-suggestion p {
            margin: 0;
        }
        input.tdinput:focus{
            background-color: #fff!important;
            width: 300px;
            font-weight: bold;
            font-size: 16;
            border: 1px solid #f39c12!important;
        }
        input.tdinput {
            display: block;
            width: 100%;
            height: 28px;
            padding: 0;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #dff0d8;
            border: 0px solid #fff;
            border-radius: 4px;
            border: 0px solid #fff;
            text-align: center;
        }
        .allcolor{
            display: none!important;
        }
    </style>
@endpush
@push('js')
    <script>
        $('#datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",

        });
        $(".select2").select2();
        $('form').validator();
        $('form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        var units = [[]];
        var unitsPrice = [[]];
        var unitsCost = [[]];
        var $typeaheadSearch = $('.typeahead');
        $typeaheadSearch.on('typeahead:select', function (e, suggestion) {
            $("#productName").val(suggestion.name);
            $('#productID').val(suggestion.id);
            $("#productName").val(suggestion.name);
            var price;
            var cost = '';
            @if(isset($settings['use_color_size_qty']) && $settings['use_color_size_qty']==1)
                $('#productColor > option').each(function(){
                    if(!$(this).hasClass('hide') && $(this).val() && !$(this).hasClass('allcolor')){
                        $(this).addClass('hide');
                    }
                });
                suggestion.product_combination.map(function(item){
                    $("#productColor option[value='" + item.id + "']").removeClass('hide');
                });
            $("#productColor option:not('.hide'):last").prop('selected',true);
            @endif
            suggestion.product_unit.map(function(item) {
                price = item.pivot.sale_price;
                cost = item.pivot.cost_price;
            });
            $("#unitPrice").val(price);
            $("#unitCost").val(cost);
            $('#productQty').focus();
            $('#productQty').select();
        });
        function detectMob() {
            return ( ( window.innerWidth <= 800 ) && ( window.innerHeight <= 600 ) );
        }
        $typeaheadSearch.typeahead({highlight: true}, {
            name: 'products',
            limit:10,
            display: function(suggestion){
                return suggestion.name;
            },
            source: new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: "{{route('products.getProductList')}}",
                    prepare: function (query, settings) {
                        $('.loader').removeClass('hide');
                        settings.url = "{{route('products.getProductList')}}" + '?q=' + query
                            +'&store_id='+$('#productStores').val();
                            return settings;
                    },
                    filter: function (data) {
                        $('.loader').addClass('hide');
                        return data;
                    }
                }
            }),
            templates: {
                empty:"<div class='empty s-row s-header'>لا توجد نتائج للبحث</div>",
                header:function(){
                    return '  <div class="s-row s-header">\n' +
                        '                    <div class="s-cell">#</div>\n' +
                        '                    <div class="s-cell {{$settings["showImage"]==2?"hide":""}}">الصورة</div>\n' +
                        '                    <div class="s-cell">الصنف</div>\n' +
                        '                    <div class="s-cell {{$settings["show_category_in_invoice"]==2?"hide":""}}">الفئة</div>\n' +
                        '                    <div class="s-cell {{$settings['show_cost_price']==2?'hide':''}} ">التكلفة</div>\n' +
                        '                    <div class="s-cell">البيع</div>\n' +
                        '                    <div class="s-cell">الكمية</div>\n' +
                        '                </div>';
                },
                suggestion: function(suggestion) {
                    var price = "";
                    var cost = "";
                    suggestion.product_unit.map(function(item) {
                        price = item.pivot.sale_price;
                        if(parseFloat(item.pivot.cost_price))
                            cost = item.cost_price;
                    });
                    @if($settings['rounding_up']==1)
                    if($('#invoiceType').val()=='sales')
                        price = Math.ceil(price);
                    @endif
                    var avilable = "";
                    var q = 0;
                    $.each(suggestion.product_store, function( index, item ) {
                        q = parseFloat(item.pivot.qty - item.pivot.sale_count).toFixed(1);
                        avilable += item.name+" : "+(q)+"<br/>";
                    });
                    return '  <div class="s-row">\n' +
                        '                    <div class="s-cell">'+suggestion.id+'</div>\n' +
                        '                    <div class="s-cell {{$settings["showImage"]==2?"hide":""}}"><img style="width:80px;" src="'+suggestion.img+'"/></div>\n' +
                        '                    <div class="s-cell">'+suggestion.name+'</div>\n' +
                        '                    <div class="s-cell {{$settings["show_category_in_invoice"]==2?"hide":""}}">'+suggestion.category.name+'</div>\n' +
                        '                    <div class="s-cell {{$settings["show_cost_price"]==2?"hide":""}}">'+cost+'</div>\n' +
                        '                    <div class="s-cell">'+price+'</div>\n' +
                        '                    <div class="s-cell">'+avilable+'</div>\n' +
                        '                </div>';
                }
            }
        });
        $(document).on('keydown','input.typeahead', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                addRow();
                return false;
            }
        });
        $(document).on('keydown','input.qty,#productColor', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                addRow();
            }
        });
        $('input.qty').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                addRow();
            }
        });

        $(document).on("change",".itemTotal",function(e) {
            var row = $(this).closest('tr');
            var total = $(this).val();
            var qty = row.find(".itemQty").val();
            var shippingCost = row.find(".shipping_cost").val();
            var unitPrice = 0;
            if (typeof returned_qty === "undefined"){
                returned_qty = 0;
            }
            qty = parseInt(qty) - parseInt(returned_qty);
            total = parseFloat(total) - parseInt(shippingCost);
            var unitPrice = total / parseFloat(qty);
            row.find(".itemPrice").val(unitPrice.toFixed(2));
        });
        $(document).on("change",".itemQty,.itemPrice,.shipping_cost,.returned_qty",function(e){
            var row = $(this).closest('tr');
            var qty = row.find(".itemQty").val();
            var returned_qty = row.find(".returned_qty").val();
            var itemPrice = row.find(".itemPrice").val();
            var shippingCost = row.find(".shipping_cost").val();
            if (typeof returned_qty === "undefined" || !returned_qty){
                returned_qty = 0;
            }
            //if(returned_qty){
                qty = parseInt(qty) - parseInt(returned_qty);
            //}
            var total = (parseFloat(qty) * parseFloat(itemPrice))+parseInt(shippingCost);
            //console.log(total);
            //total = Math.round(total);
            row.find(".itemTotal").val(total.toFixed(2));
            var cost = row.find(".itemCost").val();
            if(parseFloat(cost)>parseFloat(itemPrice)){
                row.removeClass('bg-success');
                row.addClass('bg-danger');
            }else{
                row.removeClass('bg-danger');
                row.addClass('bg-success');
            }
            row.find(".itemTotal").val(total);
            //calculateTotal();
        });
        $(document).on("click",".btn-danger",function(e){
            e.preventDefault();
            if($(this).attr('rel')!==undefined){
                $(this).closest('form').append("<input value='"+$(this).attr('rel')+"' type='hidden' name='itemToDelete[]'/>");
            }
            $(this).closest('tr').remove();
        });
        $(document).on("click",".clearItem",function(e){
            e.preventDefault();
            $(".needClear").each(function() {
                $(this).val("");
            });
            $("#companyList").empty();
        });
        $(document).on("click",".clearItem2",function(e){
            e.preventDefault();
            $(".needClear").each(function() {
                $(this).val("");
            });
        });
        $(document).on("change",".itemStatusList",function(e){
            var row = $(this).closest('tr');
            var itemQty = 0
            if($(this).val()=="مرتجع") {
                itemQty = row.find(".itemQty").val();
            }
            row.find(".returned_qty").val(itemQty)
        });
        function addRow(){
            var company = $("#companyList");
            var sender_id = company.val();
            var sender = "";
            if(sender_id)
                sender = company.find("option:selected").text();
            var productName = $("#productName").val();
            var productID= $("#productID").val();
            var client_name= $("#client_name").val();
            var client_mobile= $("#client_mobile").val();
            var client_address= $("#client_address").val();
            var region_id= $("#regionList").val();
            var shipping_cost = $("#shipping_cost").val();
            var productColor = $("#productColor").val();
            var combination_id = "";
            @if(isset($settings['use_color_size_qty']) && $settings['use_color_size_qty']==1)
                productColor = $("#productColor option:selected").text();
                combination_id = $("#productColor option:selected").val();
            @endif
            var note = $("#note").val();

            if($("#invoiceTable").find('input[value="'+client_mobile+'"]').length){
                shipping_cost = 0;
            }
            if(!shipping_cost) shipping_cost=0;
            if(!productID){
                swal({
                    title:'خطأ', text:"يجب اختيار الصنف",type:"error",confirmButtonText: "تمام",
                });
                return false;
            }
            if(!client_mobile || !client_address || !client_name){
                swal({
                    title:'خطأ', text:"يجب كتابة بيانات العميل الاسم - التليفون - العنوان",type:"error",confirmButtonText: "تمام",
                });
                return false;
            }
            var unitPrice= parseFloat($("#unitPrice").val());
            var cost= parseFloat($("#unitCost").val());
            var productQty= parseFloat($("#productQty").val());
            if(isNaN(productQty)){
                swal({
                    title:'خطأ فى إدخال الكمية', text:"يجب ان تكون الكمية رقم وليس حروف",type:"error",confirmButtonText: "تمام",
                });
                return false;
            }
            var total = (unitPrice * productQty)+parseInt(shipping_cost);
            total = parseFloat(total).toFixed(2);
            var productName = $("#productName").val();
            var storeName = $("#productStores option:selected").text();
            var store_id = $("#productStores option:selected").val();
            var rowClass = "rowelement"+productID+'_'+client_mobile+"_"+combination_id;
            if($('#invoiceTable tr').length){
                num = parseInt($(".rowIndex:last").val())+1;
            }else{
                var num = $('#invoiceTable tr').length+1;
            }
            if($('.'+rowClass).length) {
                swal({
                    title:'خطأ', text:"الصنف مسجل بالفعل لهذا العميل",type:"error",confirmButtonText: "تمام",
                });
                $('.'+rowClass).find(".itemQty").focus();
                $('.'+rowClass).find(".itemQty").select();
                return false;
            }
            var data = '<td>'+
                '<input type="hidden" class="rowIndex" value="'+num+'">'+
                num+
                '</td>' +
                '<td class="shipmentCompany">' +
                '<input autocomplete="off"  type="hidden" name="product['+num+'][sender_id]" value="'+sender_id+'">' +
                '<input autocomplete="off"  type="hidden" name="product['+num+'][region_id]" value="'+region_id+'">' +
                '<input autocomplete="off"  type="hidden" name="product['+num+'][sender]" value="'+sender+'">'+sender+'</td>' +
                '<td><input autocomplete="off" required class="tdinput" type="text" name="product['+num+'][client_name]" value="'+client_name+'"></td>' +
                '<td><input autocomplete="off" required class="tdinput" type="text" name="product['+num+'][client_address]" value="'+client_address+'"></td>' +
                '<td><input autocomplete="off" required class="tdinput" type="text" name="product['+num+'][client_mobile]" value="'+client_mobile+'"></td>' +
                '<td>' +
                '<input type="hidden" name="product['+num+'][store_id]" value="'+store_id+'">'+
                '<input type="hidden" class="itemCost" name="product['+num+'][cost]" value="'+cost+'">'+
                '<input type="hidden" name="product['+num+'][product_name]" value="'+productName+'">'+
                '<input type="hidden" name="product['+num+'][combination_id]" value="'+combination_id+'">'+
                '<input type="hidden" name="product['+num+'][product_id]" value="'+productID+'">'+productName+
                '</td>' +
                '<td><input autocomplete="off" class="tdinput" type="text" name="product['+num+'][color]" value="'+productColor+'"></td>' +
                '<td><input autocomplete="off" class="tdinput" type="text" name="product['+num+'][note]" value="'+note+'"></td>' +
            '<td><input autocomplete="off" class="itemQty tdinput" type="text" name="product['+num+'][qty]" value="'+productQty+'"></td>' +
            '<td><input autocomplete="off" class="itemPrice tdinput" step="any" type="number" name="product['+num+'][price]" value="'+unitPrice+'"></td>' +
            '<td><input autocomplete="off" class="shipping_cost tdinput" step="any" type="number" name="product['+num+'][shipping_cost]" value="'+shipping_cost+'"></td>' +
            '<td><input class="itemTotal tdinput" type="number" step="any" name="product['+num+'][total]" value="'+total+'"></td>';
            if($('.'+rowClass).length) {
                productQty += parseInt($('.' + rowClass).find('.itemQty').val());
            }
                var options = '';
                @foreach ($prodStatusList as  $statusItem)
                    options+='<option class="{{ $statusItem=="تفاوض"?"tfawdshow":"" }}" value="{{ $statusItem }}">{{ $statusItem }}</option>';
                @endforeach
                @if($shipment->id)
                    data += '<td><input autocomplete="off" class="returned_qty tdinput" step="any" type="number" name="product['+num+'][returned_qty]" value=""></td>' +
                    '<td><select class="itemStatusList" name="product['+num+'][status]"><option value="">---</option>'+options+'</select></td>';
                @endif
                data += '<td class="shipmentCompany"><input autocomplete="off" class="fee tdinput" step="any" type="number" name="product['+num+'][fee]" value=""></td>';
                data += '<td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>' ;
                if($('.'+rowClass).length){
                    $('.'+rowClass).html(data);
                }else{
                    $("#invoiceTable").append('<tr class="bg-success '+rowClass+'">' + data+ '</tr>');
                }
                //calculateTotal();
                toastr.success("تمت إضافة "+productQty+" "+" للصنف "+productName+" من "+storeName+" للفاتورة");
                $typeaheadSearch.typeahead('val','');
                $typeaheadSearch.focus();
                $("#unitPrice").val('');
                $("#productID").val('');
                $("#productQty").val(1);
                $("#CostPriceSpan").html('');
                return false;

        }

        function calculateTotal(){
            var grandtotal =0;
            $(".itemTotal").each(function() {
                grandtotal += parseFloat($(this).val());
            });
            var tax = parseFloat($("#tax").val());
            grandtotal += (grandtotal*(tax/100));
            grandtotal = parseFloat(grandtotal).toFixed(2);
            $("#total").val(grandtotal);
            if($('.use_pointInput').is(':checked')){
                var user_point = parseFloat($(".userpointSpan").html());
                var point_value = parseFloat("{{$settings['point_value']}}");
                var points = user_point*point_value;
                if(grandtotal>points){
                    $("#discount").val(points);
                }else{
                    $("#discount").val(grandtotal);
                }
            }
            $("#paid").trigger("input");
            /*var discountPercent = $("#discount_type").is(':checked');
            var discount = parseFloat($("#discount").val());

            var grandtotal = $("#total").val();
            if(discountPercent){
                discount = (grandtotal*(discount/100));
                grandtotal -= discount;
            }else{
                grandtotal -= discount;
            }
            $('#disValue').css('background-color', '#008d4c');
            $("#disValue").html(discount.toFixed(2));

            if($("#paymentMethod").val()=='delayed') {
                $("#paid").val(0);
                $("#due").val(grandtotal);
            }else{
                $("#due").val(0);
                $("#paid").val(grandtotal);
            }*/
            var lastBalance = 0;
            if($("#lastBalance").val()) {
                lastBalance = parseFloat($("#lastBalance").val());
            }

            var TotalBal = parseFloat($("#due").val()) + parseFloat(lastBalance);
            var totalBalance = TotalBal.toFixed(1);
            $("#totalBalance").val(totalBalance);
        }
    </script>
@endpush
