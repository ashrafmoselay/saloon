@if(empty($subMenus))
<li>
    <a href="{{$link}}">
        <i class="{{$iconClass}}"></i>
        <span>{{$title}}</span> 
    </a>
</li>
@else
<li class="treeview">
    <a href="#">
        <i class="{{$iconClass}}"></i>
        <span>{{$title}}</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
    @foreach($subMenus as $m)
        <li>
            <a href="{{$m['link']}}"><i class="{{$m['iconClass']}}"></i> {{$m['title']}}</a>
        </li>
    @endforeach
    </ul>
</li>
@endif