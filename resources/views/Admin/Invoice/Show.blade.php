@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Invoices</h1>
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
                            <a href="/user/create" class="btn btn-success btn-sm">
                                  <i class="fa fa-plus"></i> Add new
                              </a>
                              <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                  <i class="fa fa-refresh"></i> Refresh
                              </button>
                              <a href="/user" id="clearBtn" style="display: none;">
                                  <button type="button" class="btn btn-secondary btn-sm">Clear</button>
                              </a>
                          </div>
                        </div>

                        <div class="box-body">
                          <form action="/user/search" method="GET" id="SearchData" role="search"> 
                              <div class="input-group">
                                <input type="text" name="q" value="{{request('q')}}" id="search" class="form-control" placeholder="Search User by name, email, phone">
                                <div class="input-group-append">
                                  <button class="btn btn-secondary" type="submit" style="width: 80px;">
                                    <i class="fa fa-search"></i>
                                  </button>
                                </div>
                              </div>
                          </form>
                          <div class="col-md-12 col-sm-12 result-status">
                            @if(isset($message))
                                 <p>{{ $message }}</p>
                            @endif
                          </div>


                            <table class="table table-hover on-mob-scroll-table-full">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><input type="checkbox" id="master"> INVOICE NUMBER</th>
                                    <th>CLIENT</th>
                                    <th>ISSUE DATE</th>
                                    <th>DUE DATE</th>
                                    <th>STATUS</th>
                                    <th>AMOUNT</th>
                                    <th>USER</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                    <tr class="clickable-row" data-href='/client/{{$invoice->id}}/view' style="cursor: pointer;">
                                        <td>{{ $invoice->id }}</td>
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$invoice->id}}"> {{ $invoice->invoice_number}}</td>
                                        <td>{{ $invoice->client }} <br> <span style="font-size: 10px;color: #2196F3;">{{ $invoice->user_mail }}</span></td>
                                        <td>{{ date('m/d/Y', strtotime($invoice->issue_date)) }}</td>
                                        <td>{{ date('m/d/Y', strtotime($invoice->due_date)) }}</td>
                                        <td class="status_{{ strtolower($invoice->status)}}">{{ $invoice->status}} <br>
                                    @if($invoice->status == "OVERDUE" && $invoice->net_amount != $invoice->due_amount)
                                     <span class="td-inv-amount-status">DEPOSIT PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                                    @endif
                                    @if($invoice->status == "PAID-STRIPE" || $invoice->status == "PAID-BANKWIRE" || $invoice->status == "PAID-OFFLINE")
                                   <span class="td-inv-amount-status">PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                                   @endif

                                   @if($invoice->status == "DEPOSIT_PAID")
                                   <span class="td-inv-amount-status">DEPOSIT PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                                   @endif</td>
                                        <td>{{ $invoice->net_amount}}</td>
                                        <td>{{ $invoice->user }} <br> <span style="font-size: 10px;color: #2196F3;">{{ $invoice->user_mail }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $invoices->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection