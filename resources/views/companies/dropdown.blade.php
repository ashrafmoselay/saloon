@foreach($companies as $reg)
    <option {{$reg->sender_name == request('sender_name')?'selected':''}} value="{{$reg->id}}">{{$reg->sender_name}} - {{$reg->sender_mobile}}</option>
@endforeach
