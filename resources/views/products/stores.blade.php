<div class="row {{($product->id && !in_array($store->id,auth()->user()->stores_ids))?'hide':''}}">
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('front.store')</label>
            <input type="hidden" value="{{$store->id}}" name="store[{{$i}}][store_id]">
            <input type="hidden" value="{{isset($store->pivot->sale_count)?$store->pivot->sale_count:0}}" name="store[{{$i}}][sale_count]">
            <input readonly value="{{$store->name}}" type="text" class="form-control ">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('front.quantity')</label>
            <div class="input-group">
                <input name="store[{{$i}}][qty]" value="{{isset($store->pivot->qty)?round($store->pivot->qty-$store->pivot->sale_count,1):0}}" type="number" step="0.01"  class="form-control" required="required">
                <span class="unit input-group-addon">
                    <select style="width: 100%;" name="store[{{$i}}][unit_id]" required="" class="form-control unitclass storeUnites">
                        @foreach($units as $unit)
                            <option {{isset($store->pivot->unit_id)&&$store->pivot->unit_id==$unit->id?'selected':''}}  value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                    </select>
                </span>
            </div>
        </div>
    </div>
</div>
