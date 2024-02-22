<div style="margin-bottom: 30px;" class="row">
    <a style="position: absolute;left: 10px;top: 3px;" class="btn btn-sm bg-blue addComb" href="#"><i class="fa fa-plus-square"></i> إضافة كمية</a>
</div>
<div class="CombList">
@foreach($product->productCombination as $prodcomb)
    @php
        $ci = $loop->iteration-1;
    @endphp
    <div class="row itemComb">
            <div class="col-md-4">
                <div class="form-group">
                    <label>المخزن</label>
                    <select required name="combination[{{$ci}}][store_id]" class="form-control">
                        @foreach(\App\Store::get() as $storeObj)
                            <option {{$storeObj->id==$prodcomb->pivot->store_id?'selected':''}} value="{{$storeObj->id}}">{{$storeObj->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>اللون والمقاس</label>
                    <select required name="combination[{{$ci}}][combination_id]" class="form-control colorsize" style="width: 100%;">
                        <option value="">--- إختر ---</option>
                        @foreach(\App\Combination::get() as $combination)
                            <option {{$combination->id==$prodcomb->id?'selected':''}} value="{{$combination->id}}">{{$combination->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>@lang('front.quantity')</label>
                    <input name="combination[{{$ci}}][qty]" value="{{$prodcomb->pivot->qty}}" type="number" step="any"  class="form-control" required="required">
                </div>
                <a style="position: absolute;left: 50px;top: -6px;" class="btn btn-sm bg-green addComb" href="#"><i class="fa fa-plus-square"></i></a>
                <a style="position: absolute;left: 15px;top: -6px;" class="btn btn-sm bg-red removeComb" href="#"><i class="fa fa-minus"></i></a>
            </div>
        </div>
@endforeach
</div>
@push('js')
    <script>

        $(document).on("click",".removeComb",function(e){
            e.preventDefault();
            $(this).closest('.itemComb').remove();
        });
        $(document).on("click",".addComb",function(e){
            e.preventDefault();
            var clone = $(".com-item").find(".itemComb").clone();
            var i = $(".itemComb:visible").length;
            clone.find('input,select').each(function() {
                this.name= this.name.replace('[]', '['+i+']');
            });
            clone.find(".colorsize").select2({dir: "rtl"});
            $(".CombList").append(clone);
        });
    </script>

@endpush
