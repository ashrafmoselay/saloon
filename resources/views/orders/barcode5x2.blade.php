<div class="genCode">
    <div class="pull-right" style="margin-bottom: 3px;">
        <span class="title">{!! $settings['SiteName'] !!}</span>
    </div>
    {!!'<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product->code, $barcodetype)) . '">'!!}
    <h6 class="title_type">{{$product->name}}</h6>
    <h6 class="stretch">
        {{$product->code}}
    </h6>
    <h6> السعر : <span>
            {{currency((double)$product->productUnit()->first()->pivot->sale_price,currency()->config('default'), currency()->getUserCurrency(), $format = true)}}
    </span></h6>
</div>
