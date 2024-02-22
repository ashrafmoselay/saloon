@php
    $count = count($instalments)+count($records);
@endphp
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning">{{$count}}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">{{trans('front.notificationsMessage')}}</li>
        <li>
            <ul style="font-size: 12px;" class="menu">
                @foreach($records as $record)
                <li>
                    <a href="{{route('persons.show',$record)}}">
                        <i class="fa fa-user text-aqua"></i>@lang('front.Remind me to review the account for') {{$record->name}}
                    </a>
                </li>
                @endforeach
                @foreach($instalments as $cal)
                    <li>
                        <a data-toggle="modal" data-target="#addPersonModal"  href="{{route('persons.addPayment',['person'=>$cal->order->client,'calanderId'=>$cal->id])}}">
                            <i class="fa fa-money text-yellow"></i>@lang('front.today installment') {{$cal->order->client->name}} | {{$cal->value}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
</li>
