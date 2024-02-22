@foreach($regions as $reg)
    <option {{$reg->name == request('name')?'selected':''}} value="{{$reg->id}}">{{$reg->name}}</option>
@endforeach
