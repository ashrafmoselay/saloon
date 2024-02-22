@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            إضافة
            <small>
أمر تشغيل
            </small>

        </h1>
    </section>
    <!-- Main content -->
    <form action="{{route('orders.workorders')}}" method="post">
        {{ csrf_field() }}
        <section class="content">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>التاريخ</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="date" type="text" value="{{date('Y-m-d')}}" class="form-control pull-right" id="datepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">إختر المخزن</label>
                                <select name="store_id" id="productStores" class="form-control storeList select2" required="required">
                                    @foreach(\App\Store::get() as $s)
                                        <option value="{{$s->id}}">{{$s->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">الصنف</label>
                                    <input autocomplete="off" class="typeahead form-control" type="text">
                                    <input type="hidden" value="" name="product_id" id="productID">
                                    <input type="hidden" value="" name="product_name" id="productName">
                                </div>
                            </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>العدد</label>
                                <div class="input-group">

                                    <input style=" min-width: 120px; " id="productQty" value="1" min="0" name="itemqty" type="number" type="text" class="form-control qty" >
                                    <span style="color:#ffffff;" id="unitQty" class="input-group-addon btn">
			                            0
                                    </span>
                                    <span style="width: 100px;" class="unit input-group-addon">
                                        <select name="unit_id" id="unitList" class="form-control unitList" required>
                                            @foreach(\App\Unit::latest()->get() as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الخامات</th>
                            <th>الكمية المطلوبة</th>
                            <th>الوحدة</th>
                            <th>الكمية المتاحة</th>
                        </tr>
                        </thead>
                        <tbody id="invoiceTable">

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button id="submitBtn" type="submit" class="btn btn-primary ">تشغيل</button>
                </div>
            </div>
        </section>
    </form>

@stop
@push('js')
    <script>
        $(".select2").select2();
        $('#datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",
        });
        var units = [[]];
        var $typeaheadSearch = $('.typeahead');
        $typeaheadSearch.on('typeahead:select', function (e, suggestion) {
            //console.log(suggestion);
            var selectedUnit = $('#unitList').val();
            $("#productID").val(suggestion.id);
            $("#productName").val(suggestion.name);
            suggestion.product_unit.map(function(item){
                //units[item.id] = item.pivot.sale_price;
                units[item.id] = item.pivot.pieces_num;
            });

            $('#unitList > option').each(function(){
                if(!$(this).hasClass('hide')){
                    $(this).addClass('hide');
                }
            });
            suggestion.product_unit.map(function(item){
                $("#unitList option[value='" + item.id + "']").removeClass('hide');
            });
            if($("#unitList option[value='" + $("#unitList").val() + "']").hasClass('hide')){
                $("#unitList option:not('.hide'):first").prop('selected',true);
            }
            var selectedStore = $('#productStores').val();
            var selectedunit = $('#unitList').val();
            var pieces_num = parseFloat(units[selectedunit]);
            $("#invoiceTable").html('');
            $.each(suggestion.raw_matrial, function( index, item ) {
                var totqty = parseFloat(item.pivot.qty) * pieces_num;
                var totalrawqty = 0;
                $.each(item.product_store, function( index, store ) {
                    totalrawqty +=  (parseInt(store.pivot.qty) - parseInt(store.pivot.sale_count));
                });
                let rawClass = "";
                if(totalrawqty < parseInt(item.pivot.qty)){
                    rawClass = "danger";
                }
                $("#invoiceTable").append('<tr class="'+rawClass+'">' +
                    '<td>'
                    +(index+1)+
                    '<input name="raw['+item.id+'][raw_unit_id]" type="hidden" value="'+item.id+'"/>'+
                    '<input name="raw['+item.id+'][raw_name]" type="hidden" value="'+item.name+'"/>'+
                    '<input class="totalneedqty" name="raw['+item.id+'][totalneedqty]" type="hidden" value="'+totqty+'"/>'+
                    '<input name="raw['+item.id+'][raw_unit_text]" type="hidden" value="'+item.pivot.raw_unit_text+'"/>'+
                    '<input class="raw['+item.id+'][pieces_num]" type="hidden" value="'+pieces_num+'"/> '+
                    '<input class="rawQty" type="hidden" value="'+item.pivot.qty+'"/> '+
                    '</td>' +
                    '<td>'+ item.name+'</td>' +
                    '<td class="qtyneed">'+Number((totqty).toFixed(1))+'</td>' +
                    '<td class="raw_unit_text">'+item.pivot.raw_unit_text+'</td>' +
                    '<td class="totalrawqty">'+Number((totalrawqty).toFixed(1))+'</td>'+
                    '</tr>')
            });
            $.each(suggestion.product_store, function( index, item ) {
               // console.log(item.pivot.qty-item.pivot.sale_count);
                //console.log(selectedStore);
                if(selectedStore==item.id) {
                    var avilable = item.pivot.qty - item.pivot.sale_count;

                    //var qty = new Fraction(avilable);
                    //var qty = qty.toFraction(true); //
                    avilable = parseFloat(avilable).toFixed(1);
                    //console.log(avilable);
                    $('#unitQty').html(avilable);
                    if(avilable>0){
                        $('#unitQty').css('background-color', '#008d4c');
                    }else{
                        $('#unitQty').css('background-color', '#ac2925');
                    }
                    $('#productQty').select();

                    //$('#invoiceProductList').find('#storeUnitName').html(units[item.pivot.unit_id]);

                }
            });
        });
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
                        settings.url = "{{route('products.getProductList')}}" + '?q=' + query
                            +'&store_id='+$('#productStores').val();
                        return settings;
                    }
                }
            }),
            templates: {
                suggestion: function(suggestion) {
                    return '<p>'+ suggestion.name +'<strong style="color:red;"> ' +suggestion.category.name+ '</strong></p>';
                }
            }
        });
        $(document).on('change','#unitList',function(){
            calculateTotQty();
        });
        $(document).on('input','#productQty',function(e){
            e.preventDefault();
            calculateTotQty();
        });
        function calculateTotQty(){
            var pieces_num  = parseFloat(units[$('#unitList').val()]);
            $(".danger").removeClass('danger');
            $(':input[type="submit"]').prop('disabled', false);
            $("#invoiceTable tr").each(function()  {
                var qtyReq = parseFloat($('#productQty').val()) * pieces_num;
                var rawqty = parseFloat($(this).find('.rawQty').val());
                var totalrawqty = parseFloat($(this).find('.totalrawqty').html());
                //console.log(pieces_num);
                var qtyneed = qtyReq*rawqty*1;
                $(this).find(".totalneedqty").val(qtyneed);
                $(this).find('.qtyneed').html(Number((qtyneed).toFixed(1)));
                if(totalrawqty<qtyneed){
                    $(this).addClass('danger');
                    $(':input[type="submit"]').prop('disabled', true);
                }
            });
        }
    </script>
@endpush
@push('css')
    <style>
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

    </style>
@endpush
