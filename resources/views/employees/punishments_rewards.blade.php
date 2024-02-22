<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       @lang('front.Add') @lang('front.Reward or punishment')
        <small>
            {{$employee->name}}
        </small>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>
<!-- Main content -->
<form action="{{route('employees.addPunishmentsRewards',$employee)}}" method="post">
    {{ csrf_field() }}
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.title')</label>
                            <input value="" required name="note" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.type')</label>
                            <select name="type" class="form-control">
                                <option value="rewards">@lang('front.Reward')</option>
                                <option value="punishments">@lang('front.punishment')</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.value')</label>
                            <input value="" required name="value" type="number" class="form-control">
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('front.save')</button>
                </div>
            </div>
        </div>
    </section>
</form>

<script>
    $('.select2').select2();
    $('form').validator();
</script>
