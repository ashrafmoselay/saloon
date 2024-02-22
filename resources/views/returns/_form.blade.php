@if($type=='sales')
    <input name="order[currency]" type="hidden" value="{{$return->currency?:currency()->getUserCurrency()}}">
@endif
<input type="hidden" value="{{$type}}" name="order[return_type]">
<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                @php
                                    if($type=='sales'){
                                        $title = trans('front.client');
                                        $userListRoute= route('person.getList',['type'=>'client']);
                                        //$persons = \App\Person::where('type','client')->get();
                                        $salesMan = \App\Employee::where('type','sales')->get();
                                    }else{
                                        $title = trans('front.supplier');
                                        //$persons = \App\Person::where('type','supplier')->get();
                                        $route = route('supplier.create',['req'=>'ajax']);
                                        $userListRoute= route('person.getList',['type'=>'supplier']);
                                        $salesMan = [];
                                    }
                                @endphp
                                <label>
                                    {{$title}}
                                </label>
                                <div class="input-group">
                                    <input type="hidden" id="priceType" value="">
                                    <select data-ajax--url="{{$userListRoute}}" data-ajax--cache="true"  data-placeholder="@lang('front.select')" id="personList" name="order[client_id]" required class="form-control" style="width:100%;">
                                        <option data-mobile="" value="">@lang('front.select')</option>
                                        @if($return->client_id)
                                            @php
                                                $per = \App\Person::find($return->client_id);
                                            @endphp
                                            <option priceType="{{$per->priceType}}" rel="{{$per->total_due}}" selected value="{{$per->id}}">{{$per->name}}</option>
                                        @endif
                                        {{--@foreach($persons as $per)
                                            <option priceType="{{$per->priceType}}" rel="{{$per->total_due}}"  {{$per->id==$return->client_id?'selected':''}} value="{{$per->id}}">{{$per->name}}</option>
                                        @endforeach--}}
                                    </select>
                                    <div id="balanseDiv" class="input-group-addon"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('front.invoicenumber')</label>
                                <div class="input-group">
                                    <select @if($settings['subtract_payment_from_invoice']==1) required @endif id="order_id" class="form-control select2" name="order[order_id]">
                                        <option value="">@lang('front.A general return is not associated with an invoice')</option>
                                    </select>
                                    <span class="input-group-addon btn orderDetailsBtn">
                                        <a style="display: none;" data-toggle="modal" data-target="#addPersonModal" href="" class="btn btn-warning btn-xs orderLink">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="{{$type=='sales'?'col-md-4':'col-md-12'}}">
                            <div class="form-group">
                                <label>@lang('front.date')</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="order[return_date]" type="text" value="{{($return->return_date)?:date('Y-m-d')}}" class="form-control pull-right" id="datepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="{{($type=='sales')?'col-md-8':'hide'}}">
                            <input type="hidden" id="manager_id" name="order[manager_id]" value="{{optional($return->saleMan)->manager_id}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('front.sale')</label>
                                    <select data-placeholder="@lang('front.select')" name="order[sale_id]" class="form-control select2 salePersonSelect" style="width:100%;">
                                        <option value=""></option>
                                        @foreach($salesMan as $per)
                                            <option manager_id="{{$per->manager_id}}" {{$per->id==$return->sale_id?'selected':''}} value="{{$per->id}}">{{$per->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>@lang('front.salediscount')</label>
                                <div class="input-group">
                                <input id="sales_value" name="order[sales_value]" value="0" class="form-control">
                                <div style="padding: 0px;width: 100px;" class="input-group-addon">
                                    <input placeholder="%" id="sales_percent" value="{{$return->sales_value&&$return->return_value?round(($return->sales_value/$return->return_value)*100,2):''}}" class="form-control">
                                    <div style="display: inline-table;height: 33px;" class="input-group-addon">
                                        %
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
                <!-- /.row -->
                <div id="invoiceProductList" class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">@lang('front.store')</label>
                                <select id="productStores" class="form-control storeList select2" required="required">
                                    @foreach(\App\Store::get() as $s)
                                        <option value="{{$s->id}}">{{$s->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="{{$settings['show_category_in_invoice']==1?'col-md-2':'hide'}}">
                            <div class="form-group">
                                <label>@lang('front.parent')</label>
                                <select id="category_id" class="form-control select2" style="width: 100%;">
                                    <option value="">@lang('front.parent')</option>
                                    @foreach(\App\Category::where('type',1)->get() as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="{{$settings['show_category_in_invoice']==1?'col-md-3':'col-md-4'}}">
                            <div class="form-group">
                                <label for="">@lang('front.product')</label>
                                <input name="search_input" autocomplete="off" class="typeahead form-control" type="text">
                                <input type="hidden" value="" id="productID">
                                <input type="hidden" value="" id="productName">
                                <i class="fa fa-circle-o-notch fa-spin loader hide"></i>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">@lang('front.price')</label>
                                <input id="unitPrice" autocomplete="off" class="form-control" type="text">
                                <input id="unitCost" value="" type="hidden">

                            </div>
                        </div>
                        <div class="{{$settings['show_category_in_invoice']==1?'col-md-3':'col-md-4'}}">
                            <div class="form-group">

                                <label>@lang('front.quantity')</label>
                                <div class="input-group">
                                    <input style="min-width: 120px;" id="productQty" value="1" min="0" step="0.01" type="number" type="text" class="form-control qty" >
                                    <span style="width: 50px;" class="unit input-group-addon">
                                        <select id="unitList" class="form-control unitList" required style="width: 100%;">
                                            @foreach(\App\Unit::get() as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-8">
                        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('front.store')</th>
                            <th>@lang('front.product')</th>
                            <th>@lang('front.quantity')</th>
                            <th>@lang('front.price')</th>
                            <th>@lang('front.unit')</th>
                            <th>@lang('front.total')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="invoiceTable">
                    @foreach($return->details as $item)
                        @php
                            $rowClass = "rowelement".$item->id.'_'.$item->pivot->store_id.'_'.$item->pivot->unit_id;
                        @endphp
                        <tr class="{{$rowClass}} bg-success">
                            <td>
                                <input type="hidden" class="rowIndex" value="{{$loop->iteration}}">
                                <input type="hidden" name="product[{{$item->id}}][store_name]" value="{{$item->pivot->store_name}}">
                                <input type="hidden" name="product[{{$item->id}}][unit_name]" value="{{$item->pivot->unit_name}}">
                                <input type="hidden" name="product[{{$item->id}}][product_name]" value="{{$item->name}}">
                                <input type="hidden" name="product[{{$item->id}}][cost]" value="{{$item->pivot->cost}}">{{$loop->iteration}}
                            </td>
                            <td><input type="hidden" name="product[{{$item->id}}][store_id]" value="{{$item->pivot->store_id}}">{{$item->pivot->store_name}}</td>
                            <td><input type="hidden" name="product[{{$item->id}}][product_id]" value="{{$item->id}}">{{$item->name}}</td>
                            <td><input class="itemQty tdinput" type="text" name="product[{{$item->id}}][qty]" value="{{$item->pivot->qty}}"></td>
                            <td><input class="itemPrice tdinput" type="text" name="product[{{$item->id}}][price]" value="{{$item->pivot->price}}"></td>
                            <td><input type="hidden" name="product[{{$item->id}}][unit_id]" value="{{$item->pivot->unit_id}}">{{$item->pivot->unit_name}}</td>
                            <td>
                                <input class="itemTotal tdinput" readonly type="text" value="{{$item->pivot->price*$item->pivot->qty}}">
                            </td>
                            <td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                    </div>
                    <div class="col-md-4">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('front.tax')</label>
                                <input id="tax" name="order[tax]" value="{{old('order')['tax']??($order->tax ?? $settings['taxValue'])}}" class="form-control">                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('front.total')</label>
                                <input readonly id="grandtotal" name="order[total]" value="{{$return->total or 0}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('front.discount')</label>

                                <div class="input-group">
                                    <input required id="discount" name="order[discount]" value="{{$return->discount ?? 0}}" class="form-control">
                                    <span class="input-group-addon btn">
                                                    <input id="discount_type" name="order[discount_type]" @if($return->discount_type==2) checked @endif type="checkbox" class="flat-red ">
                                        %
                                        </span>
                                    <span style="color:#ffffff;background-color: #008d4c;" id="disValue" class="input-group-addon btn ">

                                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('front.balance')</label>

                                <div class="input-group">
                                    <input readonly id="total" name="order[return_value]" value="{{$return->return_value or 0}}" class="form-control">
                                    <span class="input-group-addon btn">
                                                                <input name="is_cash" @if($return->is_cash) checked @endif type="checkbox" class="flat-red ">
                                                            </span>
                                    <span class="input-group-addon btn">
                                                                @lang('front.isCash')
                                                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('front.Choose a safe')</label>
                                <select required name="bank_id" class="form-control ">
                                    @foreach(\App\Bank::where('id',auth()->user()->treasury_id)->get() as $bank)
                                        <option balance="{{$bank->balance}}"  value="{{$bank->id}}">{{$bank->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer" style="position: absolute;top: -55px;{{(\Session::get ('locale') == 'ar')?'left: 15px;':'right:15px;'}};background: none;">
                <button type="submit" class="btn btn-primary ">@lang('front.save')</button>
            </div>
        </div>
    </div>
</section>

@push('css')
    <style>
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
            border: 0px solid #fff!important;
            text-align: center;
        }
        div.dataTables_paginate {
            text-align: left;
        }
        #myModal .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #myModal .modal-content {
            height: auto;
            min-height: 100%;
            border: 0 none;
            border-radius: 0;
        }
        .typeahead {
            z-index: 1;
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
        .loader {
            position: relative;
            float: left;
            z-index: 10000;
            color: #3c8dbc;
            left:0!important;
            font-size: 30px!important;
            top: -26px;
        }

    </style>
@endpush
@push('js')
<script>
 
    function detectMob() {
        const isMobile = {
                Android: function() {
                    return navigator.userAgent.match(/Android/i);
                },
                BlackBerry: function() {
                    return navigator.userAgent.match(/BlackBerry/i);
                },
                iOS: function() {
                    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                },
                Opera: function() {
                    return navigator.userAgent.match(/Opera Mini/i);
                },
                Windows: function() {
                    return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
                },
                any: function() {
                    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                }
            };
            return  isMobile.any();
            //return ( ( window.innerWidth <= 800 ) && ( window.innerHeight <= 600 ) );
    }
    $(document).on("change",".itemQty,.itemPrice",function(e){
        var row = $(this).closest('tr');
        var qty = row.find(".itemQty").val();
        var itemPrice = row.find(".itemPrice").val();
        var total = parseFloat(qty) * parseFloat(itemPrice);
        row.find(".itemTotal").val(total.toFixed(2));
        calculateTotal();
    });
    $(".select2").select2();
    $("#personList").select2({
        minimumInputLength: 1
    });

    setTimeout("$('[name=search_input]').focus();",500);
    $('form').validator();

    $(document).on('ifChanged','#discount_type', function(){
        calculateTotal();
    });
    $(document).on("input","#discount",function(e){
        calculateTotal();
    });

    $("#discount_type").trigger("ifChanged");
    $('#datepicker').datepicker({
        autoclose: true,
        rtl: true,
        format: 'yyyy-mm-dd',
        language: "{{\Session::get('locale')}}",
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
    $(document).on("change","#personList",function(e) {
        e.preventDefault();
        var personId = $(this).val();
        /*var balance = $( "#personList option:selected" ).attr('rel');
        $("#balanseDiv").html(balance);*/
        if(!personId) return false;
        $.ajax({
            url: "{{route('getPersonInvoices')}}",
            data:{id:personId},
            type: 'GET',
            success: function (result) {
                var data = JSON.parse(result);
                $("#balanseDiv").html(data.balance);
                $("#order_id").find('option').not(':first').remove();
                $("#order_id").append(data.list);
                var order = "{{$return->order_id??''}}";
                $("#order_id").val(order);
                $("#priceType").val(data.priceType);
            }
        });
    });
    $(document).on("change","#order_id",function(e) {
        e.preventDefault();
        var orderId = $(this).val();
        if(orderId){
            $(".orderLink").show();
            var link = "{{ route('orders.show','ORDID') }}";
            link = link.replace("ORDID", orderId);
            $(".orderLink").attr('href',link);
        }
        var sale_id = $("#order_id option:selected" ).attr('sale_id');
        $(".salePersonSelect").val(sale_id).change();
    });

    $('#personList').trigger('change');
    var $typeaheadSearch = $('.typeahead');

    var units = [[]];
    $typeaheadSearch.on('typeahead:select', function (e, suggestion) {

        $("#unitList").attr('disabled',false);
        var max = suggestion.totalQty;
        console.log("totalQty "+max);
        var checkqty = parseInt("{{isset($settings['show_all_products_returns'])?$settings['show_all_products_returns']:1}}");
        if(checkqty ==1 ){
            $('#productQty').attr('max',max);
        }
        $('#productQty').val(1);
        $("#productName").val(suggestion.name);
        var price = suggestion.price;
        var cost = suggestion.cost;
        $('#unitList > option').each(function () {
            if (!$(this).hasClass('hide')) {
                $(this).addClass('hide');
            }
        });
        suggestion.product_unit.map(function (item) {
            $("#unitList option[value='" + item.id + "']").removeClass('hide');
        });
        if ($("#unitList option[value='" + $("#unitList").val() + "']").hasClass('hide')) {
            $("#unitList option:not('.hide'):last").prop('selected', true);
        }
        var selectedUnit = $('#unitList').val();
        suggestion.product_unit.map(function (item) {
           // $("#unitList option[value='" + item.id + "']").removeClass('hide');

            if (selectedUnit == item.id) {

                price = item.pivot.sale_price;
                cost = item.pivot.cost_price;
                priceType = $( "#priceType" ).val();
                if(priceType=="multi"){
                    price = item.pivot.gomla_price;
                }else if(priceType=="half"){
                    price = item.pivot.half_gomla_price;
                }else if(priceType=="gomla_gomla_price"){
                    price = item.pivot.gomla_gomla_price;
                }
            }
        });
        console.log(price);
        $('#invoiceProductList').find('#productID').val(suggestion.id);
        @if($type=='sales')
            $('#invoiceProductList').find('#unitPrice').val(price);
        @else
            $('#invoiceProductList').find('#unitPrice').val(cost);
        @endif
        $('#invoiceProductList').find('#unitCost').val(cost);
        $('#productQty').focus();
        $('#productQty').select();
        if(detectMob()) {
            addRow();
        }
    });


    $typeaheadSearch.typeahead({highlight: true}, {
        name: 'products',
        limit:25,
        display: function(suggestion){
            return suggestion.name;
        },
        source: new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: "{{route('products.getReturnsList')}}",
                prepare: function (query, settings) {
                    $('.loader').removeClass('hide');
                    settings.url = "{{route('products.getReturnsList')}}" + '?q=' + query
                        +'&client_id='+$('#personList').val()+'&category_id='+$('#category_id').val()+'&store_id='+$('#productStores').val();
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
                    if(parseFloat(item.pivot.sale_price))
                        price = item.pivot.sale_price;
                    if(parseFloat(item.pivot.cost_price))
                        cost = item.cost_price;
                });
                var avilable = "";
                var q = 0;
                $.each(suggestion.product_store, function( index, item ) {
                    q = parseFloat(item.pivot.qty - item.pivot.sale_count).toFixed(1);
                    avilable += item.name+" : "+(q)+"<br/>";
                });
                return '  <div class="s-row">\n' +
                    '                    <div class="s-cell">'+suggestion.id+'</div>\n' +
                    '                    <div class="s-cell">'+suggestion.name+'</div>\n' +
                    '                    <div class="s-cell {{$settings["show_category_in_invoice"]==2?"hide":""}}">'+suggestion.category.name+'</div>\n' +
                    '                    <div class="s-cell {{$settings["show_cost_price"]==2?"hide":""}}">'+cost+'</div>\n' +
                    '                    <div class="s-cell">'+price+'</div>\n' +
                    '                    <div class="s-cell">'+avilable+'</div>\n' +
                    '                </div>';
            }
        }
    });

    /*$(document).on('typeahead:rendered', function () {
        var code = $('input.typeahead.tt-input').val();
        if(code.length>10)
            $('.tt-selectable').first().click();
    });*/

    $(document).on("change","#productQty",function(e) {
        e.preventDefault();
        checkMaxQty();
    });
    $(document).on("change","#productStores,#unitList",function(e){
        e.preventDefault();
        if($('.tt-selectable').length){
            $('.tt-selectable:first').trigger('click');
        }
    });
    $('input.typeahead').on('keydown', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            return false;
        }
    });
    $('input.qty,#unitPrice').on('keydown', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            addRow();
        }
    });
    $(document).on("click",".btn-danger",function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        calculateTotal();
    });
    $(document).on("change","#sales_percent",function(e){
        e.preventDefault();
        calculateTotal();
    });

    function addRow(){

        if(!checkMaxQty()){
            return false;
        }
        var productID= $("#productID").val();
        if(!productID){
            return false;
        }
        var unitPrice= $("#unitPrice").val();
        var cost= $("#unitCost").val();
        var productQty= parseFloat($("#productQty").val());
        var total = unitPrice * productQty;
        total = parseFloat(total).toFixed(2);
        var unitName= $("#unitList option:selected").text();
        var unit_id= $("#unitList option:selected").val();
        var productName = $("#productName").val();
        var storeName = $("#productStores option:selected").text();
        var store_id = $("#productStores option:selected").val();
        var rowClass = "rowelement"+productID+'_'+store_id+'_'+unit_id;
        if($('.'+rowClass).length){
            productQty += parseInt($('.'+rowClass).find('.itemQty').val()) ;
            total = unitPrice * productQty;
            total = parseFloat(total).toFixed(2);
            num = $('.'+rowClass).index() +1;

            swal({
                    title: "تحذير! الصنف مكرر",
                    text: "هل تريد الإضافة عليه؟ ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD4140",
                    closeOnConfirm: true,
                    showLoaderOnConfirm: false,
                    cancelButtonText: "إلغاء",
                    confirmButtonText: "نعم متأكد",
                },
                function(){
                    var num = $('#invoiceTable tr').length+1;
                    var data ='<td>'+
                        '<input type="hidden" class="rowIndex" value="'+num+'">'+
                        '<input type="hidden" name="product['+productID+'][store_name]" value="'+storeName+'">'+
                        '<input type="hidden" name="product['+productID+'][unit_name]" value="'+unitName+'">'+
                        '<input type="hidden" name="product['+productID+'][product_name]" value="'+productName+'">'+
                        '<input type="hidden" name="product['+productID+'][cost]" value="'+cost+'">'+
                        num+
                        '</td>' +
                        '<td><input type="hidden" name="product['+productID+'][store_id]" value="'+store_id+'">'+storeName+'</td>' +
                        '<td><input type="hidden" name="product['+productID+'][product_id]" value="'+productID+'">'+productName+'</td>' +
                        '<td><input class = "itemQty tdinput" type="text" name="product['+productID+'][qty]" value="'+productQty+'"></td>' +
                        '<td><input class="itemPrice tdinput" type="text" name="product['+productID+'][price]" value="'+unitPrice+'"></td>' +
                        '<td><input type="hidden" name="product['+productID+'][unit_id]" value="'+unit_id+'">'+unitName+'</td>' +
                        '<td><input class="itemTotal tdinput" readonly type="text" value="'+total+'"></td>'+
                        '<td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>' ;
                    if($('.'+rowClass).length){

                        $('.'+rowClass).html(data);
                    }else{
                        $("#invoiceTable").append('<tr class="'+rowClass+'">' + data+ '</tr>');
                    }
                    calculateTotal();
                    toastr.success("تمت إضافة "+productQty+" "+unitName+" للصنف "+productName);
                    $typeaheadSearch.typeahead('val','');
                    $("#unitPrice").val('');
                    $("#productID").val('');
                    $("#productQty").val(1);
                    $typeaheadSearch.focus();
                    setTimeout("$('[name=search_input]').focus();",500);
                    return false;
                });
            //$('.'+rowClass).remove();
        }else{
            //var num = $('#invoiceTable tr').length+1;
            if($('#invoiceTable tr').length){
                var num = parseInt($(".rowIndex:last").val())+1;
            }else{
                var num = $('#invoiceTable tr').length+1;
            }
            $("#invoiceTable").append(
                '<tr class="'+rowClass+' bg-success">' +
                '<td>'+
                '<input type="hidden" class="rowIndex" value="'+num+'">'+
                '<input type="hidden" name="product['+productID+'][store_name]" value="'+storeName+'">'+
                '<input type="hidden" name="product['+productID+'][unit_name]" value="'+unitName+'">'+
                '<input type="hidden" name="product['+productID+'][product_name]" value="'+productName+'">'+
                '<input type="hidden" name="product['+productID+'][cost]" value="'+cost+'">'+
                num+
                '</td>' +
                '<td><input type="hidden" name="product['+productID+'][store_id]" value="'+store_id+'">'+storeName+'</td>' +
                '<td><input type="hidden" name="product['+productID+'][product_id]" value="'+productID+'">'+productName+'</td>' +
                '<td><input class = "itemQty tdinput" type="text" name="product['+productID+'][qty]" value="'+productQty+'"></td>' +
                '<td><input class="itemPrice tdinput" type="text" name="product['+productID+'][price]" value="'+unitPrice+'"></td>' +
                '<td><input type="hidden" name="product['+productID+'][unit_id]" value="'+unit_id+'">'+unitName+'</td>' +
                '<td><input class="itemTotal tdinput" readonly type="text" value="'+total+'"></td>'+
                '<td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>' +
                '</tr>'
            );
            calculateTotal();
            toastr.success("تمت إضافة "+productQty+" "+unitName+" للصنف "+productName);
            $typeaheadSearch.typeahead('val','');
            $("#unitPrice").val('');
            $("#productID").val('');
            $("#productQty").val(1);
            $typeaheadSearch.focus();
            return false;

        }
    }

    $(document).on("input","#tax",function(e){
        calculateTotal();
    });
    function calculateTotal(){
        var grandtotal =0;
        $(".itemTotal").each(function() {
            grandtotal += parseFloat($(this).val());
        });
        var tax = parseFloat($("#tax").val());
        var PriceIncludesTax = "{{ $settings['PriceIncludesTax']??'no' }}";
        TaxValue = 0;
        if(PriceIncludesTax=="no"){
            var TaxValue = (grandtotal * (tax / 100));
        }
        grandtotal += TaxValue;
        grandtotal = parseFloat(grandtotal).toFixed(2);

        $("#grandtotal").val(grandtotal);
        var discountPercent = $("#discount_type").is(':checked');
        var discount = parseFloat($("#discount").val());
        if(discountPercent){
            discount = (grandtotal*(discount/100));
        }
        $("#disValue").html(discount.toFixed(2));
        grandtotal -= discount;
        grandtotal = parseFloat(grandtotal).toFixed(2);
        $("#total").val(grandtotal);
        var percent = $("#sales_percent").val();
        if(percent){
            var salD = grandtotal * (parseFloat(percent)/100);
            $("#sales_value").val(salD.toFixed(2));
        }
    }
    function checkMaxQty(){
        var checkqty = parseInt("{{isset($settings['show_all_products_returns'])?$settings['show_all_products_returns']:1}}");
        var qty = parseFloat($("#productQty").val());
        var max = parseFloat($("#productQty").attr('max'));
        var flag = true;
        // console.log(qty);
        // console.log(max);
        // console.log(qty > max && checkqty==1);
        if(qty > max && checkqty==1){
            swal({
                title:'خطأ', text:"لا يمكنك استرجاع كمية اكبر من "+max,type:"error",confirmButtonText: "تمام",
            });
            $("#productQty").val(max);
            flag = false;
        }
        return flag;
    }

    $(document).on("change",".salePersonSelect",function(e) {
        var manager_id = $(".salePersonSelect option:selected").attr('manager_id');
        $("#manager_id").val(manager_id);
    });
</script>
@endpush
