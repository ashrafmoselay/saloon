<section class="content">
    <div class="box">
            <div class="box-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">@lang('front.basics')</a></li>
                    @if(!$is_raw && $settings['industrial']==2)
                    <li><a data-toggle="tab" href="#menu4">الخامات</a></li>
                    @endif
                    <li><a data-toggle="tab" href="#menu1">@lang('front.pricesandunits')</a></li>

                    @if(isset($settings['use_color_size_qty']) && $settings['use_color_size_qty']==1)
                        <li><a data-toggle="tab" href="#comb">الالوان والمقاسات والكميات</a></li>
                    @else
                        <li><a data-toggle="tab" href="#menu2">@lang('front.storesandquntity')</a></li>
                    @endif
                    <li><a data-toggle="tab" href="#menu5">@lang('front.notes')</a></li>

                </ul>
                <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="col-md-12">
                                <div class="box__">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('front.name')</label>
                                                    <input type="hidden" name="product[is_raw_material]" value="{{$is_raw??0}}">
                                                    <input value="{{$product->name}}" required name="product[name]" type="text" class="form-control disableEnter">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('front.observe')</label>
                                                    <input required value="{{isset($product->observe)?$product->observe:1}}" name="product[observe]" type="number" class="form-control disableEnter">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('front.parent')</label>
                                                    <select required name="product[main_category_id]" class="form-control selectCat" style="width: 100%;">
                                                        @foreach($categories->where('type',1) as $cat)
                                                            <option half_percentage="{{$cat->half_percentage}}" percentage3="{{$cat->percentage3}}" percentage2="{{$cat->percentage2}}" rel="{{$cat->percentage}}" {{($product->main_category_id==$cat->id)?'selected':''}} value="{{$cat->id}}">{{$cat->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('front.child')</label>
                                                    <select name="product[sub_category_id]" class="form-control select2" style="width: 100%;">
                                                        @foreach($categories->where('type',2) as $cat)
                                                            <option {{($cat->id==$product->sub_category_id)?'selected':''}} value="{{$cat->id}}">{{$cat->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('front.barcode')</label>
                                                    <input id="barecode" value="{{($product->code)?$product->code:rand(10000,99999).rand(10000,99999)}}" name="product[code]" type="text" class="form-control disableEnter">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('front.Model')</label>
                                                    <input value="{{$product->model}}" name="product[model]" type="text" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('front.image')</label>
                                                    <input id="FileUploade" name="image" type="file" class="form-control ">
                                                    @if(optional($product->getFirstMedia('images'))->getUrl())
                                                        <img style="width: 80px;" src="{{optional($product->getFirstMedia('images'))->getUrl()}}" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <div class="col-md-12">
                                <div class="box__">
                                    <div class="box-body">
                                        <div class="row">
                                            @php
                                                $selectedUnit = $product->productUnit()->orderBy('pieces_num')->get();
                                                $unit1 = $selectedUnit[0]??'';
                                                $unit2= $selectedUnit[1]??'';
                                                $unit3 = $selectedUnit[2]??'';
                                            @endphp
                                            @include('products.units',['unittitle'=>trans('front.small unit'),'i'=>1,'unit'=>$unit1,'description'=>'أصغر وحدة من الصنف على سبيل المثال علبة - قطعة'])
                                            @if(count($units) > 1)
                                                @include('products.units',['unittitle'=>trans('front.medium unit'),'i'=>2,'unit'=>$unit2,'description'=>'عدد ما تحتويه من الوحدة الصغري'])
                                                @include('products.units',['unittitle'=>trans('front.large unit'),'i'=>3,'unit'=>$unit3,'description'=>'عدد ما تحتويه من الوحدة المتوسطة'])
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="menu4" class="tab-pane fade">
                        <div class="col-md-12">
                            <div class="box__">
                                <div class="box-body">
                                    <div class="row">
                                        @include('products.raw_matrial')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="menu2" class="tab-pane fade">
                        <div class="col-md-12">
                            <div class="box__">
                                <div class="box-body">
                                    @php
                                        $sids = [];
                                        $i = 0;
                                    @endphp
                                    @foreach($stores as $store)
                                        @php
                                            $i++;
                                            $sids[] = $store->id;

                                        @endphp
                                        @include('products.stores')
                                    @endforeach
                                    @if(isset($additinaluserstores))
                                        @foreach($additinaluserstores as $store)
                                            @php
                                                $i++;
                                                $sids[] = $store->id;
                                            @endphp
                                            @include('products.stores')
                                        @endforeach
                                    @endif
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>

                    <div id="comb" class="tab-pane fade">
                        <div class="col-md-12">
                            <div class="box__">
                                <div class="box-body">
                                    @include('products.combinations')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="menu5" class="tab-pane fade">
                        <div class="box__">
                            <div class="box-body">
                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('front.notes')</label>
                                    <textarea name="product[note]" class="form-control">{{$product->note}}</textarea>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">@lang('front.save')</button>
            </div>
        </div>
</section>
@push('css')
<style type="text/css">
    .box__{
        border-top: 2px solid #d0d0d0;
        margin-bottom: 15px;
        position: relative;
    }
    .btnx{
        position: absolute;
        top: 25px;
        left: 0;
    }
    .col-md-12.unitRow .col-md-2 {
        width: 15%;
    }
</style>
@endpush
@push('js')
<script>
    var $typeaheadSearch = $('.typeahead');
    $(function () {
        $(document).on('change','.productUnitSelector',function(){
            var selectedunit = '';
            $(".productUnitSelector").each(function(){
                option = $(this).find('option:selected');
                if(option.val()){
                    selectedunit += '<option value="'+option.val()+'">'+option.text()+'</option>';
                }
            });
            $(".storeUnites").each(function(){
                $(this).html(selectedunit);
            });

        });
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });

        $(document).on('keydown','.disableEnter', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });
        $(".select2").select2();
        $(".selectCat").select2({
            tags: true,
            //selectOnClose: true,
            //allowClear: true,
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term
                };
            }
        }).on('select2:select', function (evt) {
            $.ajax({
                type: "POST",
                url: "{{route('category.store')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    name:evt.params.data.text,
                    type:1
                },
                success: function(data)
                {
                    $(".selectCat").html(data);
                }
            });
        });

        //$('form').validator();
        $(document).on('click','.btn-danger',function(){
            $(this).closest('.unitRow').remove();
            $(this).closest('tr').remove();
        });
        $('.rawInput').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        var units = [[]];
        $typeaheadSearch.on('typeahead:select', function (e, suggestion) {
            $('#productID').val(suggestion.id);
            $('#productName').val(suggestion.name);
            $('#RawunitList > option').each(function(){
                if(!$(this).hasClass('hide')){
                    $(this).addClass('hide');
                }
            });
            suggestion.product_unit.map(function(item){
                $("#RawunitList option[value='" + item.id + "']").removeClass('hide');
            });
            if($("#RawunitList option[value='" + $("#RawunitList").val() + "']").hasClass('hide')){
                $("#RawunitList option:not('.hide'):last").prop('selected',true);
            }
            var selectedUnit = $("#RawunitList").val();
            suggestion.product_unit.map(function(item){
                var p = parseFloat(item.pivot.cost_price).toFixed(2);
                $('#rawCost').val(p);
                units[item.id] = item.name;
            });
            //$(".rawqty").focus();
            $(".rawqty").select();
            /*
            var selectedStore = $('#productStores').val();
            $.each(suggestion.product_store, function( index, item ) {
                if(selectedStore==item.id) {
                    var avilable = item.pivot.qty - item.pivot.sale_count;
                    avilable = Number((avilable).toFixed(1));
                    $('#rawunitQty').html(avilable + ' '+units[item.pivot.unit_id]);
                    $('#rawunitQty').attr('avilable',avilable);
                    if(avilable>0){
                        $('#rawunitQty').css('background-color', '#008d4c');
                    }else{
                        $('#rawunitQty').css('background-color', '#ac2925');
                    }
                    $('#rawqty').focus();
                    $('#rawqty').select();
                }
            });
            */
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
                        settings.url = "{{route('products.getProductList',['is_raw'=>1])}}" + '?q=' + query+'&store_id='+$('#productStores').val();
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

        $('input.rawqty,input.rawcolor').on('keydown', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                addRow();
            }
        });
        $('body').on('change','.selectCat',function(e){
            var option = $('option:selected', this).attr('rel');
            var gomlapercentage = $('option:selected', this).attr('percentage2');
            @if(!$product->price_percent)
            $("#pricePercentage").val(option);
            @endif
            @if(!$product->gomla_price_percent)
                $("#pricePercentagegomla").val(gomlapercentage);
            @endif
        });
        $(".selectCat").trigger("change");
        $('body').on('change','#pricePercentage',function(e){
            $(".cost_price:first").trigger("change");
        });
        $('body').on('change','#pricePercentagegomla',function(e){
            $(".cost_price:first").trigger("change");
        });
        $('body').on('change','.cost_price',function(e){
            var percentage2 = parseFloat($('.selectCat option:selected').attr('percentage2'));
            var percentage3 = parseFloat($('.selectCat option:selected').attr('percentage3'));
            var half_percentage = parseFloat($('.selectCat option:selected').attr('half_percentage'));
            var oldCost = parseFloat($(this).val());
            var elem = $(this).closest('.unitRow');
            if($("#priceCalcualtion").is(':checked')) {
                var per = parseFloat($("#pricePercentage").val());
                var pergomla = $("#pricePercentagegomla").val()?parseFloat($("#pricePercentagegomla").val()):percentage2;
                var price = calaculateCost(oldCost,per);
                elem.find('.sale_price').val(price);
                if(pergomla){
                    var price = calaculateCost(oldCost,pergomla);
                    elem.find('.gomla_price').val(price);
                }
                if(percentage3){
                    var price = calaculateCost(oldCost,percentage3);
                    elem.find('.gomla_gomla_price').val(price);
                }
                if(half_percentage){
                    var price = calaculateCost(oldCost,half_percentage);
                    elem.find('.half_gomla_price').val(price);
                }

            }
        });
        function calaculateCost(cost,percent){
            if (Boolean(percent)) {
                var cost = parseFloat(cost);
                cost =  cost + cost * (parseFloat(percent) / 100);
                return cost.toFixed(2);//Math.ceil(cost);
            }
            return 0;
        }
        $('body').on('change','.cost_price,.sale_price,.gomla_price,.half_gomla_price,.gomla_gomla_price',function(e){
            if($("#autoCalcualtion").is(':checked')) {
                var elem = $(this).closest('.unitRow');
                var className = $(e.target).attr('class');
                var className = className.replace(" ", ".");
                var nextItem = elem.next('.unitRow');
                var prevItem = elem.prev('.unitRow');
                if(nextItem){
                    var nextnextItem = nextItem.next('.unitRow');
                    calculateByUnit(elem, nextItem, className,'next');
                    if(nextnextItem){
                        calculateByUnit(nextItem, nextnextItem, className,'next');
                    }
                }
                if(prevItem){
                    var prevprevItem = prevItem.prev('.unitRow');
                    calculateByUnit(elem, prevItem, className,'prev');
                    if(prevprevItem){
                        calculateByUnit(prevItem, prevprevItem, className,'prev');
                    }
                }
                /*$(".unitRow").each(function (i) {
                    if (elem.index() != $(this).index()) {
                        calculateByUnit(elem, $(this), className);
                    }
                });*/
            }
        });
    });
    function calculateByUnit(current,unitElm,item,position){
        //alert(current.index());
        var cost = current.find('.'+item).val();
        var current_pieces_num = parseFloat(current.find('.pieces_num').val());
        var pieces_num = parseFloat(unitElm.find('.pieces_num').val());
        var cost_price = unitElm.find('.'+item);
        if(cost && current_pieces_num){
            cost = parseFloat(cost);
            var newcost = cost;
            if(position=='prev'){
                newcost = cost / current_pieces_num;
            }else{
                newcost = cost * pieces_num
            }
            cost_price.val(newcost.toFixed(1));
        }
    }
    function addRow(){

        var qty= $(".rawqty").val();
        var color_number= $(".rawcolor").val();
        var product_id= $("#productID").val();
        var rawCost = $("#rawCost").val();
        var subtotal = parseFloat(rawCost)*parseFloat(qty);
        var Rawunitval = $("#RawunitList").val();
        var RawunitText = $("#RawunitList option:selected").text();
        var productName= $("#productName").val();
        var num = $('#rawTable tr').length+1;
        var rowClass = "rowelement"+product_id;
        if($('.'+rowClass).length){
            num = $('.'+rowClass).index() +1;
        }
        if($(".iteration:last").val()){
            num = parseInt($(".iteration:last").val()) +1;
        }
        var data = '<td><input type="hidden" name="raw['+num+'][raw_material_id]" value="'+product_id+'"/>'+num+'</td>';
        data += '<td><input class="rawCost" type="hidden" value="'+rawCost+'"/>'+productName+'</td>';
        data += '<td><input class="rawQty" type="hidden" name="raw['+num+'][qty]" value="'+qty+'"/>'+qty+' ====> '+subtotal+'</td>';
        data += '<td><input type="hidden" name="raw['+num+'][color_number]" value="'+color_number+'"/>' +
            '<input type="hidden" name="raw['+num+'][raw_unit_id]" value="'+Rawunitval+'"/>'+
            '<input type="hidden" name="raw['+num+'][raw_unit_text]" value="'+RawunitText+'"/>'+
            '<input class="iteration" type="hidden" value="'+num+'">'+
            RawunitText+
            '</td>';
        data += '<td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>' ;
        if($('.'+rowClass).length){
            $('.'+rowClass).html(data);
        }else{
            $("#rawTable").append('<tr class="'+rowClass+'">' + data+ '</tr>');
        }
        $typeaheadSearch.typeahead('val','');
        $typeaheadSearch.focus();
        //$(".typeahead").val('');
        //$(".typeahead").focus();
        calculateCost();
        $(".rawqty").val(1);
        $(".rawcolor").val(0);
        //$(".rawCost").val(0);
        return false;
    }
    function calculateCost() {
        var totalCost =0;
        $("#rawTable tr").each(function(i,row) {
            var $row = $(row),
                cost = parseFloat($row.find('.rawCost').val()),
                qty = parseFloat($row.find('.rawQty').val());
            totalCost += (qty * cost);
        });
        var totalCost = parseFloat(totalCost).toFixed(2);
        $(".unitRow:first").find(".cost_price").val(totalCost);
        $(".unitRow").find(".cost_price").each(function( i ) {
            $(this).trigger("change");
        });
        //$(".unitRow:first").find(".cost_price").trigger("change");
    }
    $(document).on('change','#FileUploade',function(e){
        var file = document.getElementById("FileUploade").files[0];
        var fileExtension  = file.name.replace(/^.*\./, '');
        var allowedExtension = ['jpg', 'jpeg', 'png'];
        if(!allowedExtension.includes(fileExtension)){
            swal({title:'خطأ', text:"هذا النوع من الملفات غير مسموح به",type:"error",confirmButtonText: "Ok",});
            $(this).val('');
            return false;
        }
    });
</script>
@endpush
