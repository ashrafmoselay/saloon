@if (count($order->details))
    @foreach ($order->details as $item)
        @php
            $rowClass = 'rowelement' . $item->id . '_' . $item->pivot->store_id . '_' . $item->pivot->unit_id;
            $productsListIds[] = $item->id;
        @endphp
        <tr class="{{ $rowClass }} bg-success">
            <td>
                <input type="hidden" class="rowIndex" value="{{ $loop->iteration }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][store_name]"
                    value="{{ $item->pivot->store_name }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][customer_price]"
                    value="{{ $item->pivot->customer_price }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][is_service]"
                    value="{{ $item->pivot->is_service }}">

                <input type="hidden" class="rowUnit_name" name="product[{{ $loop->iteration }}][unit_name]"
                    value="{{ $item->pivot->unit_name }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][product_name]"
                    value="{{ $item->name }}">
                <input class="itemCost" type="hidden" name="product[{{ $loop->iteration }}][cost]"
                    value="{{ $item->pivot->cost }}">
                {{ $loop->iteration }}
            </td>
            <td><input type="hidden" name="product[{{ $loop->iteration }}][store_id]"
                    value="{{ $item->pivot->store_id }}">{{ $item->pivot->store_name }}</td>
            <td><input type="hidden" name="product[{{ $loop->iteration }}][product_id]"
                    value="{{ $item->id }}">{{ $item->name }}</td>
            <td><input class="itemQty tdinput" type="text" name="product[{{ $loop->iteration }}][qty]"
                    value="{{ $item->pivot->qty - $item->pivot->return_qty }}"></td>
            <td><input class="itemPrice tdinput" type="text" name="product[{{ $loop->iteration }}][price]"
                    value="{{ $item->pivot->price }}"></td>
            <td>
                <input class="itemdiscount1 tdinput disStyle" type="text"
                    name="product[{{ $loop->iteration }}][discount1]" value="{{ $item->pivot->discount1 ?? 20 }}">

                <input class="itemdiscount2 tdinput disStyle" type="text"
                    name="product[{{ $loop->iteration }}][discount2]" value="{{ $item->pivot->discount2 ?? 0 }}">
            </td>
            {{-- <td>
                                        {{($item->pivot->price-$item->pivot->cost)*$item->pivot->qty}}
                                    </td> --}}
            <td><input type="hidden" name="product[{{ $loop->iteration }}][unit_id]"
                    value="{{ $item->pivot->unit_id }}">{{ $item->pivot->unit_name }}</td>
            <td>
                <input class="tdinput" type="text" name="product[{{ $loop->iteration }}][bounse]"
                    value="{{ $item->pivot->bounse }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][bounse_unit_id]"
                    value="{{ $item->pivot->bounse_unit_id }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][bounseUnitText]"
                    value="{{ $item->pivot->bounseUnitText }}">
            </td>
            <td>
                <input class="itemTotal tdinput" readonly type="text" name="product[{{ $loop->iteration }}][total]"
                    value="{{ $item->pivot->total }}">
            </td>
            @if ($type == 'sales' && $useMarket)
                <td>
                    <input type="hidden" name="product[{{ $loop->iteration }}][markter]"
                        value="{{ $item->pivot->markter }}">
                    {{ $item->pivot->markter }}
                </td>
            @endif
            <td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
    @endforeach
@else
    @foreach (\App\Product::with(['productUnit', 'productStore'])->get() as $item)
        @php
            $firstStore = $item->productStore[0];
            $firstUnit = $item->productUnit[0];
            $rowClass = 'rowelement' . $item->id . '_' . $firstStore->id . '_' . $firstUnit->id;
            $productsListIds[] = $item->id;
        @endphp
        <tr class="{{ $rowClass }} bg-success">
            <td>
                <input type="hidden" class="rowIndex" value="{{ $loop->iteration }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][store_name]"
                    value="{{ $firstStore->name }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][customer_price]"
                    value="{{ $firstUnit->pivot->customer_price }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][is_service]" value="0">

                <input type="hidden" class="rowUnit_name" name="product[{{ $loop->iteration }}][unit_name]"
                    value="{{ $firstUnit->name }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][product_name]"
                    value="{{ $item->name }}">
                <input class="itemCost" type="hidden" name="product[{{ $loop->iteration }}][cost]"
                    value="{{ $firstUnit->pivot->cost_price }}">
                {{ $loop->iteration }}
            </td>
            <td><input type="hidden" name="product[{{ $loop->iteration }}][store_id]"
                    value="{{ $firstStore->id }}">{{ $firstStore->name }}</td>
            <td><input type="hidden" name="product[{{ $loop->iteration }}][product_id]"
                    value="{{ $item->id }}">{{ $item->name }}</td>
            <td><input class="itemQty tdinput" type="text" name="product[{{ $loop->iteration }}][qty]"
                    value="0"></td>
            <td><input class="itemPrice tdinput" type="text" name="product[{{ $loop->iteration }}][price]"
                    value="{{ $firstUnit->pivot->sale_price }}"></td>
            <td>
                <input class="itemdiscount1 tdinput disStyle" type="text"
                    name="product[{{ $loop->iteration }}][discount1]" value="20">

                <input class="itemdiscount2 tdinput disStyle" type="text"
                    name="product[{{ $loop->iteration }}][discount2]" value="0">

            </td>

            <td><input type="hidden" name="product[{{ $loop->iteration }}][unit_id]"
                    value="{{ $firstUnit->id }}">{{ $firstUnit->name }}</td>
            <td>
                <input class="tdinput" type="text" name="product[{{ $loop->iteration }}][bounse]"
                    value="0">
                <input type="hidden" name="product[{{ $loop->iteration }}][bounse_unit_id]"
                    value="{{ $firstUnit->id }}">
                <input type="hidden" name="product[{{ $loop->iteration }}][bounseUnitText]"
                    value="{{ $firstUnit->name }}">
            </td>
            <td>
                <input class="itemTotal tdinput" readonly type="text"
                    name="product[{{ $loop->iteration }}][total]" value="">
            </td>
            @if ($type == 'sales' && $useMarket)
                <td>
                    <input type="hidden" name="product[{{ $loop->iteration }}][markter]"
                        value="{{ $item->pivot->markter }}">
                    {{ $item->pivot->markter }}
                </td>
            @endif
            <td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
    @endforeach
@endif
<style>
    .disStyle {
        float: right !important;
        width: 42% !important;
        margin: 2px !important;
    }
</style>
