@extends('layouts.app')
@section('content')
	<div class="invoice-view-page" style="padding-bottom: 10px;">
		<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
			<div class="inv-number-txt">{{$inv->invoice_number}}</div>
		@if($inv->status == "CANCEL")
			<div class="cancel-status-text refund-btn-hide-on-mob">CANCELLED ON {{ date('m/d/Y', strtotime($inv->refund_date)) }}</div>
		@endif
		</div>
	@if($inv->status == "CANCEL")
		<div class="col-12 refund-btn-show-on-mob txt-center" style="display: none;">
			<div class="refund-btn-show-on-mob cancel-status-text" style="display: none;">CANCELLED ON {{ date('m/d/Y', strtotime($inv->refund_date)) }}</div>
		</div>
	@endif
	<!-- 	<div class="col-6 col-sm-6 refund-btn-show-on-mob refund-btn-div" style="display: none;">
			<a href="/cancel-invoice/{{$inv->id}}">
				<img src="/images/invoice-icons/cancel-invoice-icon.svg" class="refund-btn-icon"><img src="/images/invoice-icons/cancel-invoice-icon-active.svg" class="refund-btn-icon">
				<span class="refund-btn-icon-title">Cancel</span>
			</a>
		</div> -->

		
		<div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 m-t-50">
			<div class="row inv-view-btn">
				
				<!-- Back Button -->
				<a href="/delete/invoice/view"><img src="/images/invoice-icons/back-icon.svg" class="btn-icon"><img src="/images/invoice-icons/back-icon-active.svg" class="btn-icon  ">
					<span class="btn-icon-title bk-btn-text">Back</span>
				</a>
					<!-- Restore Button -->
				<a href="/delete/invoice/restore/{{$inv->id}}"><img src="/images/navicons/restore-invoice-icon.svg" class="btn-icon "><img src="/images/navicons/restore-invoice-icon-active.svg" class="btn-icon ">
					<span class="btn-icon-title ed-btn-text">Restore</span>
				</a>
				
					<!-- Delete Button -->
				<a href="/delete/invoice/single/{{$inv->id}}"><img src="/images/navicons/delete-forever-invoice-icon.svg" class="btn-icon   btn-icon-top"><img src="/images/navicons/delete-forever-invoice-icon-active.svg" class="btn-icon   btn-icon-top">
					<span class="btn-icon-title download-btn-text">Delete</span>
				</a>				
			</div>
		</div>

		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="invoice-amount-pay-status invoice_payment_status_{{$inv->status}}">
			@if($inv->status == "PAID-STRIPE" || $inv->is_cancelled ==1)
			HURRAY! PAID IN FULL ON DATE {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$clientData->fname}} {{$clientData->lname}}
			@endif

			@if($inv->status == "DEPOSIT_PAID" || ($inv->status == "OVERDUE" && $inv->net_amount != $inv->due_amount) || $inv->is_cancelled ==2)
			DEPOSIT $ {{$inv->deposit_amount}} USD PAID ON {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$clientData->fname}} {{$clientData->lname}}
			@endif
			</div>
				<!-- <div class="inv-status-div" style="display: none;" id="showStatus">
					<input type="hidden" name="" id="amountStatus" value="{{ $inv->status}}">
					<div class="inv-status"> Paid in Full on {{ date('d/m/Y', strtotime($inv->due_date)) }} by {{$clientData->fname}} {{$clientData->lname}} using Visa Card</div>	
				</div> -->
				
		</div>

	</div>
	
	
	

	

	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 invoice-view-blade inv-area row-remove-pad-on-ip">
					<div class="inv-box-title hide-on-mob">
						INVOICE TO
					</div>
					<div class="col-12 col-sm-12 col-md-4 col-lg-5 col-xl-4 clint-data row-remove-pad">
						<div class="inv-name">{{$user->fname}} {{$user->lname}}</div>
						<div class="copmany-name">{{$user->company_name}}</div>
						<div class="inv-email">{{$user->email}}</div>
						<div>
							<div class="col-4 col-sm-3 col-md-4 col-lg-3 col-xl-3 remove-add-5px-peding">
								@if(!empty($user->avatar))
								<img src="/images/avatar/{{$user->avatar}}" class="img-fluid">
								@else
								<div id="userImage"></div>
								@endif
								
							</div>
							<div class="col-8 col-sm-9 col-md-8 col-lg-9 col-xl-9 remove-add-5px-peding">
								<div class="inv-address">{{$user->address}}</div>
								<div class="inv-state">{{$user->state}}</div>
								<div class="inv-city">{{$user->city}}</div>
								<div class="inv-country">{{$user->country}}</div>
							</div>
						</div>
					</div>
					<hr class="show-line row-remove-pad">
					<div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-4 mob-date-div row-remove-pad">
						
						<!-- <br class="hide-on-ipad"> -->
						<div class="inv-date-title">ISSUE DATE</div>
						<div class="inv-date2">{{ date('m/d/Y', strtotime($inv->issue_date)) }}</div>
						<div class="inv-date-title">DUE DATE</div>
						<div class="inv-date2">{{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
					</div>
					<hr class="show-line row-remove-pad">
					<div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 clint-data row-remove-pad">
						<div class="inv-name inv-to-position">{{$clientData->fname}} {{$clientData->lname}}</div>
						<div class="copmany-name">{{$companyData->name}}</div>
						<div class="inv-email">{{$clientData->email}}</div>
						<div>
							<div class="col-4 col-sm-3 col-md-4 col-lg-3 col-xl-3 remove-add-5px-peding">
								@if(!empty($companyData->logo))
								<img src="/company_logo/{{$companyData->logo}}" class="img-fluid">
								@else
								<div id="clientImage"></div>
								@endif
								
							</div>
							<div class="col-8 col-sm-9 col-md-8 col-lg-9 col-xl-9 remove-add-5px-peding">
								<div class="inv-address">{{$clientData->address}}</div>
								<div class="inv-state">{{$clientData->state}}</div>
								<div class="inv-city">{{$clientData->city}}</div>
								<div class="inv-country">{{$clientData->country}}</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 GST-Number">
						<div class="gst-num">{{$user->gstin_number}}</div>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-remove-pad">
						<hr class="inv-line">
					</div>
					
					

					@foreach($invItem as $index => $item)
					<div class="col-sm-3 col-6 col-md-3 col-lg-3 col-xl-2 inv-data" style="padding-left: 35px;">
						<div class="inv-heading">Item</div>
						{{$item->item_name}}
					</div>
					<div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 inv-data hide-on-mob">
						<div class="inv-heading">Description</div>
						{!! nl2br($item->item_description) !!}
					</div>
					<div class="col-sm-3 col-6 col-md-3 col-lg-3 col-xl-2 inv-data">
						<div class="inv-heading">Rate</div>
						$ {{$item->rate}}
					</div>
					<div class="col-sm-3 col-6 col-md-3 col-lg-3 col-xl-2 inv-data margin-t">
						<div class="inv-heading">Quantity</div>
						$ {{$item->qty}}
					</div>
					<div class="col-sm-3 col-md-3 col-6 col-lg-3 col-xl-2 inv-data margin-t">
						<div class="inv-heading">Line Total</div>
						$ {{$item->total}}
					</div>

					<div class="col-12 col-sm-12 col-lg-12 inv-data show-on-mob" style="display: none;">
						<div class="inv-heading">Description</div>
						{!! nl2br($item->item_description) !!}
					</div>

					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-remove-pad">
						<hr class="inv-line">
					</div>

					@endforeach
					

					

					<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-8 inv-heading" style="padding-left: 35px;">
						
						<div>Notes: <br>
							{!! nl2br($inv->notes) !!}
						</div>
						<br>
						<div>Terms: <br>
							{!! nl2br($inv->terms) !!}
						</div> 
						<hr class="show-line">
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 row-remove-pad">
						<div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-heading">Payment Method</div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">{{$inv->payment_mode}}</div>
						</div>
						
						<div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-heading">Sub Total</div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->sub_total}}</div>
						</div>

						<div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-heading">Discount  <span class="percentage-text">@if(!empty($inv->disInPer)){{$inv->disInPer}}% @else @endif</span></div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->discount}}</div>
						</div>

						<div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-heading">Tax <span class="percentage-text">@if(!empty($inv->taxInPer)){{$inv->taxInPer}}% @else @endif</span></div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->tax_rate}}</div>
						</div>

						<div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-heading">Deposit Amount</div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->deposit_amount}}</div>
						</div>

						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-remove-pad">
						<hr class="inv-line">
						</div>

                		<div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-heading">Total Amount</div>		
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->net_amount}}</div>
                        </div>

						<div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-heading">Amount Paid</div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->net_amount - $inv->due_amount}}</div>		
                            <!-- @if($inv->status =="DEPOSIT_PAID")
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->deposit_amount}}</div>
                            @elseif($inv->status =="PAID-STRIPE")
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->net_amount}}</div>
                            @else
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ 0</div>
                            @endif -->
                        </div>
					

						<div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-heading">Net Amount Due</div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount on-mob-pad-bottom" style="padding-bottom: 20px;">$ {{$inv->due_amount}}</div>
						</div>
					</div>


	
	</div>

 							<!-- client or user Name to Image -->

 							<span id="clientFirstName" style="display: none;">{{$clientData->fname}}</span>
							<span id="clientLastName" style="display: none;">{{$clientData->lname}}</span>

							<span id="userFirstName" style="display: none;">{{$user->fname}}</span>
							<span id="userLastName" style="display: none;">{{$user->lname}}</span>


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
                                                <input type="text" name="email" readonly value="{{$clientData->email}}"  class="form-control model-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Additional Email</label>
                                                <input type="text" name="additional_email" value=""  class="form-control model-input" placeholder="Type email...">
                                            </div>
                                            <input type="hidden" name="" id="invshow" value="{{$inv->id}}">
                                          </div>
                                          <div class="modal-footer">
                                            
                                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
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
                                                <input type="text" name="email" readonly value="{{$clientData->email}}"  class="form-control model-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Additional Email</label>
                                                <input type="text" name="additional_email" value=""  class="form-control model-input" placeholder="Type email...">
                                            </div>
                                            <input type="hidden" name="" id="invshowID" value="{{$inv->id}}">
                                          </div>
                                          <div class="modal-footer">
                                            
                                            <center><button type="submit" id="send-mail-btn2" class="btn modal-btn">
                                              <span id="reminder-send-btn">Send</span>
                                              <span id="reminder-button-sending" style="display:none;">Sending…</span>
                                              </button></center>
                                            
                                            <button type="button" class="close" data-dismiss="modal">&times;</button> 

                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>


<script  src="{{ asset('js/InvoiceView.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
     var firstName = $('#clientFirstName').text();
     var lastName = $('#clientLastName').text();
     var dot = '.';
     var intials = firstName.charAt(0) + dot + lastName.charAt(0);
     var profileImage = $('#clientImage').text(intials);
     });
</script>
<script type="text/javascript">
$(document).ready(function(){
     var firstName = $('#userFirstName').text();
     var lastName = $('#userLastName').text();
     var dot = '.';
     var intials = firstName.charAt(0) + dot + lastName.charAt(0);
     var profileImage = $('#userImage').text(intials);
     });
</script>


@endsection

  

                            