<script>
    $(".select2").select2();


    /*function customMatcher(params, data) {
        // Always return the object if there is nothing to compare
        if ($.trim(params.term) === '') {
            return data;
        }
        original = $(data.element).text();
        // Check if the text contains the term
        if (original.indexOf(params.term) > -1) {
            return data;
        }
        // Check if the data occurs
        if ($(data.element).data('mobile').toString().indexOf(params.term) > -1) {
            return data;
        }

        // If it doesn't contain the term, don't return anything
        return null;
    }*/
    setTimeout("$('[name=search_input]').focus();", 500);
    /*$("#marketerSelect").select2({
        multiple: true
    });*/
    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $(document).on("click", ".save-calander", function(e) {
        var flag = true;
        $('.calanderList input').each(function() {
            if (!$(this).val()) {
                $(this).addClass('calandererror');
                flag = false;
            } else {
                $(this).removeClass('calandererror');
            }
        });
        if (flag) {
            $("#modal-calander").modal('hide');
        } else {
            return false;
        }

    });
    $(document).on("click", ".removeCalander", function(e) {
        e.preventDefault();
        $(this).closest('.itemCalnader').remove();
    });
    $(document).on("click", ".addCalander", function(e) {
        e.preventDefault();
        var clone = $(".cal-item").find(".itemCalnader").clone();
        clone.find('.datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{ \Session::get('locale') }}",

        });

        $(".calanderList").append(clone);
    });
    $(document.body).on("change", "#marketerSelect", function() {
        var html = '';
        var mar = $("#marketerSelect");
        if ($(this).val()) {
            var num = parseInt($(this).val().length);
            var row = 12 / num;
            var data = $(mar).select2('data');

            for (var i = 0; i < num; i++) {

                html += '<div class="col-md-' + row + '"> <div class="form-group">' +
                    ' <label>عمولة ' + data[i]['text'] + '</label>' +
                    ' <input value="0" type="text" class="form-control marketInput">' +
                    ' </div> </div>';
            }
        }
        $("#markterratio").html(html);


    });
    $('form').validator();
    $('#datepicker').datepicker({
        autoclose: true,
        rtl: true,
        format: 'yyyy-mm-dd',
        language: "{{ \Session::get('locale') }}",

    });

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });

    $(document).on("click", ".save-discount-bouns", function(e) {
        $("#bounse_unit_id").val($(".bounse_unit_id").val());
        $("#bounse").val($(".bounse").val());
        $("#modal-dicounts-bounse").modal('hide');
        setTimeout(function() {
            $("#invoiceProductList").find('#productQty').select();
        }, 1000);
    });
    var units = [
        []
    ];
    var unitsPrice = [
        []
    ];
    var unitsCost = [
        []
    ];
    var $typeaheadSearch = $('.typeahead');
    $typeaheadSearch.on('typeahead:select', function(e, suggestion) {
        $("#productName").val(suggestion.name);
        $("#isService").val(0);
        if (suggestion.is_service == 1) {
            $("#isService").val(1);
            var costv = suggestion.last_cost;
            $('#invoiceProductList').find('#CostPriceSpan').html(costv);
            $('#invoiceProductList').find('#unitCost').val(costv);
            $('#invoiceProductList').find('#unitPrice').val(costv);
            $('#invoiceProductList').find('#productID').val(suggestion.id);
            $("#productName").val(suggestion.name);
            $("#unitList option").addClass('hide');
            $('#unitList').append("<option class='serOption' selected>خدمة</option>");
        } else {
            $('#unitList > option').each(function() {
                if (!$(this).hasClass('hide')) {
                    $(this).addClass('hide');
                }
            });
            suggestion.product_unit.map(function(item) {
                $("#unitList option[value='" + item.id + "']").removeClass('hide');
            });
            if ($("#unitList option[value='" + $("#unitList").val() + "']").hasClass('hide')) {
                $("#unitList option:not('.hide'):first").prop('selected', true);
            }
            var uoptions = $("#unitList").html();
            $("#bouns_unit_id").html(uoptions);
            $("#bouns_unit_id option:not('.hide'):last").prop('selected', true);
            var selectedUnit = $("#unitList").val();
            //console.log(suggestion.product_unit);
            suggestion.product_unit.map(function(item) {
                units[item.id] = item.pivot.sale_price;
                unitsPrice[item.id] = item.pivot.sale_price;
                unitsCost[item.id] = item.pivot.cost_price;
                $('#invoiceProductList').find('#productID').val(item.pivot.product_id);
                if (selectedUnit == item.id) {
                    var price = item.pivot.sale_price; //item.pivot.sale_price;
                    //alert(item.sale_price);
                    if ($('#invoiceType').val() != 'sales') {
                        price = item.pivot.cost_price; // item.pivot.cost_price;
                    } else {
                        if ($("#priceType").val() == "multi") {
                            price = item.pivot.gomla_price;
                        } else if ($("#priceType").val() == "half") {
                            price = item.pivot.half_gomla_price;
                        } else if ($("#priceType").val() == "gomla_gomla_price") {
                            price = item.pivot.gomla_gomla_price;
                        }
                    }
                    price = parseFloat(price).toFixed(2);
                    var costv = item.cost_price;
                    costv = parseFloat(costv).toFixed(1);
                    @if ($settings['rounding_up'] == 1)
                        if ($('#invoiceType').val() == 'sales')
                            price = Math.ceil(price);
                        //costv = Math.ceil(costv);
                    @endif

                    $('#invoiceProductList').find('#unitPrice').val(price);
                    $('#invoiceProductList').find('#customer_price').val(item.pivot.customer_price);

                    $('#invoiceProductList').find('#CostPriceSpan').html(costv);
                    $('#invoiceProductList').find('#unitCost').val(costv);
                }
                units[item.id] = item.name;
            });
            var selectedStore = $('#productStores').val();
            $.each(suggestion.product_store, function(index, item) {
                //console.log(decimalToFraction(item.pivot.qty-item.pivot.sale_count));
                if (selectedStore == item.id) {
                    var avilable = item.pivot.qty - item.pivot.sale_count;
                    //var qty = new Fraction(avilable);
                    //var qty = qty.toFraction(true); //
                    avilable = Number((avilable).toFixed(1));

                    $('#invoiceProductList').find('#unitQty').html(avilable + ' ' + units[item.pivot
                        .unit_id]);
                    $('#invoiceProductList').find('#unitQty').attr('avilable', avilable);
                    if (avilable > 0) {
                        $('#unitQty').css('background-color', '#008d4c');
                    } else {
                        $('#unitQty').css('background-color', '#ac2925');
                        @if ($type == 'sales' && $settings['can_order_unavilable_qty'] == 2)
                            swal({
                                title: 'خطأ',
                                text: "الكمية غير متاحة",
                                type: "error",
                                confirmButtonText: "تمام",
                            });
                        @endif
                    }

                    $('#productQty').focus();
                    $('#productQty').select();
                    $('#invoiceProductList').find('#storeUnitName').html(units[item.pivot.unit_id]);

                    if (detectMob()) {
                        addRow();
                    }
                }
            });
        }

        $('#productQty').focus();
        $('#productQty').select();
    });

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
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() ||
                    isMobile.Windows());
            }
        };
        return isMobile.any();
        //return ( ( window.innerWidth <= 800 ) && ( window.innerHeight <= 600 ) );
    }
    $typeaheadSearch.typeahead({
        highlight: true
    }, {
        name: 'products',
        limit: 25,
        display: function(suggestion) {
            return suggestion.name;
        },
        source: new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: "{{ route('products.getProductList') }}",
                prepare: function(query, settings) {
                    $('.loader').removeClass('hide');
                    settings.url = "{{ route('products.getProductList') }}" + '?q=' + query +
                        '&category_id=' + $('#category_id').val() + '&store_id=' + $(
                            '#productStores').val();
                    @if ($type != 'sales')
                        settings.url += '&allitems=1';
                    @endif
                    return settings;
                },
                filter: function(data) {
                    $('.loader').addClass('hide');
                    return data;
                }
            }
        }),
        templates: {
            empty: "<div class='empty s-row s-header'>لا توجد نتائج للبحث</div>",
            header: function() {
                return '  <div class="s-row s-header">\n' +
                    '                    <div class="s-cell">#</div>\n' +
                    '                    <div class="s-cell {{ $settings['showImage'] == 2 ? 'hide' : '' }}">الصورة</div>\n' +
                    '                    <div class="s-cell">الصنف</div>\n' +
                    '                    <div class="s-cell {{ $settings['show_category_in_invoice'] == 2 ? 'hide' : '' }}">الفئة</div>\n' +
                    '                    <div class="s-cell {{ $settings['show_cost_price'] == 2 ? 'hide' : '' }} ">التكلفة</div>\n' +
                    '                    <div class="s-cell">البيع</div>\n' +
                    '                    <div class="s-cell">الكمية</div>\n' +
                    '                </div>';
            },
            suggestion: function(suggestion) {
                var price = "";
                var cost = "";
                suggestion.product_unit.map(function(item) {
                    price = item.pivot.sale_price;
                    if ($('#invoiceType').val() != 'sales') {
                        price = item.pivot.cost_price; // item.pivot.cost_price;
                    } else {
                        if ($("#priceType").val() == "multi") {
                            price = item.pivot.gomla_price;
                        } else if ($("#priceType").val() == "half") {
                            price = item.pivot.half_gomla_price;
                        } else if ($("#priceType").val() == "gomla_gomla_price") {
                            price = item.pivot.gomla_gomla_price;
                        }
                    }
                    if (parseFloat(item.pivot.cost_price))
                        cost = item.cost_price;
                });
                @if ($settings['rounding_up'] == 1)
                    if ($('#invoiceType').val() == 'sales')
                        price = Math.ceil(price);
                @endif
                var avilable = "";
                var q = 0;
                $.each(suggestion.product_store, function(index, item) {
                    q = parseFloat(item.pivot.qty - item.pivot.sale_count).toFixed(1);
                    avilable += item.name + " : " + (q) + "<br/>";
                });
                return '  <div class="s-row">\n' +
                    '                    <div class="s-cell">' + suggestion.id + '</div>\n' +
                    '                    <div class="s-cell {{ $settings['showImage'] == 2 ? 'hide' : '' }}"><img style="width:80px;" src="' +
                    suggestion.img + '"/></div>\n' +
                    '                    <div class="s-cell">' + suggestion.full_name + '</div>\n' +
                    '                    <div class="s-cell {{ $settings['show_category_in_invoice'] == 2 ? 'hide' : '' }}">' +
                    suggestion.category.name + '</div>\n' +
                    '                    <div class="s-cell {{ $settings['show_cost_price'] == 2 ? 'hide' : '' }}">' +
                    cost + '</div>\n' +
                    '                    <div class="s-cell">' + price + '</div>\n' +
                    '                    <div class="s-cell">' + avilable + '</div>\n' +
                    '                </div>';
            }
        }
    });

    /*$(document).on('typeahead:rendered', function () {
        var code = $('input.typeahead.tt-input').val();
        //console.log(code.indexOf(' '));
        if(code.length>=10 && code.indexOf(' ') == -1){
            $('.tt-selectable').first().click();
            addRow();
        }
    });*/
    $(document).on("change", "#productStores,#unitList,#priceType", function(e) {
        e.preventDefault();
        if ($('.tt-selectable').length) {
            var value = $typeaheadSearch.val();
            var id = $('#invoiceProductList').find('#productID').val();
            //$typeaheadSearch.trigger('selected', {"id": id, "value": value});
            //$typeaheadSearch.('')
            //$typeaheadSearch.trigger('change');
            $typeaheadSearch.val(value).trigger('select');
            setTimeout(function() {
                if ($('.tt-selectable').length == 1) {
                    $('.tt-selectable').first().click();
                }
            }, 1000)


        }
    });

    $(document).on('keydown', 'input.typeahead', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            addRow();
            return false;
        }
    });
    $('input.qty,#unitPrice,.marketInput').on('keyup', function(e) {
        e.preventDefault();
        if (detectMob()) {
            addRow();
        }
    });
    $('input.qty,#unitPrice').on('keydown', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            addRow();
        }
    });
    $('input.qty,#unitPrice').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            addRow();
        }
    });
    $(document).on("click", ".btn-danger", function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        calculateTotal();
    });


    $(document).on("click", ".switchStatus", function(e) {
        e.preventDefault();
        var link = $(this);
        var oldV = link.find(".stateValue").val();
        if (oldV == 1) {
            link.find('.stateIcon').attr('src', "{{ asset('icons/no.png') }}");
            link.find(".stateValue").val(0);
        } else {
            link.find('.stateIcon').attr('src', "{{ asset('icons/yes.png') }}");
            link.find(".stateValue").val(1);
        }
    });


    $(document).on("input", "#tax", function(e) {
        calculateTotal();
    });
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
            if (grandtotal == paid) {
                $("#paid").val(0);
                $("#due").val(grandtotal);
            }
        } else {
            var due = 0;
            if ($("#paymentMethod").val() == 'cash' || $("#paymentMethod").val() == 'visa') {
                $("#paid").val(grandtotal);
                $("#due").val(0);
            } else {
                due = grandtotal - paid;
                due = parseFloat(due).toFixed(2);
                $("#due").val(due);
            }
        }
        /*if($("#paymentMethod").val()=='delayed') {
            $("#due").val(grandtotal);
            $("#paid").val(0);
        }else {
            var paid = parseFloat($("#paid").val());
            grandtotal -= paid;
            due = grandtotal;
            $("#due").val(grandtotal);
        }*/
        var TotalBal = parseFloat(due) + parseFloat(lastBalance);
        //console.log(TotalBal);
        var totalBalance = TotalBal.toFixed(1);
        $("#totalBalance").val(totalBalance);
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
    $(document).on('click', '.saveandPrintBarcode', function(e) {
        e.preventDefault();
        $('#saveandPrintBarcode').val('1');
        $('form').submit();
    });


    $(document).on("click", ".profit", function(e) {
        e.preventDefault();
        var btn = $(this);
        var profit = 0;
        $(".itemCost").each(function() {
            var itemCost = $(this).val();
            var itemPrice = $(this).closest('tr').find('input.itemPrice').val();
            var itemQty = $(this).closest('tr').find('input.itemQty').val();
            profit += itemQty * itemPrice - itemQty * itemCost;
        });
        var discountPercent = $("#discount_type").is(':checked');
        var discount = parseFloat($("#discount").val());

        var grandtotal = $("#total").val();
        if (discountPercent) {
            discount = (grandtotal * (discount / 100));
        }
        profit -= discount;
        swal({
            title: 'الربح',
            text: "ربحك من هذه الفاتورة = " + parseFloat(profit).toFixed(2) + " ",
            type: "success",
            confirmButtonText: "تمام",
        });
    });
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
    $('#personList').trigger('change');
    $(document).on('ifChanged', '#discount_type,.use_pointInput', function() {
        //$('#discount_type').on('ifChanged', function(){
        //$("#paid").trigger("input");
        calculateTotal();
    });

    $(document).on("input", "#discount", function(e) {
        calculateTotal();
    });

    //$("#discount_type").trigger("ifChanged");
    $(document).on("change", "#paymentMethod", function(e) {
        if ($(this).val() == 'visa') {
            $("#visaAuthCode").removeClass('hide');
            $("#visaAuthCode input").attr('required', true);
        } else {
            $("#visaAuthCode").addClass('hide');
            $("#visaAuthCode input").attr('required', false);
        }
        calculateTotal();
    });
    //$(document).on('click','input[type=text]',function(){ this.select(); });
    $(document).on("change", ".itemQty,.itemPrice,.itemdiscount1, .itemdiscount2", function(e) {
        var row = $(this).closest('tr');
        var itemdiscount1 = row.find(".itemdiscount1").val();
        var itemdiscount2 = row.find(".itemdiscount2").val();
        itemdiscount2 = parseFloat(itemdiscount2);
        var qty = row.find(".itemQty").val();
        var itemPrice = row.find(".itemPrice").val();
        var itemQty = parseFloat(qty);
        var itemPrice = parseFloat(itemPrice);
        var total = itemQty * itemPrice;
        if (itemdiscount1) {
            itemdiscount1 = parseFloat(itemdiscount1);
            total -= (total * itemdiscount1 / 100);
        }
        if (itemdiscount2) {
            itemdiscount2 = parseFloat(itemdiscount2);
            total -= (total * itemdiscount2 / 100);
        }
        row.find(".itemTotal").val(total.toFixed(2));
        var cost = row.find(".unitsPriceList option:selected").attr('cost');
        if (parseFloat(cost) > parseFloat(itemPrice)) {
            row.removeClass('bg-success');
            row.addClass('bg-danger');
            @if ($type == 'sales' && $settings['can_sell_loss'] == 2)
                swal({
                    title: 'خطأ خسارة',
                    text: "سعر التكلفة أكبر من سعر البيع",
                    type: "error",
                    confirmButtonText: "تمام",
                });
                row.find(".itemPrice").val(cost);
            @endif
        } else {
            row.removeClass('bg-danger');
            row.addClass('bg-success');
        }
        calculateTotal();
    });
    $("#invoiceTable").find(".itemQty:first").trigger("change");
    $(document).on("change", ".unitsPriceList", function(e) {
        var row = $(this).closest('tr');
        var price = row.find(".unitsPriceList option:selected").attr('price');
        var cost = row.find(".unitsPriceList option:selected").attr('cost');
        price = parseFloat(price);
        var itemPrice = row.find(".itemPrice").val(price);
        row.find(".itemCost").val(cost);
        row.find(".itemPrice").trigger("change");
    });
    $(document).on("change", ".salePersonSelect", function(e) {
        var manager_id = $(".salePersonSelect option:selected").attr('manager_id');
        $("#manager_id").val(manager_id);
        if ($(this).val()) {
            $.ajax({
                url: "{{ route('getSalesDebt') }}",
                type: 'GET',
                data: {
                    'sale_id': $(this).val()
                },
                success: function(result) {
                    if (result) {
                        $("#salesDept").html("مديونيات المندوب: " + result);
                        $("#salesDept").removeClass('hide');
                    } else {
                        $("#salesDept").addClass('hide');
                    }
                }
            });
        }
    });
    $(".salePersonSelect").trigger("change");
    $(document).on('ifChanged', '#is_new', function() {
        if ($(this).is(':checked')) {
            $(".addNewItem").trigger('click');
        }
    });

    function addRow() {
        var isService = $("#isService").val();
        var bounse = $("#bounse").val();
        var bounse_unit_id = $("#bounse_unit_id").val();
        var bounseUnitText = $("#bouns_unit_id option[value='" + bounse_unit_id + "']").text();
        var productID = $("#productID").val();
        //var marketer= $("#marketer").val();
        var marketer = $(".marketInput:first").val();
        var isnew = $('#is_new').is(':checked');
        if (!productID && !isnew) {
            return false;
        }
        var customer_price = $("#customer_price").val();
        var unitPrice = parseFloat($("#unitPrice").val());
        var cost = parseFloat($("#unitCost").val());
        var canLoss = parseFloat("{{ $settings['can_sell_loss'] }}");
        if (!unitPrice && canLoss == 2) {
            swal({
                title: 'خطأ فى السعر',
                text: "لابد من اضافة سعر للصنف",
                type: "error",
                confirmButtonText: "تمام",
            });
            return false;
        }
        @if ($type == 'sales' && $settings['can_sell_loss'] == 2)
            if (unitPrice < cost) {
                swal({
                    title: 'خطأ خسارة',
                    text: "سعر التكلفة أكبر من سعر البيع",
                    type: "error",
                    confirmButtonText: "تمام",
                });
                return false;
            }
        @endif
        var productQty = parseFloat($("#productQty").val());
        if (isNaN(productQty)) {
            swal({
                title: 'خطأ فى إدخال الكمية',
                text: "يجب ان تكون الكمية رقم وليس حروف",
                type: "error",
                confirmButtonText: "تمام",
            });
            return false;
        }
        var allqty = parseFloat($('#invoiceProductList').find('#unitQty').attr('avilable'));
        @if ($type == 'sales' && $settings['can_order_unavilable_qty'] == 2)
            if ($('[name="product[' + num + '][qty]"]').val()) {
                allqty += parseFloat($('[name="product[' + num + '][qty]"]').val());
            }
        @endif
        var total = unitPrice * productQty;
        total = parseFloat(total).toFixed(2);
        var unitName = $("#unitList option:selected").text();
        var unit_id = $("#unitList option:selected").val();
        $("#unitList").val(unit_id);
        var productName = isnew ? $('input.typeahead.tt-input').val() : $("#productName").val();
        var storeName = $("#productStores option:selected").text();
        var store_id = $("#productStores option:selected").val();
        var rowClass = "rowelement" + productID + '_' + store_id + '_' + unit_id;
        if (!productID) {
            productID = 'new' + $("#invoiceTable tr").length;
            rowClass = "rowelement" + Math.random().toString(36).substr(2, 5) + '_' + store_id + '_' + unit_id;
        }
        if ($('#invoiceTable tr').length) {
            @if (!empty($order->id))
                num = parseInt($(".rowIndex:last").val()) + 1; //$('.'+rowClass).index() +1;
            @else
                num = parseInt($(".rowIndex:first").val()) + 1;
            @endif
        } else {
            var num = $('#invoiceTable tr').length + 1;
        }
        if ($('.' + rowClass).length) {
            num = $('.' + rowClass).find('.rowIndex').val();
        }
        var cloneUnitList = '<select name="product[' + num + '][unit_id]" class="unitsPriceList">';
        $("#unitList > option:not('.hide')").each(function() {
            if (unit_id == this.value) {
                cloneUnitList += '<option selected cost="' + unitsCost[this.value] + '" price="' + unitsPrice[
                    this.value] + '" value="' + this.value + '">' + this.text + '</option>';
            } else {
                cloneUnitList += '<option cost="' + unitsCost[this.value] + '" price="' + unitsPrice[this
                    .value] + '" value="' + this.value + '">' + this.text + '</option>';
            }
        });
        cloneUnitList += '</select>';
        if ($('.' + rowClass).length) {
            productQty += parseInt($('.' + rowClass).find('.itemQty').val());
        }
        @if ($type == 'sales' && $settings['can_order_unavilable_qty'] == 2)
            if (false && parseFloat(productQty) > parseFloat(allqty)) {
                swal({
                    title: 'خطأ',
                    text: "الكمية غير متاحة",
                    type: "error",
                    confirmButtonText: "تمام",
                });
                return false;
            }
        @endif

        if ($('.' + rowClass).length) {
            var oldqty = $('.' + rowClass).find(".itemQty").val();
            oldqty += " " + $('.' + rowClass).find(".rowUnit_name").val();
            total = unitPrice * productQty;
            total = parseFloat(total).toFixed(2);
            num = $('.' + rowClass).find('.rowIndex').val();
            var completeProcess = false;

            swal({
                    title: " تحذير! الصنف مكرر بكمية " + oldqty,
                    text: "هل تريد الإضافة عليه؟ " + " ستصبح الكمية الجديدة " + productQty + " " + unitName,
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
                        '<input type="hidden" name="productNew[' + num + '][isnew]" value="' + isnew + '">' +
                        '<input type="hidden" name="product[' + num + '][is_service]" value="' + isService + '">' +
                        '<input type="hidden" name="product[' + num + '][store_name]" value="' + storeName + '">' +
                        '<input type="hidden" name="product[' + num + '][customer_price]" value="' +
                        customer_price + '">' +
                        '<input class="rowUnit_name" type="hidden" name="product[' + num + '][unit_name]" value="' +
                        unitName + '">' +
                        '<input type="hidden" name="product[' + num + '][product_name]" value="' + productName +
                        '">' +
                        '<input class="itemCost" type="hidden" name="product[' + num + '][cost]" value="' + cost +
                        '">' +
                        num +
                        '<a href="#" class="switchStatus"> <img style="width: 20px;" class="stateIcon" src="{{ asset('icons/yes.png') }}" /> <input class="stateValue"  type="hidden" value="1" name="product[' +
                        num + '][status]" /> </a>' +
                        '</td>' +
                        '<td><input type="hidden" name="product[' + num + '][store_id]" value="' + store_id + '">' +
                        storeName + '</td>' +
                        '<td><input type="hidden" name="product[' + num + '][product_id]" value="' + productID +
                        '">' + productName + '</td>' +
                        '<td><input class = "itemQty tdinput" type="number" name="product[' + num +
                        '][qty]" value="' + productQty + '"></td>' +
                        '<td><input class="itemPrice tdinput" type="number" name="product[' + num +
                        '][price]" value="' + unitPrice + '"></td>' +
                        '<td>' + cloneUnitList + '</td>';
                    //'<td><input type="hidden" name="product['+num+'][unit_id]" value="'+unit_id+'">'+unitName+'</td>';
                    @if ($settings['use_bounse'] == 1)
                        data += '<td>' +
                            '<input type="hidden" name="product[' + num + '][bounse]" value="' + bounse + '">' +
                            '<input type="hidden" name="product[' + num + '][bounse_unit_id]" value="' +
                            bounse_unit_id + '">' +
                            '<input type="hidden" name="product[' + num + '][bounseUnitText]" value="' +
                            bounseUnitText + '">' +
                            bounse + " " + bounseUnitText +
                            '</td>';
                    @endif
                    data += '<td><input class="itemTotal tdinput" readonly type="text" name="product[' + num +
                        '][total]" value="' + total + '"></td>';
                    @if ($type == 'sales' && $useMarket)
                        data += '<td><input class="marketer" type="hidden" name="product[' + num +
                            '][markter]" value="' + marketer + '">' + marketer + '</td>';
                    @endif
                    data += '<td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>';
                    if ($('.' + rowClass).length) {
                        $('.' + rowClass).html(data);
                    } else {
                        $("#invoiceTable").append('<tr class="' + rowClass + '">' + data + '</tr>');
                    }
                    calculateTotal();
                    toastr.success("تمت إضافة " + productQty + " " + unitName + " للصنف " + productName + " من " +
                        storeName + " للفاتورة");
                    $typeaheadSearch.typeahead('val', '');
                    $typeaheadSearch.focus();
                    $("#customer_price").val('');
                    $("#unitPrice").val('');
                    $("#productID").val('');
                    $("#marketer").val(0);
                    $("#productQty").val(1);
                    $("#CostPriceSpan").html('');
                    setTimeout("$('[name=search_input]').focus();", 500);
                    return true;

                });

        } else {
            var data = '<td>' +
                '<input type="hidden" class="rowIndex" value="' + num + '">' +
                '<input type="hidden" name="productNew[' + num + '][isnew]" value="' + isnew + '">' +
                '<input type="hidden" name="product[' + num + '][is_service]" value="' + isService + '">' +
                '<input type="hidden" name="product[' + num + '][store_name]" value="' + storeName + '">' +
                '<input type="hidden" name="product[' + num + '][customer_price]" value="' + customer_price + '">' +
                '<input class="rowUnit_name" type="hidden" name="product[' + num + '][unit_name]" value="' + unitName +
                '">' +
                '<input type="hidden" name="product[' + num + '][product_name]" value="' + productName + '">' +
                '<input class="itemCost" type="hidden" name="product[' + num + '][cost]" value="' + cost + '">' +
                num +
                '<a href="#" class="switchStatus"> <img style="width: 20px;" class="stateIcon" src="{{ asset('icons/yes.png') }}" /> <input class="stateValue"  type="hidden" value="1" name="product[' +
                num + '][status]" /> </a>' +
                '</td>' +
                '<td><input type="hidden" name="product[' + num + '][store_id]" value="' + store_id + '">' + storeName +
                '</td>' +
                '<td><input type="hidden" name="product[' + num + '][product_id]" value="' + productID + '">' +
                productName + '</td>' +
                '<td><input class = "itemQty tdinput" type="text" name="product[' + num + '][qty]" value="' +
                productQty + '"></td>' +
                '<td><input class="itemPrice tdinput" type="text" name="product[' + num + '][price]" value="' +
                unitPrice + '"></td>' +
                '<td>' + cloneUnitList + '</td>';
            @if ($settings['use_bounse'] == 1)
                data += '<td>' +
                    '<input type="hidden" name="product[' + num + '][bounse]" value="' + bounse + '">' +
                    '<input type="hidden" name="product[' + num + '][bounse_unit_id]" value="' + bounse_unit_id + '">' +
                    '<input type="hidden" name="product[' + num + '][bounseUnitText]" value="' + bounseUnitText + '">' +
                    bounse + " " + bounseUnitText +
                    '</td>';
            @endif
            data += '<td><input class="itemTotal tdinput" readonly type="text" name="product[' + num +
                '][total]" value="' + total + '"></td>';
            @if ($type == 'sales' && $useMarket)
                data += '<td><input class="marketer" type="hidden" name="product[' + num + '][markter]" value="' +
                    marketer + '">' + marketer + '</td>';
            @endif
            data += '<td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>';
            if ($('.' + rowClass).length) {
                $('.' + rowClass).html(data);
            } else {
                @if (!empty($order->id))
                    $("#invoiceTable").append('<tr class="bg-success ' + rowClass + '">' + data + '</tr>');
                @else
                    $("#invoiceTable").prepend('<tr class="bg-success ' + rowClass + '">' + data + '</tr>');
                @endif
            }
            calculateTotal();
            toastr.success("تمت إضافة " + productQty + " " + unitName + " للصنف " + productName + " من " + storeName +
                " للفاتورة");
            $typeaheadSearch.typeahead('val', '');
            $typeaheadSearch.focus();
            $("#unitPrice").val('');
            $("#productID").val('');
            $("#marketer").val(0);
            $("#productQty").val(1);
            $("#CostPriceSpan").html('');
            return false;
        }
    }

    function calculateTotal() {
        var grandtotal = 0;
        $(".itemTotal").each(function() {
            if ($(this).val()) {
                grandtotal += parseFloat($(this).val());
            }
        });

        grandtotal = parseFloat(grandtotal).toFixed(2);
        $("#total").val(grandtotal);
        if ($('.use_pointInput').is(':checked')) {
            var user_point = parseFloat($(".userpointSpan").html());
            var point_value = parseFloat("{{ $settings['point_value'] }}");
            var points = user_point * point_value;
            if (grandtotal > points) {
                $("#discount").val(points);
            } else {
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
        if ($("#lastBalance").val()) {
            lastBalance = parseFloat($("#lastBalance").val());
        }

        var TotalBal = parseFloat($("#due").val()) + parseFloat(lastBalance);
        var totalBalance = TotalBal.toFixed(1);
        $("#totalBalance").val(totalBalance);
    }

    $(document).on("input", "#QestNumInput", function(e) {
        var QestNumInput = parseInt($(this).val());
        $(".calanderList").find(".itemCalnader").remove();
        for (var i = 0; i < QestNumInput; i++) {
            $(".addCalander").trigger('click');
        }
        calculateTotalQest();
    });
    $(document).on("input", ".QestValue", function(e) {
        calculateTotalQest();
    });
    $(".QestValue:first").trigger('input');

    function calculateTotalQest() {
        var totalQest = 0;
        var QestValue = 0;
        $(".calanderList .itemCalnader").each(function() {
            var v = $(this).find('.QestValue').val();
            if (v) {
                QestValue = parseFloat(v);
                totalQest += QestValue;
            }
        });
        $("#totalQest").html("إجمالى اﻷقساط = " + totalQest);
        var count = $(".calanderList").find(".itemCalnader").length;
        $("#QestCount").html("عدد اﻷقساط = " + count);
    }
</script>
