<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('front.name')</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-role"></i>
                                </div>
                                <input value="{{$role->name}}" required name="name" type="text" class="form-control">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>اسم الظهور</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa  fa-check-square-o"></i>
                                </div>
                                <input value="{{$role->display_name}}" required name="display_name" type="text" class="form-control">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>

                @foreach($controllers as $cont)
                    <div class="row control">
                        <div class="form-group col-md-12">
                            <label for="">
                                <h3>{{trans('app.'.$cont)}}</h3>
                            </label>
                            <input type="checkbox" class="select_all flat-red">
                            إختر الكل
                        </div>
                        @foreach($methods[$cont] as $k=>$op)
                            @php
                                $name = $op.' '.$cont;
                            @endphp
                            <div class="col-md-6">
                                <input @if($role->hasPermissionTo($name)) checked="" @endif    type="checkbox" name="perm[{{$name}}]" valu="{{$name}}">
                                {{trans('app.'.$op)}}
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
</section>
@push('js')
<script>
    $('form').validator();
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
    $(document).ready(function(){
        $('.select_all').on('ifChanged', function(){
            var checkboxes = $(this).closest('div.control').find(':checkbox');
            //console.log(checkboxes.length);

            checkboxes.prop('checked', $(this).is(':checked'));
        });
    });
</script>
@endpush
