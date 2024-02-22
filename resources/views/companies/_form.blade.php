<section class="content">
    <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('front.name')</label>
                            <input value="{{$company->sender_name}}" required name="sender_name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>الموبيل</label>
                            <input value="{{$company->sender_mobile}}" required name="sender_mobile" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('front.save')</button>
            </div>
        </div>
</section>
<script>
    $('form').validator();
</script>
@if(isset($from) && !empty($from))
    <script>
        $(function () {
            $("#companyForm").submit(function(e) {
                var form = $(this);
                var url = form.attr('action');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(data)
                    {
                        $("#companyList").empty();
                        $("#companyList").append(data);
                        $("#companyList option:first").attr("selected", "selected");
                        $('#addPersonModal').modal('toggle');
                        //selectRefresh();
                        $( "#companyList" ).trigger('change');


                    }
                });
            });
        });
    </script>
@endif
