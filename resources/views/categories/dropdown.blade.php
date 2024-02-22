@foreach($categories as $cat)
    <option half_percentage="{{$cat->half_percentage}}"  percentage3="{{$cat->percentage3}}" percentage2="{{$cat->percentage2}}"  {{$cat->name == request('name')?'selected':''}} rel="{{$cat->percentage}}" value="{{$cat->id}}">{{$cat->name}}</option>
@endforeach
