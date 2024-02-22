<div class="col-md-8">
    <div class="form-group">
        <label>المادة الخام</label>
        <input id="productID" type="hidden" value="">
        <input id="productName" type="hidden" value="">
        <input id="rawCost" type="hidden" value="">
        <input type="text" class="form-control rawInput typeahead" value="">
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">الكمية المستخدمه لتصنيع اصغر وحدة من الصنف</label>
        <div class="input-group">
            <input style=" min-width: 120px; " step="0.01" type="number" class="form-control rawInput rawqty" value="1">
            <span style="width: 100px;" class="unit input-group-addon">
                <select id="RawunitList" class="form-control rawunitList" required>
                    @foreach(\App\Unit::get() as $unit)
                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                    @endforeach
                </select>
            </span>
        </div>
    </div>
</div>
<div class="col-md-4 hide">
    <div class="form-group">
        <label for="">عدد اﻷلوان</label>
        <input type="number" step="0.01" class="form-control rawInput rawcolor" value="0">
    </div>
</div>
<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الصنف الخام</th>
                <th>الكمية المستخدمة لتصنيع أصغر وحدة</th>
                <th>الوحدة</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="rawTable">
            @php
                $subtotal = 0;
                $totalraw = 0;
            @endphp
            @foreach($product->rawMatrial as $item)
            @php
                $rowClass = "rowelement".$item->pivot->raw_material_id;
            @endphp
            <tr class="{{$rowClass}}">
                <td><input type="hidden" name="raw[{{$loop->iteration}}][raw_material_id]" value="{{$item->pivot->raw_material_id}}">{{$loop->iteration}}</td>
                <td>
                    <input class="iteration" type="hidden" value="{{$loop->iteration}}">
                    {{$item->name}}
                    <input class="rawCost" type="hidden" value="{{$item->last_cost}}">
                </td>
                @php
                    $subtotal = round($item->last_cost,2)*$item->pivot->qty;
                    $totalraw += $subtotal;
                @endphp
                <td><input class="rawQty" type="hidden" name="raw[{{$loop->iteration}}][qty]" value="{{$item->pivot->qty}}">{{$item->pivot->qty}} ( {{round($item->last_cost,2)}} ) ====> ({{$subtotal}})</td>
                <td>
                    <input type="hidden" name="raw[{{$loop->iteration}}][raw_unit_text]" value="{{$item->pivot->raw_unit_text}}">
                    <input type="hidden" name="raw[{{$loop->iteration}}][raw_unit_id]" value="{{$item->pivot->raw_unit_id}}">
                    <input type="hidden" name="raw[{{$loop->iteration}}][color_number]" value="{{$item->pivot->color_number}}">
                    {{$item->pivot->raw_unit_text}}
                </td>
                <td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-primary">
                <td colspan="2">الإجمالى</td>
                <td colspan="3">{{$totalraw}}</td>
            </tr>
        </tfoot>
    </table>
</div>
