@foreach($persons as $per)
    <option data-mobile="{{$per->mobile}}" last_transaction_value="{{$per->last_transaction_value}}" priceType="{{$per->priceType}}" rel="{{$per->total_due}}"  value="{{$per->id}}">{{$per->name}}</option>
@endforeach
