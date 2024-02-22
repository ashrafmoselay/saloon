@extends('layouts.app')
@section('title', trans('front.pricelist'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.pricelist')
            <small>

            </small>
            <div class="pull-right">
                <a onclick="window.print();" href="javascript:void(0)" class=" btn  print btn-info btn-sm"><i
                        class="fa fa-print" aria-hidden="true"></i> طباعه</a>
                <button id="pdf-button" class="btn btn-success print-window btn-sm"><i class="fa fa-file-pdf-o"
                        aria-hidden="true"></i> تحميل PDF</button>
            </div>
            <div style="margin-left: 10px;" class="form-group pull-right">
                <label for="showLogo">
                    <input class="flat-red" checked type="checkbox" id="showLogo">
                    <span style="font-size: 14px;">إظهار اللوجو</span>
                </label>
            </div>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div style="margin-bottom: 5px;" class="row hideprint">
            <div class="col-md-12">
                <div class="col-md-4">
                    <select id="category_id" class="form-control select2"
                        style="width: 100% !important;height: 35px !important;">
                        <option value="">@lang('front.all')</option>
                        @foreach (\App\Category::where('type', 1)->get() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group input-group-sm">
                    {{-- <span style="width: 200px;" class="input-group-btn">

                     </span> --}}
                    <input autofocus style="height: 34px;" id="rows" type="number" class="form-control"
                        placeholder="@lang('front.rawcount')">
                    <span style="margin: 5px;" class="input-group-btn">
                        <button style=" margin-right: 20px; width: 250px; " id="addRow" type="button"
                            class="btn btn-info btn-flat">@lang('front.createTable')</button>
                        <button style=" margin-right: 20px; width: 100px; " id="DeleteAllRow" type="button"
                            class="btn btn-danger"><i class="fa fa-trash"></i> مسح</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input value="السادة:شركة/" class="inputeditable" />
                                <input value="عناية/م/" class="inputeditable" />
                            </div>
                            <div style="margin-top:80px;" class="col-md-4">
                                <input value="تحية طيبة وبعد ...." class="inputeditable" />
                            </div>
                            <div class="col-md-4 listlogo">
                                <img class="pull-right" style="width: 200px;"
                                    src="{{ \Illuminate\Support\Facades\Storage::url($settings['logo']) }}">
                            </div>
                            <div style="margin-bottom: 20px;margin-top:20px;" class="col-md-12">
                                <input value="مقدما لسيادتكم عرض سعر بيانتها كالتالي" class="inputeditable" />
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-6">@lang('front.product')</th>
                                    <th>@lang('front.saleprice')</th>
                                    <th>@lang('front.quantity')</th>
                                    <th>@lang('front.total')</th>
                                </tr>
                            </thead>
                            <tbody class='itemsList'>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">@lang('front.total')</td>
                                    <td class="text-center" id="grandTotal"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div style="margin-top:40px;" class="col-md-12">
                                <input value="علماً بأن موقعكم الكائن/" class="inputeditable" />
                            </div>
                            <div class="col-md-12">
                                <input value="السعر عالي غير شامل قيمة الضريبة المضافه" class="inputeditable" />
                            </div>
                            <div class="col-md-12">
                                <input value="من حق الشركة استرداد البلتات الخشبية" class="inputeditable" />
                            </div>
                            <div class="col-md-12">
                                <input value="" class="inputeditable" />
                            </div>
                            <div class="col-md-12">
                                <input value="" class="inputeditable" />
                            </div>
                            <div class="col-md-4"></div>
                            <div style="margin-top: 30px;" class="col-md-8">
                                <input value="ولسيادتكم وافر التحية والاحترام ......." class="inputeditable" />
                            </div>
                            <div class="col-md-6"></div>
                            <div style="margin-top: 30px;" class="col-md-6">
                                <img class="listlogo"
                                    style="margin-bottom: 40px;width: 200px;transform: rotate(-19deg);opacity: 0.5;"
                                    src="{{ \Illuminate\Support\Facades\Storage::url($settings['signture']) }}" />
                                <input value="مقدمه لسيادتكم/ {!! $settings['SiteName'] !!} " class="inputeditable" />
                            </div>
                            <div class="col-md-4">
                                <input value="تحرير في / {{ date('Y-m-d') }} " class="inputeditable" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
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
            background-color: #fff;
            border: 0px solid #fff;
            border-radius: 4px;
            border: 0px solid #fff !important;
            text-align: center;
        }

        input.inputeditable {
            display: block;
            width: 100%;
            height: 35px;
            padding: 0;
            font-size: 18px;
            line-height: 1.42857143;
            color: #000;
            background-color: #fff;
            border: 0px solid #fff;
            border-radius: 4px;
            border: 0px solid #fff !important;
            text-align: right;
        }

        .tbody td,
        tr th {
            border: 2px solid black !important;
        }

        .table-bordered th,
        .textcenter {
            text-align: center;
        }

        .table-bordered>tbody>tr>td {
            vertical-align: middle;
            padding: 2px !important;
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

        .tt-menu {
            /* used to be tt-dropdown-menu in older versions */
            width: 100%;
            margin-top: 2px;
            padding: 4px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            z-index: 10000 !important;
        }

        .tt-suggestion {
            padding: 3px 20px;
            line-height: 24px;
            direction: rtl;
        }

        .tt-suggestion.tt-cursor,
        .tt-suggestion:hover {
            color: #fff;
            background-color: #0097cf;

        }

        .tt-suggestion p {
            margin: 0;
        }

        @page {
            size: auto;
            margin: 5mm 0mm 5mm 0mm;
        }

        @media print {

            .col-md-1,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9,
            .col-md-10,
            .col-md-11,
            .col-md-12 {
                float: right;
            }

            .col-md-1 {
                width: 8%;
            }

            .col-md-2 {
                width: 16%;
            }

            .col-md-3 {
                width: 25%;
            }

            .col-md-4 {
                width: 33%;
            }

            .col-md-5 {
                width: 42%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-7 {
                width: 58%;
            }

            .col-md-8 {
                width: 66%;
            }

            .col-md-9 {
                width: 75%;
            }

            .col-md-10 {
                width: 83%;
            }

            .col-md-11 {
                width: 92%;
            }

            .col-md-12 {
                width: 100%;
            }
        }
    </style>
@endpush
@push('js')
    <script type="text/javascript">
        $(".select2").select2();

        // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        //     checkboxClass: 'icheckbox_flat-green',
        //     radioClass: 'iradio_flat-green'
        // });
        $('#showLogo').on('click', function(event) {
            if ($(this).is(":checked")) {
                $(".listlogo").show();
            } else {
                $(".listlogo").hide();
            }
        });
        $(document).on("click", "#DeleteAllRow", function(e) {
            e.preventDefault();
            $('.itemsList').html("");
            $("#grandTotal").html("");
        });
        $(document).on("click", "#addRow", function(e) {
            e.preventDefault();
            var rows = $("#rows").val();
            if (rows) {
                var count = $('.itemsList tr').length;
                if (!count) {
                    count = 0;
                }
                for (var i = 1; i <= rows; i++) {
                    $('.itemsList').append(
                        '  <tr>\n' +
                        '                                    <td class="textcenter ">' + (++count) + '</td>\n' +
                        '                                    <td><input type="text" class="tdinput typeahead" /></td>\n' +
                        '                                    <td><input type="text" class="tdinput productprice" value="" /></td>\n' +
                        '                                    <td><input type="text" class="tdinput prodqty" value="1"  /></td>\n' +
                        '                                    <td><input type="text" class="tdinput total" value="" /></td>\n' +
                        '                                </tr>'
                    );
                }
                autocomplete();
            }
        });

        function autocomplete() {
            var $typeaheadSearch = $('.typeahead');
            $typeaheadSearch.typeahead('destroy');
            $typeaheadSearch.typeahead({
                highlight: true
            }, {
                name: 'products',
                limit: 10,
                display: function(suggestion) {
                    return suggestion.name;
                },
                source: new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace,
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: "{{ route('products.getProductList') }}",
                        prepare: function(query, settings) {
                            settings.url = "{{ route('products.getProductList') }}" + '?q=' + query +
                                '&category_id=' + $('#category_id').val();
                            return settings;
                        }
                    }
                }),
                templates: {
                    header: function() {
                        return '  <div class="s-row">\n' +
                            '                    <div class="s-cell">#</div>\n' +
                            '                    <div class="s-cell">الصنف</div>\n' +
                            '                    <div class="s-cell">الفئة</div>\n' +
                            '                    <div class="s-cell">التكلفة</div>\n' +
                            '                    <div class="s-cell">البيع</div>\n' +
                            '                    <div class="s-cell">الكمية</div>\n' +
                            '                </div>';
                    },
                    suggestion: function(suggestion) {
                        var price = "";
                        var cost = "";
                        suggestion.product_unit.map(function(item) {
                            price = parseFloat(item.pivot.sale_price).toFixed(1);
                            cost = parseFloat(item.cost_price).toFixed(1);
                        });
                        var avilable = "";
                        $.each(suggestion.product_store, function(index, item) {
                            q = parseFloat(item.pivot.qty - item.pivot.sale_count).toFixed(1);
                            avilable += item.name + " : " + (q) + "<br/>";
                        });
                        return '  <div class="s-row">\n' +
                            '                    <div class="s-cell">' + suggestion.id + '</div>\n' +
                            '                    <div class="s-cell">' + suggestion.name + '</div>\n' +
                            '                    <div class="s-cell">' + suggestion.category.name + '</div>\n' +
                            '                    <div class="s-cell">' + cost + '</div>\n' +
                            '                    <div class="s-cell">' + price + '</div>\n' +
                            '                    <div class="s-cell">' + avilable + '</div>\n' +
                            '                </div>';
                    }
                }
            });
            $typeaheadSearch.on('typeahead:select', function(e, suggestion) {
                var price = 0;
                suggestion.product_unit.map(function(item) {
                    price = parseFloat(item.sale_price).toFixed(2);
                });
                $(this).closest('tr').find('.productprice').val(price);
                var tot = parseFloat($(this).closest('tr').find('.prodqty').val()) * price;
                $(this).closest('tr').find('.total').val(tot);
                calculateTotal();
            });
        }
        $(document).on('input', '.prodqty,.productprice', function() {
            var item = $(this);
            var row = item.closest('tr');
            var qty = row.find('.prodqty').val();
            var price = row.find('.productprice').val();
            qty = parseFloat(qty);
            price = parseFloat(price);
            var total = (qty * price).toFixed(2);
            $(this).closest('tr').find('.total').val(total);
            calculateTotal();
        });

        function calculateTotal() {
            var grandtotal = 0;
            $(".total").each(function() {
                if ($(this).val()) {
                    grandtotal += parseFloat($(this).val());
                }
            });
            $("#grandTotal").html(grandtotal);
        }
    </script>
@endpush
