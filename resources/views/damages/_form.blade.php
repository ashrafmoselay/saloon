<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>@lang('front.store')</label>
                            <select id="store_id" class="form-control select2" style="width: 100%;">
                                @php $stores = \App\Store::get(); @endphp
                                @foreach($stores as $s)
                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>سبب الهالك</label>
                            <select id="damageoptions" class="form-control select2" style="width: 100%;">
                                @foreach(\App\DamageOption::get() as $s)
                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>ملحوظة</label>
                            <input id="note" value="" type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">@lang('front.product')</label>
                            <input autocomplete="off" class="typeahead form-control selectProduct" type="text">
                            <input type="hidden" value="" id="productID">
                            <input type="hidden" value="" id="productName">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('front.quantity')</label>
                            <div class="input-group">
                                <input id="productQty" value="1" min="0" type="number" type="text" class="form-control qty" >
                                <span style="color:#ffffff;" id="unitQty" class="input-group-addon btn">
			                            0
                                    </span>
                                <span style="width: 100px;" class="unit input-group-addon">
                                        <select id="unitList" class="form-control unitList" required style="width: 100%;">
                                            @foreach(\App\Unit::latest()->get() as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>سبب الهالك</th>
                                    <th>ملحوظة</th>
                                    <th>@lang('front.product')</th>
                                    <th>@lang('front.store')</th>
                                    <th>@lang('front.quantity')</th>
                                    <th>@lang('front.unit')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="invoiceTable">
                                @if(isset($damage->id))
                                    <tr>
                                        <td>
                                            1
                                            <input type="hidden" name="product[{{$damage->product_id}}][store_id]" value="{{$damage->store_id}}">
                                            <input type="hidden" name="product[{{$damage->product_id}}][product_id]" value="{{$damage->product_id}}">
                                            <input type="hidden" name="product[{{$damage->product_id}}][qty]" value="{{$damage->qty}}">
                                            <input type="hidden" name="product[{{$damage->product_id}}][unit_id]" value="{{$damage->unit_id}}">
                                            <input type="hidden" name="product[{{$damage->product_id}}][creator_id]" value="{{$damage->creator_id}}">
                                            <input type="hidden" name="product[{{$damage->product_id}}][damageoption_id]" value="{{$damage->damageoption_id}}">
                                        </td>
                                        <td>{{optional($damage->damageoption)->name}}</td>
                                        <td>{{$damage->note}}</td>
                                        <td>{{optional($damage->product)->name}}</td>
                                        <td>{{optional($damage->store)->name}}</td>
                                        <td>{{$damage->qty}}</td>
                                        <td>{{optional($damage->unit)->name}}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
</section>
@push('css')
<style>
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
@push('js')
<script>

    $(".select2").select2();
    $('form').validator();
    var units = [[]];
    var $typeaheadSearch = $('.typeahead');
    $typeaheadSearch.on('typeahead:select', function (e, suggestion) {
        var selectedUnit = $('#unitList').val();
        $('#productID').val(suggestion.id);
        $("#productName").val(suggestion.name);
        $('#unitList > option').each(function(){
            if(!$(this).hasClass('hide')){
                $(this).addClass('hide');
            }
        });
        suggestion.product_unit.map(function(item){
            $("#unitList option[value='" + item.id + "']").removeClass('hide');
        });
        if($("#unitList option[value='" + $("#unitList").val() + "']").hasClass('hide')){
            $("#unitList option:not('.hide'):last").prop('selected',true);
        }
        suggestion.product_unit.map(function(item){
            units[item.id] = item.pivot.sale_price;
            units[item.id] = item.name;
        });
        var selectedStore = $('#store_id').val();
        $.each(suggestion.product_store, function( index, item ) {
            if(selectedStore==item.id) {
                var avilable = item.pivot.qty - item.pivot.sale_count;
                avilable = Number((avilable).toFixed(1));
                $('#unitQty').html(avilable + ' '+units[item.pivot.unit_id]);
                $('#unitQty').attr('avilable',avilable);
                $('#unitQty').attr('avilableUnit',item.pivot.unit_id);
                if(avilable>0){
                    $('#unitQty').css('background-color', '#008d4c');
                }else{
                    $('#unitQty').css('background-color', '#ac2925');
                }
                $('#productQty').select();
            }
        });
    });


    $typeaheadSearch.typeahead({highlight: true}, {
        name: 'products',
        display: function(suggestion){
            return suggestion.name;
        },
        source: new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: "{{route('products.getProductList')}}",
                prepare: function (query, settings) {
                    settings.url = "{{route('products.getProductList')}}" + '?q=' + query+'&store_id='+$('#store_id').val();
                    settings.url += '&allitems=1';
                    return settings;
                }
            }
        }),
        templates: {
            header:function(){
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
                    price = item.pivot.sale_price;
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
                    '                    <div class="s-cell">'+suggestion.category.name+'</div>\n' +
                    '                    <div class="s-cell">'+cost+'</div>\n' +
                    '                    <div class="s-cell">'+price+'</div>\n' +
                    '                    <div class="s-cell">'+avilable+'</div>\n' +
                    '                </div>';
            }
        }
    });

    $(document).on("change","#store_from_id,#unitList,#priceType",function(e){
        e.preventDefault();
        if($('.tt-selectable').length){
            var value = $typeaheadSearch.val();
            $typeaheadSearch.val(value).trigger('select');
            setTimeout(function(){
                if($('.tt-selectable').length==1)
                {
                    $('.tt-selectable').first().click();
                }
            },1000)


        }
    });
    $('input.qty').on('keydown', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            addRow();
        }
    });

    function addRow(){

        var productID= $("#productID").val();
        if(!productID){
            return false;
        }
        var damageoption_id = $("#damageoptions option:selected").val();
        var damageoption_name = $("#damageoptions option:selected").text();
        var store_id = $("#store_id option:selected").val();
        var allqty = parseFloat($('#unitQty').attr('avilable'));
        var avilableUnit = $('#unitQty').attr('avilableUnit');
        var note = $("#note").val();
        var productQty= parseFloat($("#productQty").val());
        var unit_id= $("#unitList option:selected").val();
        if(productQty > allqty && unit_id == avilableUnit){
            swal({
                title:'خطأ', text:"الكمية المراد إهلاكها أكبر من الكمية المتاحة فى "+storeFromName,type:"error",confirmButtonText: "تمام",
            });
            return false;
        }
        var unitName= $("#unitList option:selected").text();
        var productName = $("#productName").val();
        var store_name = $("#store_id option:selected").text();
        var rowClass = "rowelement"+productID+'_'+unit_id;
        @if(isset($damage->id))
            $('#invoiceTable').html("");
        @endif
            var num = $('#invoiceTable tr').length+1;
            $("#invoiceTable").append(
                '<tr class="'+rowClass+'">' +
                '<td>'+
                '<input type="hidden" name="product['+productID+'][store_id]" value="'+store_id+'">'+
                '<input type="hidden" name="product['+productID+'][product_id]" value="'+productID+'">'+
                '<input type="hidden" name="product['+productID+'][qty]" value="'+productQty+'">'+
                '<input type="hidden" name="product['+productID+'][unit_id]" value="'+unit_id+'">'+
                '<input type="hidden" name="product['+productID+'][damageoption_id]" value="'+damageoption_id+'">'+
                '<input type="hidden" name="product['+productID+'][note]" value="'+note+'">'+
                    num+
                '</td>' +
                '<td>'+damageoption_name+'</td>'+
                '<td>'+note+'</td>'+
                '<td>'+productName+'</td>'+
                '<td>'+store_name+'</td>'+
                '<td>'+productQty+'</td>'+
                '<td>'+unitName+'</td>'+
               '<td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>' +
                '</tr>'
            );
            $typeaheadSearch.typeahead('val','');
            $("#productID").val('');
            $typeaheadSearch.focus();
            return false;
    }

    $(document).on("click",".btn-danger",function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
    });
</script>
@endpush
