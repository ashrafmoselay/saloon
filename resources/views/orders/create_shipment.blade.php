<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        إضافة الطرد
        <small>
            {{ $order->id }}
        </small>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>
<!-- Main content -->
<form action="{{ route('createTurpoShipment', $order->id) }}" method="post">
    {{ csrf_field() }}
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    @php
                        $client = optional($order->client);
                        $area = optional($client->area);
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>المحافظة</label>
                            <select required style="width: 100%" data-ajax--url="{{ route('governmentList') }}"
                                data-ajax--cache="true" data-placeholder="@lang('front.select')" id="governmentList"
                                name="government_id" class="form-control select2">
                                @if ($area)
                                    <option selected value="{{ $area->government_id }}">
                                        {{ optional($area->government)->name }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>منطقة الشحن</label>
                            <select required style="width: 100%" data-url="{{ route('areasList') }}"
                                data-placeholder="@lang('front.select')" id="areasList" name="area_id" class="form-control">
                                @if ($area)
                                    <option selected value="{{ $area->id }}">
                                        {{ $area->name }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>العنوان</label>
                            <input value="{{ $client->address }}" name="address" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الموبيل</label>
                            <input required value="{{ $client->mobile }}" name="mobile" type="text"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>إجمالى الطلب</label>
                            <input readonly value="{{ $order->total }}" name="shipment_amount" type="number"
                                class="form-control total">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>تكلفة الشحن</label>
                            <input value="{{ $order->shipment_amount }}" name="shipment_amount" type="number"
                                class="form-control shipamount">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>إجمالى مع الشحن</label>
                            <input readonly value="{{ $order->total + $order->shipment_amount }}"
                                name="totalWithShipment" type="number" class="form-control totwitgship">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">إضافة الطرد</button>
            </div>
        </div>
    </section>
</form>

<script>
    $(".select2").select2();
    $('#areasList').select2({
        ajax: {
            url: function() {
                return $(this).attr('data-url') + "?gov_id=" + $("#governmentList").val();
            },
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term // search term
                };
            },
            processResults: function(response) {
                return response;
            },
            cache: true,
            minimumInputLength: 1,
            width: "100%",
        }
    });

    $(document).on("input", ".shipamount", function(e) {
        var total = parseFloat($(".total").val());
        var shipamount = parseFloat($(this).val());
        var totwitgship = total + shipamount;
        $('.totwitgship').val(totwitgship);
    });
</script>
