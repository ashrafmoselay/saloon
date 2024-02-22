@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>@lang('front.Cashier screen')</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('orders.store') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="ispos" value="1">
            <div class="col-md-12 hide">
                <div class="form-group">
                    <label>@lang('front.payment')</label>
                    <select id="paymentMethod" data-placeholder="@lang('front.select')" name="order[payment_type]"
                        class="form-control select2 " style="width:100%;">
                        <option {{ $settings['default_payment'] == 'cash' ? 'selected' : '' }} value="cash">
                            @lang('front.cash')
                        </option>
                        <option {{ $settings['default_payment'] == 'delayed' ? 'selected' : '' }} value="delayed">
                            @lang('front.Postpaid')</option>
                        <option value="visa">@lang('front.visa')</option>
                        <option {{ $settings['default_payment'] == 'link transfer' ? 'selected' : '' }}
                            value="link transfer">
                            @lang('front.link transfer')</option>
                        {{-- @foreach (\App\Bank::get() as $bank)
                            <option balance="{{$bank->balance}}" {{$order->payment_type==$bank->name||empty($order->payment_type)?'selected':''}}  value="{{$bank->id}}">دفع نقدى{{" ( $bank->name ) "}}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
            <div class="hide">
                <div class="form-group">
                    <label>@lang('front.status')</label>
                    <select data-placeholder="@lang('front.select')" name="order[status]" class="form-control select2 "
                        style="width:100%;">
                        <option selected value="delivered">@lang('front.delivered')</option>
                        <option value="not-delivered">@lang('front.not-delivered')</option>
                    </select>
                </div>
            </div>
            <input id="savePrint" name="savePrint" value="" type="hidden">
            <div class="row">

                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('front.store')</label>
                                    <select id="productStores" class="form-control storeList" required="required">
                                        @foreach (auth()->user()->stores as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    @php
                                        $title = trans('front.client');
                                        $defaultperson = \App\Person::whereIn('name', ['عميل نقدي', 'عميل كاش'])->first();
                                        $salesMan = \App\Employee::where('type', 'sales')->get();
                                        $marktersMan = \App\Employee::where('type', 'markter')->get();
                                        $userListRoute = route('person.getList', ['type' => 'client']);
                                        $route = route('client.create', ['req' => 'ajax']);
                                    @endphp
                                    <label>
                                        @lang('front.client') <span class="lastBalance" style="color: red"></span>
                                    </label>
                                    <div class="input-group">
                                        <select data-ajax--url="{{ $userListRoute }}" data-ajax--cache="true"
                                            data-placeholder="@lang('front.select')" id="personList" name="order[client_id]"
                                            required class="form-control select2">
                                            <option data-mobile="" value="">@lang('front.select')</option>
                                            @if (isset(old('order')['client_id']) && !empty(old('order')['client_id']))
                                                @php
                                                    $per = \App\Person::find(old('order')['client_id']);
                                                @endphp
                                                <option points="{{ $per->total_points }}"
                                                    data-mobile="{{ $per->mobile . ' ' . $per->mobile2 }}"
                                                    last_transaction="{{ $per->last_transaction }}"
                                                    priceType="{{ $per->priceType }}" rel="{{ $per->total_due }}" selected
                                                    value="{{ $per->id }}">{{ $per->name }}</option>
                                            @else
                                                @if ($defaultperson)
                                                    <option points="{{ $defaultperson->total_points }}"
                                                        data-mobile="{{ $defaultperson->mobile . ' ' . $defaultperson->mobile2 }}"
                                                        last_transaction="{{ $defaultperson->last_transaction }}"
                                                        priceType="{{ $defaultperson->priceType }}"
                                                        rel="{{ $defaultperson->total_due }}" selected
                                                        value="{{ $defaultperson->id }}">{{ $defaultperson->name }}
                                                    </option>
                                                @endif
                                            @endif
                                        </select>
                                        <div class="input-group-addon no-print" style="padding: 2px 5px;">
                                            <a href="{{ $route }}" class="external" data-toggle="modal"
                                                data-target="#addPersonModal">
                                                <i class="fa fa-2x fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="nav-tabs-">
                                    <ul class="nav nav-tabs">
                                        @foreach ($categories as $category)
                                            <li @if ($loop->iteration == 1) class="active" @endif><a
                                                    href="#tab-{{ $category->id }}"
                                                    data-toggle="tab">{{ $category->name }}</a></li>
                                        @endforeach
                                        <li class="pull-right header"><i class="fa fa-th"></i> @lang('front.categories')</li>
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($categories as $category)
                                            <div style="padding: 10px"
                                                class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}"
                                                id="tab-{{ $category->id }}">
                                                @foreach ($category->products->chunk(6) as $chunks)
                                                    <div class="row">
                                                        @foreach ($chunks as $item)
                                                            <div class="col-md-2 posItem">
                                                                <div class="image">
                                                                    <a class="addFirstUnit" href="#">
                                                                        <img
                                                                            src="{{ optional($item->getFirstMedia('images'))->getUrl() ?: asset('icons/p.png') }}">
                                                                    </a>
                                                                </div>
                                                                <p class="prodname">
                                                                    {{ $item->name }}<br />
                                                                </p>
                                                                <div class="prices">
                                                                    @foreach ($item->productUnit as $unit)
                                                                        @php
                                                                            $sale_price = $unit->pivot->sale_price;
                                                                        @endphp
                                                                        <p>
                                                                            <a unitname="{{ $unit->name }}"
                                                                                prodname="{{ $item->name }}"
                                                                                unit_id={{ $unit->id }} href="#"
                                                                                cost="{{ $unit->pivot->cost_price }}"
                                                                                prodid="{{ $item->id }}"
                                                                                prodprice="{{ $sale_price }}"
                                                                                class="itemCard">
                                                                                <span
                                                                                    class="label label-warning">{{ $unit->name }}:
                                                                                    {{ $sale_price }}
                                                                                    {{ currency()->getCurrency()['symbol'] ?? '' }}</span>
                                                                            </a>
                                                                        </p>
                                                                    @endforeach
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach

                                                @foreach ($category->productsSubCategory->chunk(6) as $chunks)
                                                    <div class="row">
                                                        @foreach ($chunks as $item)
                                                            <div class="col-md-2 posItem">
                                                                <div class="image">
                                                                    <a class="addFirstUnit" href="#">
                                                                        <img
                                                                            src="{{ optional($item->getFirstMedia('images'))->getUrl() ?: asset('icons/p.png') }}">
                                                                    </a>
                                                                </div>
                                                                <p class="prodname">
                                                                    {{ $item->name }}<br />
                                                                </p>
                                                                <div class="prices">
                                                                    @foreach ($item->productUnit as $unit)
                                                                        @php
                                                                            $sale_price = $unit->pivot->sale_price;
                                                                        @endphp
                                                                        <p>
                                                                            <a unitname="{{ $unit->name }}"
                                                                                prodname="{{ $item->name }}"
                                                                                unit_id={{ $unit->id }} href="#"
                                                                                cost="{{ $unit->pivot->cost_price }}"
                                                                                prodid="{{ $item->id }}"
                                                                                prodprice="{{ $sale_price }}"
                                                                                class="itemCard">
                                                                                <span
                                                                                    class="label label-warning">{{ $unit->name }}:
                                                                                    {{ $sale_price }}
                                                                                    {{ currency()->getCurrency()['symbol'] ?? '' }}</span>
                                                                            </a>
                                                                        </p>
                                                                    @endforeach
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach

                                            </div>
                                        @endforeach
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-body">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr class="bg-green">
                                            <th>#</th>
                                            <th>@lang('front.product')</th>
                                            <th>@lang('front.quantity')</th>
                                            <th>@lang('front.unit')</th>
                                            <th>@lang('front.saleprice')</th>
                                            <th>@lang('front.total')</th>
                                            <th>@lang('front.note')</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoiceTable">
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-body">
                            <table class="table table-bordered pull-right">
                                <tr>
                                    <td>
                                        <label>
                                            @lang('front.total'):-
                                        </label>
                                        <input readonly id="total" value="" value="0"
                                            class="form-control">
                                    </td>
                                    <td>
                                        <label>
                                            @lang('front.discount'):-
                                        </label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" required id="discount"
                                                name="order[discount]" value="0" class="form-control">
                                            <input type="hidden" name="order[discount_value]" value="0">

                                            <span class="input-group-addon ">
                                                <input id="discount_type" value="1" name="order[discount_type]"
                                                    type="checkbox" class="flat-red ">
                                                %
                                            </span>
                                            <span style="color:#ffffff;" id="disValue" class="input-group-addon btn ">

                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <label>
                                            @lang('front.tax'):-
                                        </label>
                                        <input id="TaxValue" name="order[tax_value]" value="0" class="hide">
                                        <div class="input-group">
                                            <input id="tax" name="order[tax]"
                                                value="{{ $settings['taxValue'] ?? 0 }}" class="form-control">
                                            <span class="input-group-addon btn">
                                                %
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <label>
                                            @lang('front.grand'):
                                        </label>
                                        <input readonly id="totalafter" value="" name="order[total]"
                                            value="0" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            @lang('front.paid'):-
                                        </label>
                                        <input type="number" step="0.01" required id="paid" name="order[paid]"
                                            value="0" class="form-control" />
                                    </td>
                                    <td>
                                        <label>
                                            @lang('front.due'):-
                                        </label>
                                        <div class="input-group">
                                            <input readonly required id="due" name="order[due]" value="0"
                                                class="form-control" />
                                        </div>
                                    </td>
                                    <td>
                                        <label>
                                            @lang('front.before'):-
                                        </label>
                                        <input readonly required id="lastBalance" value="0" class="form-control">
                                    </td>
                                    <td>
                                        <label>
                                            @lang('front.balance'):-
                                        </label>
                                        <input readonly required id="totalBalance" value="" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <button type="submit" class="btn btn-primary "><i class="fa fa-save"></i>
                                            @lang('front.save') </button>
                                        <button type="submit" class="btn btn-success saveandPrint"><i
                                                class="fa fa-print"></i> @lang('front.save and print') </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </section>
@stop
@push('js')
    <script>
        $(".select2").select2();
        $(document).on("change", "#personList", function(e) {
            e.preventDefault();
            if ($(this).val()) {
                $.ajax({
                    url: "{{ route('person.getDetails') }}",
                    type: 'GET',
                    data: {
                        'p_id': $(this).val()
                    },
                    success: function(result) {
                        var obj = JSON.parse(result);
                        var total_due = parseFloat(obj.total_due).toFixed(1);
                        $("#lastBalance").val(total_due);
                        $(".lastBalance").html("( {{ trans('front.previous balance') }}" + total_due +
                            " )");
                        $("#priceType").val(obj.priceType);
                        $("#last_transaction").html(obj.last_transaction);
                        if (obj.points) {
                            $(".userpointSpan").html(obj.points);
                            $(".userpointSpan").removeClass('hide');
                        } else {
                            $(".userpointSpan").addClass('hide');
                        }
                    }
                });
            }
        });
        $(document).on('click', '.saveandPrint', function(e) {
            e.preventDefault();
            if ($("#personList").val()) {
                $('#savePrint').val('print');
                $('form').submit();
            } else {
                swal({
                    title: 'خطأ',
                    text: "يجب استكمال بيانات الفاتورة",
                    type: "error",
                    confirmButtonText: "تمام",
                });
            }
        });
        $(document).on('click', '.addFirstUnit', function(e) {
            e.preventDefault();
            $(this).closest('.posItem').find('.prices a:first').trigger('click');
        });




        $(document).on("click", ".removeItem", function(e) {
            e.preventDefault();
            $(this).closest('.itemRow').remove();
        });
        $(document).on("click", ".itemCard", function(e) {
            e.preventDefault();
            var selectdItem = $(this);
            addRow(selectdItem);
        });
        $(document).on("change", ".unitsPriceList", function(e) {
            var row = $(this).closest('tr');
            var price = row.find(".unitsPriceList option:selected").attr('price');
            var cost = row.find(".unitsPriceList option:selected").attr('cost');
            price = parseFloat(price);
            var itemPrice = row.find(".itemPrice").val(price);
            row.find(".itemCost").val(cost);
            row.find(".itemPrice").trigger("change");
        });

        function addRow(selectdItem) {
            productID = selectdItem.attr('prodid');
            unitPrice = selectdItem.attr('prodprice');
            cost = selectdItem.attr('cost');
            productName = selectdItem.attr('prodname');
            unit_id = selectdItem.attr('unit_id');
            store_id = $('#productStores').val();
            var storeName = $("#productStores option:selected").text();
            var unitName = selectdItem.attr('unitname');

            var productQty = 1;
            var total = unitPrice * productQty;
            total = parseFloat(total).toFixed(2);
            var rowClass = "rowelement" + productID + '_' + store_id + '_' + unit_id;
            var num = $('#invoiceTable tr').length + 1;
            if ($('.' + rowClass).length) {
                num = $('.' + rowClass).find('.rowIndex').val();
            }

            if ($('.' + rowClass).length) {
                productQty += parseInt($('.' + rowClass).find('.itemQty').val());
            }
            if ($('.' + rowClass).length) {
                num = $('.' + rowClass).find('.rowIndex').val();
            }
            var cloneUnitList = '<select name="product[' + num + '][unit_id]" class="unitsPriceList">';
            selectdItem.closest('.posItem').find(".prices a").each(function() {
                var unitname = $(this).attr('unitname');
                var ItemUid = $(this).attr('unit_id');
                var cost = $(this).attr('cost');
                var prodprice = $(this).attr('prodprice');
                if (unit_id == ItemUid) {
                    cloneUnitList += '<option selected cost="' + cost + '" price="' + prodprice + '" value="' +
                        ItemUid + '">' + unitname + '</option>';
                } else {
                    cloneUnitList += '<option cost="' + cost + '" price="' + prodprice + '" value="' + ItemUid +
                        '">' + unitname + '</option>';
                }
            });
            cloneUnitList += '</select>';

            if ($('.' + rowClass).length) {
                var oldqty = $('.' + rowClass).find(".itemQty").val();
                total = unitPrice * productQty;
                total = parseFloat(total).toFixed(2);
                num = $('.' + rowClass).find('.rowIndex').val();
                var completeProcess = false;

                swal({
                        title: " تحذير! الصنف مكرر بكمية " + oldqty,
                        text: "هل تريد الإضافة عليه؟ " + " ستصبح الكمية الجديدة " + productQty,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD4140",
                        closeOnConfirm: true,
                        showLoaderOnConfirm: false,
                        cancelButtonText: "إلغاء",
                        confirmButtonText: "نعم متأكد",
                    },
                    function() {

                        var data = '<td>' +
                            '<input type="hidden" class="rowIndex" value="' + num + '">' +
                            '<input type="hidden" name="product[' + num + '][product_name]" value="' + productName +
                            '">' +
                            '<input class="itemCost" type="hidden" name="product[' + num + '][cost]" value="' + cost +
                            '">' +
                            //  '<input type="hidden" name="product[' + num + '][unit_id]" value="' + unit_id + '">' +
                            '<input class="rowUnit_name" type="hidden" name="product[' + num + '][unit_name]" value="' +
                            unitName + '">' +
                            '<input type="hidden" name="product[' + num + '][store_name]" value="' + storeName + '">' +
                            '<input type="hidden" name="product[' + num + '][store_id]" value="' + store_id + '">' +
                            num +
                            '</td>' +
                            '<td><input type="hidden" name="product[' + num + '][product_id]" value="' + productID +
                            '">' + productName + '</td>' +
                            '<td><input class = "itemQty tdinput" type="number" name="product[' + num +
                            '][qty]" value="' + productQty + '"></td>' +
                            '<td>' + cloneUnitList + '</td>' +
                            '<td><input class="itemPrice tdinput" type="number" name="product[' + num +
                            '][price]" value="' + unitPrice + '"></td>';
                        data += '<td><input class="itemTotal tdinput" readonly type="text" name="product[' + num +
                            '][total]" value="' + total + '"></td>';
                        data += '<td><input class="tdinput" type="text" name="product[' + num +
                            '][comment]" value=""></td>';
                        data +=
                            '<td><a href="#" class="btn btn-sm btn-danger removeItem"><i class="fa fa-trash"></i></a></td>';
                        if ($('.' + rowClass).length) {
                            $('.' + rowClass).html(data);
                        } else {
                            $("#invoiceTable").append('<tr class="itemRow ' + rowClass + '">' + data + '</tr>');
                        }
                        calculateTotal();
                        toastr.success("تمت إضافة " + productQty + " " + " للصنف " + productName + " للفاتورة");
                        // $typeaheadSearch.typeahead('val','');
                        // $typeaheadSearch.focus();
                        // $("#unitPrice").val('');
                        // $("#productID").val('');
                        // $("#productQty").val(1);
                        // setTimeout("$('[name=search_input]').focus();",500);
                        return true;

                    });

            } else {
                var data = '<td>' +
                    '<input type="hidden" class="rowIndex" value="' + num + '">' +
                    '<input type="hidden" name="product[' + num + '][product_name]" value="' + productName + '">' +
                    '<input class="itemCost" type="hidden" name="product[' + num + '][cost]" value="' + cost + '">' +
                    //'<input type="hidden" name="product[' + num + '][unit_id]" value="' + unit_id + '">' +
                    '<input class="rowUnit_name" type="hidden" name="product[' + num + '][unit_name]" value="' + unitName +
                    '">' +
                    '<input type="hidden" name="product[' + num + '][store_name]" value="' + storeName + '">' +
                    '<input type="hidden" name="product[' + num + '][store_id]" value="' + store_id + '">' +
                    num +
                    '</td>' +
                    '<td><input type="hidden" name="product[' + num + '][product_id]" value="' + productID + '">' +
                    productName + '</td>' +
                    '<td><input class = "itemQty tdinput" type="text" name="product[' + num + '][qty]" value="' +
                    productQty + '"></td>' +
                    '<td>' + cloneUnitList + '</td>' +
                    '<td><input class="itemPrice tdinput" type="text" name="product[' + num + '][price]" value="' +
                    unitPrice + '"></td>';
                data += '<td><input class="itemTotal tdinput" readonly type="text" name="product[' + num +
                    '][total]" value="' + total + '"></td>';
                data += '<td><input class="tdinput" type="text" name="product[' + num +
                    '][comment]" value=""></td>';
                data += '<td><a href="#" class="btn btn-sm btn-danger removeItem"><i class="fa fa-trash"></i></a></td>';
                if ($('.' + rowClass).length) {
                    $('.' + rowClass).html(data);
                } else {
                    $("#invoiceTable").append('<tr class="itemRow bg-success ' + rowClass + '">' + data + '</tr>');
                }
                calculateTotal();
                toastr.success("تمت إضافة " + productQty + " " + " للصنف " + productName + " للفاتورة");
                // $typeaheadSearch.typeahead('val','');
                // $typeaheadSearch.focus();
                // $("#unitPrice").val('');
                // $("#productID").val('');
                // $("#marketer").val(0);
                // $("#productQty").val(1);
                // $("#CostPriceSpan").html('');
                return false;
            }


        }

        $(document).on("input", "#paid", function(e) {
            e.preventDefault();
            var discountPercent = $("#discount_type").is(':checked');
            var discount = 0;
            var lastBalance = 0;
            if ($("#discount").val()) {
                discount = parseFloat($("#discount").val());
            }
            if ($("#lastBalance").val()) {
                lastBalance = parseFloat($("#lastBalance").val());
            }
            var paid = parseFloat($("#paid").val());
            var grandtotal = parseFloat($("#total").val());
            if (discountPercent) {
                grandtotal -= (grandtotal * (discount / 100));
            } else {
                grandtotal -= discount;
            }
            var tax = parseFloat($("#tax").val());

            var PriceIncludesTax = "{{ $settings['PriceIncludesTax'] ?? 'no' }}";
            TaxValue = 0;
            if (PriceIncludesTax == "no") {
                var TaxValue = (grandtotal * (tax / 100));
            }
            $("#TaxValue").val(TaxValue);

            grandtotal += TaxValue;
            @if ($settings['rounding_up'] == 1)
                grandtotal = Math.ceil(grandtotal);
            @endif
            grandtotal = parseFloat(grandtotal.toFixed(2));
            $("#totalafter").val(grandtotal);
            var due = 0;
            if ($("#paymentMethod").val() == 'delayed') {
                due = grandtotal - paid;
                due = parseFloat(due).toFixed(2);
                $("#due").val(due);
            } else {
                var due = 0;
                if ($("#paymentMethod").val() == 'cash' || $("#paymentMethod").val() == 'visa') {
                    $("#paid").val(grandtotal);
                    $("#due").val(0);
                } else {
                    due = grandtotal - paid;
                    due = parseFloat(due).toFixed(1);
                    $("#due").val(due);
                }
            }
            var TotalBal = parseFloat(due) + parseFloat(lastBalance);
            var totalBalance = TotalBal.toFixed(1);
            $("#totalBalance").val(totalBalance);
        });
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        $(document).on('ifChanged', '#discount_type', function() {
            calculateTotal();
        });
        $(document).on("input", "#tax,#discount", function(e) {
            calculateTotal();
        });

        function calculateTotal() {
            var grandtotal = 0;
            $(".itemTotal").each(function() {
                grandtotal += parseFloat($(this).val());
            });


            grandtotal = parseFloat(grandtotal).toFixed(2);
            $("#total").val(grandtotal);

            $("#paid").trigger("input");
            var lastBalance = 0;
            if ($("#lastBalance").val()) {
                lastBalance = parseFloat($("#lastBalance").val());
            }

            var TotalBal = parseFloat($("#due").val()) + parseFloat(lastBalance);
            var totalBalance = TotalBal.toFixed(1);
            $("#totalBalance").val(totalBalance);
        }
        $(document).on("change", ".itemQty,.itemPrice", function(e) {
            var row = $(this).closest('tr');
            var qty = row.find(".itemQty").val();
            var itemPrice = row.find(".itemPrice").val();
            var total = parseFloat(qty) * parseFloat(itemPrice);
            row.find(".itemTotal").val(total.toFixed(2));
            calculateTotal();
        });
    </script>
@endpush
@push('css')
    <style>
        a.addFirstUnit img:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .posItem {
            text-align: center;
        }

        .posItem img {
            max-width: 100%;
            height: 100px;
            ;
        }

        .posItem a:hover span {
            background-color: #e08e0b !important;
            font-weight: bold;
        }

        .posItem a {
            margin-bottom: 3px;
            text-decoration: none;
        }

        input.tdinput:focus {
            background-color: #fff !important;
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
            border: 0px solid #fff !important;
            text-align: center;
        }
    </style>
@endpush
