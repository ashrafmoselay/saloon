<table>
    <thead>
    <tr>
        <th>الإسم</th>
        <th>الوحدة</th>
        <th>الفئة</th>
        <th>التكلفة</th>
        <th>البيع</th>
        <th>الجملة</th>
        <th>جملة الجملة</th>
        <th>الكمية</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $productunit)
        @if(isset($productunit->product) && !empty($productunit->product))
        <tr>
            <td>{{optional($productunit->product)->name}}</td>
            <td>{{optional($productunit->unit)->name}}</td>
            <td>{{optional(optional($productunit->product)->category)->name}}</td>
            <td>{{$productunit->cost_price}}</td>
            <td>{{$productunit->sale_price}}</td>
            <td>{{$productunit->gomla_price}}</td>
            <td>{{$productunit->gomla_gomla_price}}</td>
            <td>{{$productunit->product->getQuantityByunit()}}</td>
        </tr>
        @endif
    @endforeach
    </tbody>
</table>
