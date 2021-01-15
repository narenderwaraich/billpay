@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>User Plan Payments</h1>
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
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                                <a href="/admin/payment/Success/list">
                                    <button type="button" class="btn btn-success btn-sm">Success</button>
                                </a>
                                <a href="/admin/payment/Fields/list">
                                    <button type="button" class="btn btn-danger btn-sm">Fields</button>
                                </a>
                                <a href="/admin/payment/Pending/list">
                                    <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                </a>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover scroll-table-full">
                                <thead>
                                <tr>
                                     <th>Id</th>
                                     <th>Order Id</th>
                                     <th>Name</th>
                                     <th>Method</th>
                                     <th>Bank</th>
                                     <th>Transaction Id</th>
                                     <th>Bank Transaction Id</th>
                                     <th>Date</th>
                                     <th>Amount</th>
                                     <th>Status</th>
                                     <th width="290px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->order_id }}</td>
                                        <td>{{ $payment->user }} <br> <span style="font-size: 10px;color: #2196F3;">{{ $payment->user_mail }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->bank_name }}</td>
                                        <td>{{ $payment->transaction_id }}</td>
                                        <td>{{ $payment->bank_transaction_id }}</td>
                                        <td>{{ date('d/m/Y', strtotime($payment->transaction_date)) }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td class="status-{{ $payment->transaction_status }}">{{ $payment->transaction_status }}</td>
                                        <td>
                                        @if($payment->transaction_status == "Fields")
                                            <a href="/user/plan/payment/mark-success/{{$payment->id}}" class="btn btn-success on-mob-table-btn">Mark Success</a>
                                        @endif
                                        @if($payment->transaction_status == "Pending")
                                            <a href="/user/plan/payment/manual/{{$payment->id}}" class="btn btn-success on-mob-table-btn">Manual</a>
                                        @endif
                                        @if($payment->transaction_status == "Fields")
                                        <a href="/user/plan/payment/refund/{{ $payment->id }}"><button class="btn btn-danger">Refund</button></a>
                                        @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $payments->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
