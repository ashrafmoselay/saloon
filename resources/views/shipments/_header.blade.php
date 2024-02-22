<div class="row">
    <div class="col-md-12">
        <div style="font-weight: bold;font-size: {{$settings['PrintSize']+2}}px!important;" class="invoice-title">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="pull-left">
                            <h4 style="font-weight: bold">
                                {!! $settings['SiteName'] !!}
                            </h4>
                            <div class="clearfix"></div>
                            @if($settings['Address'])
                                <span style="font-size: 16px; ">{!!$settings['Address']!!}</span>
                                <div class="clearfix"></div>
                            @endif
                            @if($settings['mobile'])
                                <span style="line-height: 30px;">{{$settings['mobile']}}</span>
                            @endif
                            <div class="clearfix"></div>
                            <span class="pull-left">تاريخ الشحنة: {{$shipment->date_ar}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($settings['logo'])
                            <div class="pull-right">
                                <img style="width: 155px;" src="{{\Illuminate\Support\Facades\Storage::url($settings['logo'])}}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
