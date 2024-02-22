
<div class="modal  fade" id="modal-dicounts-bounse" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">الخصومات والبونص</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>البونص</label>
                        <input type="number" value="0" class="form-control bounse">
                    </div>
                    <div class="form-group col-md-6">
                        <label>الوحدة</label>
                        <select id="bouns_unit_id" class="form-control bounse_unit_id">
                            @foreach(\App\Unit::get() as $unit)
                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save-discount-bouns pull-left">حفظ</button>
            </div>
        </div>
    </div>
</div>
