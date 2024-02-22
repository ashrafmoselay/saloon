<div class="col-md-12 unitRow">

    @if($i==1)

        <div class="col-md-12 ">
            @if(count($units) > 1)
            <div class="form-group col-md-5">
                <label for="autocal">
                    <input class="flat-red" name="autocal" checked type="checkbox" id="autoCalcualtion">
                    @lang('front.Automatic price calculation for different units')
                </label>
            </div>
            @endif
            <div class="form-group col-md-4">
                <div class="input-group">
                    <div class="input-group-addon">@lang('front.Calculate price increase') <input class="flat-red" id="priceCalcualtion" name="product[is_price_percent]" @if($product->is_price_percent) checked @endif type="checkbox"></div>
                    <input class="form-control" id="pricePercentage" value="{{$product->price_percent}}" name="product[price_percent]" step="0.01" type="number" placeholder="@lang('front.The percentage of the sectoral price increase over the wholesale')">
                    <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group">
                    <input class="form-control" id="pricePercentagegomla" value="{{$product->gomla_price_percent}}" name="product[gomla_price_percent]" step="0.01" type="number" placeholder="@lang('front.Wholesale')">
                    <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                    <div title="لو علمت عليها زيادة سعر المنتج فقط اللى هتسمع وليست الفئة" class="input-group-addon">
                        <input class="flat-red" name="product_percent_only" @if($product->product_percent_only) checked @endif type="checkbox">
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="col-md-2">
        <div class="form-group">
            <label>{{$unittitle}}</label>
            <select style="width: 100%;" name="unit[{{$i}}][unit_id]" class="form-control productUnitSelector">
                @if($i!=1)
                    <option value=""></option>
                @endif
                @foreach($units as $u)
                    <option {{isset($unit->id) && $unit->id==$u->id?'selected':''}} value="{{$u->id}}">{{$u->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label title="{{$description}}" for="">@lang('front.pieces count')</label>
            @php
                if(isset($unit3->pivot->pieces_num) && $i==3 && $unit2->pivot->pieces_num>0){
                    $unitpicesNum = $unit3->pivot->pieces_num/$unit2->pivot->pieces_num;
                }
            @endphp
            @if($i==3)
                <input @if(count($units)==1 || $i==1) readonly  @endif required="" type="text" name="unit[{{$i}}][pieces_num]" class="form-control pieces_num" value="{{$unitpicesNum??0}}">
            @else
            <input title="{{$description}}" @if(count($units)==1 || $i==1 && !isset($unit->pivot->pieces_num)) readonly  @endif required="" type="text" name="unit[{{$i}}][pieces_num]" class="form-control pieces_num" value="{{isset($unit->pivot->pieces_num)?(int)$unit->pivot->pieces_num:($i==1?1:0)}}">
            @endif
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">@lang('front.cost')</label>
            <input required="" min="0" type="number" step="0.01" name="unit[{{$i}}][cost_price]" class="form-control cost_price" value="{{isset($unit->pivot->cost_price)?round($unit->pivot->cost_price,2):0}}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">@lang('front.Sector price')</label>
            <input required="" min="0" type="number" step="0.01" name="unit[{{$i}}][sale_price]" class="form-control sale_price" value="{{isset($unit->pivot->sale_price)?$unit->pivot->sale_price:0}}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">@lang('front.Half wholesale')</label>
            <input required="" min="0" type="number" step="0.01" name="unit[{{$i}}][half_gomla_price]" class="form-control half_gomla_price" value="{{isset($unit->pivot->half_gomla_price)?$unit->pivot->half_gomla_price:0}}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">@lang('front.Wholesale Price')</label>
            <input required="" min="0" type="number" step="0.01" name="unit[{{$i}}][gomla_price]" class="form-control gomla_price" value="{{isset($unit->pivot->gomla_price)?$unit->pivot->gomla_price:0}}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> @lang('front.Wholesale Wholesale')</label>
            <input required="" min="0" type="number" step="0.01" name="unit[{{$i}}][gomla_gomla_price]" class="form-control gomla_gomla_price" value="{{isset($unit->pivot->gomla_gomla_price)?$unit->pivot->gomla_gomla_price:0}}">
        </div>
    </div>
    @if(isset($settings['ShowCustomerPrice']) && $settings['ShowCustomerPrice']==1)
    <div class="col-md-4">
        <div class="form-group">
            <label for="">سعر المستهلك</label>
            <input min="0" type="number" step="0.01" name="unit[{{$i}}][customer_price]" class="form-control" value="{{isset($unit->pivot->customer_price)?$unit->pivot->customer_price:0}}">
        </div>
    </div>
    @endif

    {{--<div>
        <a class="btn btn-danger btn-sm btnx"  href="#" role="button">-</a>
    </div>--}}
</div>
