@extends('layouts.app')
@section('content')
    <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2" style="padding-top: 15px;">
        <h5>Recent Invoices</h5>
    </div> 
    <div class="col-6 col-sm-8 col-md-8 col-lg-9 col-xl-10 view-page-add-btn">
     <a href="/invoice"><button type="button" class="btn add-invoice-btn"><img src="/images/invoice-icons/invoice-add-icon.svg"><img src="/images/invoice-icons/invoice-add-icon-active.svg"></button></a>
    </div>

    <div class="search-bar">
                  <form action="/invoice/search" method="GET" id="SearchData" role="search">
                  <div class="col-xs-3 col-sm-12 col-md-3 col-lg-3 col-xl-2" style="clear: both;">
                    <div class="dropdown btn-move">
                      <button type="button" class="btn dropdown-toggle action-btn mobile-view-action-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="action-btn" disabled="disabled">
                        ACTIONS <span class="caret"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item action-list sendInvoice" href="#" data-toggle="modal" data-target="#myModal" id="sendButton" style="display: none;">SEND EMAIL</a>
                        <a class="dropdown-item action-list sendReminder" href="#" data-toggle="modal" data-target="#sendReminderModel" id="reminderButton" style="display: none;">SEND REMINDER</a>
                         <a class="dropdown-item action-list" id="markSent" href="#">MARK AS SENT</a>
                         <a class="dropdown-item action-list" id="depositPaid" href="#">DEPOSIT PAID</a>
                         <a class="dropdown-item action-list" id="markOfflinePaid" href="#">PAID OFFLINE</a>
                         <a class="dropdown-item action-list" id="markbankPaid" href="#">PAID BANKWIRE</a>
                         <a class="dropdown-item action-list" id="markStripePaid" href="#">PAID STRIPE</a>
                         <a class="dropdown-item action-list" id="markOverdue" href="#">OVERDUE</a>
                         <a class="dropdown-item action-list downloadInvoice" href="#" id="downloadButton" style="display: none;">DOWNLOAD INVOICE</a>
                        <a class="dropdown-item action-list editInvoice" href="#" id="editButton" style="display: none;">EDIT</a>
                        <a class="dropdown-item  action-list delete_all" href="#">DELETE</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-5 col-lg-6 col-xl-8">
                    
                  <input type="text" name="q" value="{{request('q')}}" id="search" class="form-control serach-input" placeholder="Search by Client name, Status, Invoice number">
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
                         <a href="/invoice/view"><button type="button" class="clear-btn-icon" id="clear-btn"><img src="/images/delete-invoice-icon.svg" width="34px"> <br><span class="clear-icon-title">Clear</span></button></a>
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
                    <!-- <span id="record">@if( ! empty( $total_row)) {{ $total_row}} Invoice found match your search @else Invoice not found match Your search @endif</span> --></div>

                <div class="col-sm-12 m-t-35">
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
                                    <tr id="tr_{{$invoice->id}}" class="clickable-row" data-href='/invoice/view/{{$invoice->id}}' style="cursor: pointer;">
                                      <th scope="row" class="td-inv-name"><input type="checkbox" class="sub_chk" data-id="{{$invoice->id}}" token-data="{{$invoice->invoice_number_token}}" email-id="{{ $invoice->client->email }}"> <a href="/invoice/view/{{$invoice->id}}"> {{ $invoice->client->fname }}  {{ $invoice->client->lname }}<br>
                                       <span class="td-inv-no">{{ $invoice->invoice_number}}</span> </a></th>
                                      <td class="td-inv-name">{{ date('m/d/Y', strtotime($invoice->issue_date)) }}</td>
                                      <td class="td-inv-name hide-data-mobile-view">{{ date('m/d/Y', strtotime($invoice->due_date)) }}</td>
                                      <td class="status_{{ strtolower($invoice->status)}}">{{ $invoice->status}} <br>
                                        @if($invoice->status == "OVERDUE" && $invoice->net_amount != $invoice->due_amount)
                                        <span class="td-inv-amount-status">DEPOSIT PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                                        @endif
                                        @if($invoice->status == "PAID-STRIPE" || $invoice->status == "PAID-BANKWIRE" || $invoice->status == "PAID-OFFLINE")
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
                       <div class="col-sm-12">
                  <h5>Your Recents</h5>  
                </div>
                  <center>
                    @if(isset($invoices))
                    @foreach ($invoices->take(3) as $invoice)
                  <a href="/invoice/view/{{ $invoice->id }}">
                   <div class="col-sm-4">
                     <div class="invoice-status-box2">

                       <div class="inv-title-text3">{{ $invoice->client->fname }}  {{ $invoice->client->lname }}
                      <br>
                      <div class="inv-em">{{ $invoice->client->email }}</div>
                      <div class="invoi-company-name">{{ $invoice->companyName }}</div>
                       <hr class="inv-box-line">
                       <div class="inv-amount-show">${{ $invoice->net_amount}}
                       <br>
                       USD </div>
                       <div class="inv-number">{{ $invoice->invoice_number}}</div>
                       <hr class="inv-box-line2">
                       <div class="inv-box-date">{{ $invoice->created_at->format('m/d/Y') }}
                        <span class="inv-status_{{ $invoice->status}}">{{ $invoice->status}}</span>
                       </div>
                       </div>
                     </div>
                   </div>
                 </a>
                   @endforeach
                    @endif
                  </center>
                
                
        </div> <!-- .content -->
    </div><!-- /#right-panel -->










                                  <!--Send Mail Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <div class="modal-title-text">
                                              Send Invoice
                                            </div>
                                          </div>
                                          <div class="modal-body">
                                            <form  id="MailData" method="post">
                                                {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>To</label>
                                                <input type="text" name="email" readonly value="" id="inv_email" class="form-control model-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Additional Email</label>
                                                <input type="text" name="additional_email" value=""  class="form-control model-input" placeholder="Type email...">
                                            </div>
                                            <input type="hidden" name="" id="invshow">
                                          </div>
                                          <div class="modal-footer">
                                          
                                            <center><button type="submit" id="send-mail-btn" class="btn modal-btn">
                                              <span id="send-btn">Send</span>
                                              <span id="mail-button-sending" style="display:none;">Sending…</span>
                                              </button></center>
                                            
                                            <button type="button" class="close" data-dismiss="modal">&times;</button> 

                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>


                                     <!--Send Reminder Modal -->
                                    <div class="modal fade" id="sendReminderModel" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <div class="modal-title-text">
                                              Invoice Reminder
                                            </div>
                                          </div>
                                          <div class="modal-body">
                                            <!-- <img src="/images/loader.gif" id="loading" style="height: 65px;"> -->
                                            <form  id="ReminderMailData" method="post">
                                                {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>To</label>
                                                <input type="text" name="email" readonly value="" id="get_inv_email" class="form-control model-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Additional Email</label>
                                                <input type="text" name="additional_email" value=""  class="form-control model-input" placeholder="Type email...">
                                            </div>
                                            <input type="hidden" name="" id="invshowID">
                                          </div>
                                          <div class="modal-footer">
                                            
                                            <center><button type="submit" id="send-mail-btn" class="btn modal-btn">
                                              <span id="reminder-send-btn">Send</span>
                                              <span id="reminder-button-sending" style="display:none;">Sending…</span>
                                              </button></center>
                                            
                                            <button type="button" class="close" data-dismiss="modal">&times;</button> 

                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>

<div id="progress" class="dialogContent" style="text-align: left; display: none;">
  <img src="/images/gif/ajax-loader.gif" style="margin: auto;display: block;" />
  <h5 style="margin-top: 10px;">Please wait...</h5>
  <asp:literal id="literalPleaseWait" runat="server" text="Please wait..." />
</div>                    
 <script  src="{{ asset('js/showInvoices.js') }}"></script>
                   <!-- <script>
                     //// invoice search 

                          $(document).ready(function(){

                           fetch_customer_data();

                           function fetch_customer_data(query = '')
                           {
                            $.ajax({
                             url:"{{ route('inv_search.SearchInvData') }}",
                             method:'GET',
                             data:{query:query},
                             dataType:'json',
                             success:function(data)
                             {
                              $('tbody').html(data.table_data);
                             }
                            })
                           }

                           $(document).on('keyup', '#search', function(){
                            var query = $(this).val();
                            if($('#search').val()==""){
                              $('#page').show();
                            }else{
                              $('#page').hide();
                            }
                            fetch_customer_data(query);
                           });
                          });
                    </script> -->


@endsection