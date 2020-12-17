@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="padding-top: 15px;">
        <h5>Recent Delete Invoices</h5>
    </div> 
    <div class="search-bar">
                  <form action="/delete/invoice/search" method="POST" id="SearchData" role="search">
                    {{ csrf_field() }}
                  <div class="col-xs-3 col-sm-12 col-md-3 col-lg-3 col-xl-3" style="clear: both;">
                     <div class="del-action del-btn-move">
                            <a href="#" class="restore_all disabled" id="restoreBtn"><img src="/images/navicons/restore-invoice-icon-inactive.svg" class="btn-icon-del" id="firstIcon"><img src="/images/navicons/restore-invoice-icon.svg" class="btn-icon-del" id="secondIcon"><img src="/images/navicons/restore-invoice-icon-active.svg" class="btn-icon-del">
                            <span class="btn-icon-title-del rmv-txt-clr inactive-icon-text">Restore</span>
                          </a>
                          <a href="#" class="delete_all disabled" id="deleteBtn"><img src="/images/navicons/delete-forever-invoice-icon-inactive.svg" class="btn-icon-del" id="firstIcon2"><img src="/images/navicons/delete-forever-invoice-icon.svg" class="btn-icon-del" id="secondIcon2"><img src="/images/navicons/delete-forever-invoice-icon-active.svg" class="btn-icon-del">
                            <span class="btn-icon-title-del rmv-txt-clr inactive-icon-text">Delete Forever</span>
                          </a> 
                      </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-5 col-lg-6 col-xl-7">
                    
                  <input type="text" name="q" value="{{request('q')}}" id="search" class="form-control serach-input" placeholder="Search by client name, status invoice number">
                  </div>
                  <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 search-icon-div row-remove-pad m-t-15">
                        <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <input  name="start" id="datepicker"  class="datePick" width="2" />
                          <span class="cle-icon-title from-label">From</span>
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <input  name="end" id="datepicker2"  class="datePick" width="2" />
                          <span class="cle-icon-title2">To</span>
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                         <button type="submit" class="search-btn" id="searchBtn"><img src="/images/search_btn.png"><span class="search-icon-title">Search</span></button>
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                         <a href="/delete/invoice/view"><button type="button" class="clear-btn-icon" id="clear-btn"><img src="/images/delete-invoice-icon.svg" width="34px"> <br><span class="clear-icon-title">Clear</span></button></a>
                    </div>
                    </div>
                </form>
              </div> <!-- end row -->
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="show-result-data">
                  <div class="show-result"><span class="hide-data-mobile-view">From</span><span>
                      <input type="text" readonly name="" value="{{request('start')}}" id="reqStartDate"> </span><span class="hide-data-mobile-view">To </span><span><input type="text" value="{{request('end')}}" readonly name="" id="reqEndDate"></span>
                    </div>
                </div>
                  <div class="col-xs-6 col-md-12 col-sm-12 result-status">
                    @if(isset($message))
                         <p>{{ $message }}</p>
                    @endif
                    <!-- <span id="record">@if( ! empty( $total_row)) {{ $total_row}} Invoice found match your search @else Invoice not found match Your search @endif</span> -->
                  </div>

                <div class="col-sm-12 m-t-60">
                   <div class="table-responsive">
                        <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col" class="table-heading"><input type="checkbox" id="master">  CLIENT <br>
                                    <span style="padding-left: 15px;font-weight: 400;">(invoice Number)</span></th>
                                  <th scope="col" class="table-heading">ISSUE DATE</th>
                                  <th scope="col" class="table-heading hide-data-mobile-view">DUE DATE</th>
                                  <th scope="col" class="table-heading">STATUS</th>
                                  <th scope="col" class="table-heading">AMOUNT</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if(isset($invoices))
                                    @foreach ($invoices as $invoice)
                                    <tr id="tr_{{$invoice->id}}" class="clickable-row" data-href='/delete/invoice/view/{{$invoice->id}}' style="cursor: pointer;">
                                      <th scope="row" class="td-inv-name"><input type="checkbox" class="sub_chk" data-id="{{$invoice->id}}" email-id="{{ $invoice->clientEmail }}"> <a href="/inv-view/{{$invoice->id}}"> {{ $invoice->clientFname }}  {{ $invoice->clientLname }}<br>
                                       <span class="td-inv-no">{{ $invoice->invoice_number}}</span> </a></th>
                                      <td class="td-inv-name">{{ date('m/d/Y', strtotime($invoice->issue_date)) }}</td>
                                      <td class="td-inv-name hide-data-mobile-view">{{ date('m/d/Y', strtotime($invoice->due_date)) }}</td>
                                      <td class="status_{{ strtolower($invoice->status)}}">{{ $invoice->status}} <br>
                                        @if($invoice->status == "OVERDUE" && $invoice->net_amount != $invoice->due_amount)
                                        <span class="td-inv-amount-status">DEPOSIT PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                                        @endif
                                        @if($invoice->status == "PAID-STRIPE")
                                       <span class="td-inv-amount-status">PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                                       @endif

                                       @if($invoice->status == "DEPOSIT_PAID")
                                       <span class="td-inv-amount-status">DEPOSIT PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                                       @endif
                                      </td>
                                      <td class="td-inv-name">${{ $invoice->net_amount}} USD</td>
                                    </tr>
                                    @endforeach
                              </tbody>
                            </table>
                            @if($invoices){!! $invoices->render() !!}@endif
                            @endif
                          </div>
                       </div>   
                
    </div><!-- /#right-panel -->                            
 <script  src="{{ asset('js/showDeleteInvoices.js') }}"></script>
 @endsection