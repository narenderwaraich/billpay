@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Items</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List</h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <!-- <a href="#" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Add new
                                </a> -->
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><input type="checkbox" id="master">
                                        ITEM<br>
                                         <span style="font-weight: 400;font-size: 12px;">(Name / Description)</span>
                                     </th>
                                    <th>PRICE</th>
                                    <th>SALE</th>
                                    <th>QUANTITY</th>
                                    <th>STOCK</th>
                                    <th>USER</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                    <tr id="tr_{{$item->id}}" class="clickable-row" data-href='/items/edit/{{$item->id}}' style="cursor: pointer;">
                                        <td>{{ $item->id }}</td>
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$item->id}}">  {{ $item->item_name}}<br>
                                         <span class="td-inv-no">{{ $item->item_description}}</span>
                                        </td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->sale }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>@if($item->in_stock == 1) <span style="color: green;">In Stock</span> @else <span style="color: red;">Out Stock</span> @endif</td>
                                        <td>{{ $item->user['fname'] }} {{ $item->user['lname'] }} <br> <span style="font-size: 10px;color: #2196F3;">{{ $item->user['email'] }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $items->links() !!} 
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection