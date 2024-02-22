<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        حركة سعر الصنف
        <small>
            {{$product->name}}
        </small>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="dataList" class="table table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th>السعر</th>
                            <th>بتاريخ</th>
                            <th>من خلال</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>أول سعر تكلفة</td>
                                <td>{{$firstPrice->price??''}}</td>
                                <td>{{$firstPrice?$firstPrice->created_at->format('Y-m-d'):''}}</td>
                                <td>{{$firstPrice?$firstPrice->order->client->name:''}}</td>
                            </tr>
                            <tr>
                                <td>آخر سعر تكلفة</td>
                                <td>{{$lastPrice->price??''}}</td>
                                <td>{{$lastPrice?$lastPrice->created_at->format('Y-m-d'):''}}</td>
                                <td>{{$lastPrice?$lastPrice->order->client->name:''}}</td>
                            </tr>
                            <tr>
                                <td>أقل سعر تكلفة</td>
                                <td>{{$minPrice->price??''}}</td>
                                <td>{{$minPrice?$minPrice->created_at->format('Y-m-d'):''}}</td>
                                <td>{{$minPrice?$minPrice->order->client->name:''}}</td>
                            </tr>
                            <tr>
                                <td>أعلى سعر تكلفة</td>
                                <td>{{$maxPrice->price??''}}</td>
                                <td>{{$maxPrice?$maxPrice->created_at->format('Y-m-d'):''}}</td>
                                <td>{{$maxPrice?$maxPrice->order->client->name:''}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
