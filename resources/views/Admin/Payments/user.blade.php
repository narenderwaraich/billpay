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
                                <a href="/admin/users/payment/Success/list">
                                    <button type="button" class="btn btn-success btn-sm">Success</button>
                                </a>
                                <a href="/admin/users/payment/Fields/list">
                                    <button type="button" class="btn btn-danger btn-sm">Fields</button>
                                </a>
                                <a href="/admin/users/payment/Pending/list">
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
                                     <th>User</th>
                                     <th>Client</th>
                                     <th>Method</th>
                                     <th>Bank</th>
                                     <th>Transaction Id</th>
                                     <th>Bank Transaction Id</th>
                                     <th>Date</th>
                                     <th>Amount</th>
                                     <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->order_id }}</td>
                                        <td>{{ $payment->user['fname'] }} {{ $payment->user['lname'] }} <br> <span style="font-size: 10px;color: #2196F3;">{{ $payment->user['email'] }}</td>
                                        <td>{{ $payment->user_client }} <br> <span style="font-size: 10px;color: #2196F3;">{{ $payment->user_client_mail }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->bank_name }}</td>
                                        <td>{{ $payment->transaction_id }}</td>
                                        <td>{{ $payment->bank_transaction_id }}</td>
                                        <td>{{ date('d/m/Y', strtotime($payment->transaction_date)) }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td class="status-{{ $payment->transaction_status }}">{{ $payment->transaction_status }}</td>
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
