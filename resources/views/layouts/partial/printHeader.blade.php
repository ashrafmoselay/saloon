@if($settings['printerType']!='receipt' || isset($showCompanyData))
<div class="row printHeader" style="margin-bottom: 10px;display: none">
    <div class="col-md-12">
            <div class="pull-left">
                <h4>
                    {!! $settings['SiteName'] !!}
                </h4>

                <div class="clearfix"></div>
                @if($settings['Address'])
                    <span>{!!$settings['Address']!!}</span><br>
                @endif
                @if($settings['mobile'])
                    <span style="line-height: 30px;">{{$settings['mobile']}}</span>
                @endif
                <div class="clearfix"></div>
                @if(request('fromdate') || request('todate'))
                    <span style="line-height: 30px;">
                        التاريخ : {{request('fromdate')}}  {{request('todate')?' | '.request('todate'):''}}
                    </span>
                @endif
                <div class="clearfix"></div>
                <br>
                <span>
                    تاريخ الطباعه  : {{ date('Y-m-d') }}<br/>

                    مسئول الطباعه  : {{ auth()->user()->name }}
                </span>
            </div>
            @if($settings['logo'])
                <div class="pull-right">
                    <img style="width: 200px;" src="{{\Illuminate\Support\Facades\Storage::url($settings['logo'])}}">
                </div>
            @endif
    </div>
</div>
@endif
<div class="row printHeader text-center" style="margin-bottom: 10px;display: none">
    <div class="col-md-12 text-center">
        <h4>@yield('title')</h4>
    </div>
</div>
