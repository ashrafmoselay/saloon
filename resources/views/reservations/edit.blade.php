<section class="content-header">
    <h1>
        @lang('front.edit') 
        <small>
            {{$row->id}}
        </small>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>
<form action="{{route('reservations.update',$row)}}" method="post">
    {{ csrf_field() }}
    {{ method_field('PUT')  }}
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الموظف</label>
                            <select name="employee_id" class="form-control select2" required="required">
                                <option value="">--- الموظف ---</option>
                                @foreach ($employees as $emp)
                                    <option {{ $row->employee_id?'selected':'' }} value="{{ $emp->id }}">{{ $emp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الخدمة</label>
                            <select name="product_id" class="form-control select2" required="required">
                                <option value="">--- الخدمة ---</option>
                                @foreach ($services as $service)
                                    <option {{ $row->product_id==$service->id?'selected':'' }} value="{{ $service->id }}">{{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>التاريخ والوقت</label>
                            <input name="serive_datetime" value="{{ $row->serive_datetime }}" type="datetime-local" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>سعر الخدمة</label>
                            <input name="price" value="{{ $row->price }}" step="any" type="number" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>الحالة</label>
                            @php 
                                $statusList = ['معلق','جارى العمل','مكتمله','مؤجله'];
                            @endphp
                            <select name="status" class="form-control">
                                <option value="">--- إختر الحالة ---</option>
                                @foreach ($statusList as $st)
                                    <option value="{{ $st }}">{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ملحوظة</label>
                            <input name="comment" value="{{ $row->comment }}" type="text" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
    </section>                                    
</form>

<script>
    // $(".select2").select2({
    //     allowClear: true,
    //     width:'100%'
    // });
</script>