@extends('layouts.app')
@section('content')
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
<div class="content">
    <div class="row">
      <div class="col-lg-8">
        <div class="card card-user">
            <div class="image">
                <img src="/public/images/bg.jpg" alt="">
            </div>
          <div class="card-body">
              <div class="author">
                <a href="#">
                  <img class="avatar border-gray" src="/public/images/icon/user.jpg" alt="Client">
                  <h5 class="title"><span id="first_name">{{$client->fname}}</span> <span id="last_name">{{$client->lname}}</span></h5>
                </a>
                <hr>
                <div class="row">
                  <div class="col-lg-9">
                    <div class="client-data" id="client_email">Email : <span id="client_email_data">{{$client->email}}</span></div>
                    <div class="client-data" id="client_phone">Phone : <span id="client_phone_data">{{$client->phone}}</span></div>
                    <div class="client-data" id="client_country">Country : <span id="client_country_data">{{$client->country}}</span></div>
                    <div class="client-data" id="client_state">State : <span id="client_state_data">{{$client->state}}</span></div>
                    <div class="client-data" id="client_city">City : <span id="client_city_data">{{$client->city}}</span></div>
                    <div class="client-data" id="client_zip">ZipCode : <span id="client_zip_data">{{$client->zipcode}}</span></div>
                    <div class="client-data" id="client_address">Address : <span id="client_address_data">{{$client->address}}</span></div>
                  </div>
                  <div class="col-lg-3">
                    <br>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="text" name="issue_date" value="{{ date('m/d/Y', strtotime($inv->issue_date)) }}" id="datepicker"  class="form-control datePick" width="150" />
                          <label style="z-index: 2;">ISSUE DATE</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="text" name="due_date" value="{{ date('m/d/Y', strtotime($inv->due_date)) }}" id="datepicker2" width="150" class="form-control datePick" />
                          <label style="z-index: 2;">DUE DATE</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Action</h5>
            <hr>
          </div>
          <div class="card-body">
          	<div class="row">
                <div class="col-lg-12" style="margin: auto;text-align: center;">
		          	<a href="#" data-toggle="modal" class="btn-success btn-sm" data-target="#myModal">Send</a>
		          	<a href="/invoice/edit/{{$inv->id}}" class="btn-primary btn-sm">Edit</a>
		          	<a href="/invoice/download/PDF/{{$inv->id}}/{{$inv->invoice_number_token}}" class="btn-dark btn-sm">Download</a>
		          	<a href="/invoice/copy/{{$inv->id}}" class="btn-secondary btn-sm">Copy</a>
		        </div>
		    </div>
		    <br>
		    <div class="row">
                <div class="col-lg-12" style="margin: auto;text-align: center;">
		          	<a href="#" class="cancel_invoice btn-warning btn-sm" CancelId="{{$inv->id}}">Cancel</a>
		          	<a href="#" class="del_invoice btn-danger btn-sm" DeleteId="{{$inv->id}}">Delete</a>
		            <a href="/invoice/print/PDF/{{$inv->id}}/{{$inv->invoice_number_token}}" target="_blank" class="btn-info btn-sm" data-Id="{{$inv->id}}">Print</a>
		            <a href="#" class="btn-dark btn-sm" onclick="goBack()">Back</a>
                <br><br>
                <a href="/invoice/cash/pay/{{$inv->id}}" class="btn-success btn-lg">Cash Pay Invoice</a>
            	</div>
		    </div>
        <br>
          </div>
        </div>
      </div>
    </div>

    <!-- Invoice items add section -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Invoice Items</h5>
            <hr>
          </div>
          <div class="card-body">
            @foreach($invItem as $index => $item)
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <input type="text" name="arr[{{$index}}][item_name]" value="{{$item->item_name}}" class="form-control" readonly style="background-color: transparent;">
                    <label>Item Name</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input min="0" id="rate{{ $index }}" name="arr[{{$index}}][rate]"  value="{{$item->rate}}" type="text" class="form-control input-amt input-border" onkeyup="calc(this, {{ $index }})" readonly style="background-color: transparent;">
                    <label>Rate</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input min="0" id="qty{{ $index }}" name="arr[{{$index}}][qty]" type="text" value="{{$item->qty}}" class="form-control input-amt" onkeyup="calc(this, {{ $index }})" readonly style="background-color: transparent;">
                    <label>Quantity</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" name="arr[{{$index}}][total]" onkeyup="calc(this, {{ $index }})"  class="tot input-calculation input-amt form-control"  id="total{{ $index }}" value="{{$item->total}}" readonly style="background-color: transparent;">
                    <label>Total</label>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                   
                  </div>
                </div>
              </div>
               <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <textarea  class="form-control" rows="2" id="comment" name="arr[{{$index}}][item_description]" readonly style="background-color: transparent;">{{$item->item_description}}</textarea>
                    <label>Description</label>
                  </div>
                </div>
              </div>
             @endforeach
             <hr><br>
              <div class="row">
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <textarea class="form-control" rows="8" name="notes" readonly style="background-color: transparent;width: 50%;">{{$inv->notes}}</textarea>
                          <label>Notes (optional)</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                     <div class="form-group">
                          <textarea class="form-control" rows="8" name="terms" readonly style="background-color: transparent;width: 50%;">{{$inv->terms}}</textarea>
                          <label>Terms</label>
                     </div>
                   </div>
                 </div>
                </div>
                <div class="col-md-3">
                   <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                      <label style="margin-top: 8px;">Payment Method</label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                     	<div style="font-weight: 500;color: #757575;font-size: 10px;">{{$inv->payment_mode}}</div>
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                      <label style="margin-top: 6px;">Sub Total</label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                       <input type="number" name="sub_total" id="total" onchange="myFunction()"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="{{$inv->sub_total}}" class="input-calculation form-control">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                      <label style="margin-top: 6px;">Discount <span class="percentage-text" id="show-percentage-val" style="display: none;margin-left: 5px;">(<input type="text" name="disInPer" value="{{$inv->disInPer}}" id="getValuePerDiscount" class="invoice-dis-value-input" readonly style="min-width: 17px;max-width: 22px;border: none;">%)</span></label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="discount" id="discount" onchange="myFunction()"  readonly value="{{$inv->discount}}" class="form-control input-calculation" placeholder="0" data-toggle="modal" data-target="#discountModal" readonly style="background-color: transparent;width: 75%;border: none;padding: 0;">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                       <label style="margin-top: 6px;">Tax<span class="percentage-text" id="show-tax-val" style="display: none;margin-left: 5px;">(<input type="text" name="taxInPer" value="{{$inv->taxInPer}}" id="getValuePerTax" class="invoice-dis-value-input" readonly style="min-width: 17px;max-width: 22px;border: none;">%)</span></label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="tax_rate" id="tax_rate" onchange="myFunction()"  readonly value="{{$inv->tax_rate}}" class="form-control input-calculation" data-toggle="modal" data-target="#taxModal" readonly style="background-color: transparent;width: 75%;border: none;padding: 0;">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                      <label style="margin-top: 8px;">Deposit Amount</label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="deposit_amount" id="deposit" value="{{$inv->deposit_amount}}" onkeyup="myFunction()" style="border: none;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;padding: 0;width: 75%;"  class="input-calculation form-control">
                     </div>
                   </div>
                 </div>
                 <hr>
                  <div class="row">
                   <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                      <label style="margin-top: 6px;">Amount Paid</label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="number" name="net_amount" id="net_amount" value="{{$inv->net_amount}}"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="0" onchange="myFunction()" class="input-calculation form-control">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                   <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                      <label style="margin-top: 6px;">Net Amount Due</label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="number" name="due_amount" id="duePending"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="{{$inv->due_amount}}" onchange="myFunction()" class="input-calculation form-control">
                     </div>
                   </div>
                 </div>



                </div>
              </div>


          </div>
        </div>
      </div>
    </div>
</div>



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
                                                <input type="text" name="email" readonly value="{{$inv->client->email}}"  class="form-control model-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Additional Email</label>
                                                <input type="text" name="additional_email" value=""  class="form-control model-input" placeholder="Type email...">
                                            </div>
                                            <input type="hidden" name="" id="invshow" value="{{$inv->id}}">
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


<style>
  .client-data{
    display: block;
  }
</style>






<script type="text/javascript">
                      /// send button in model
								      $(document).ready(function () {
								      $('#send-btn').on('click', function(e) {
								        $('#send-btn').hide();
								        $('#mail-button-sending').show();
								        //$('#send-mail-btn').attr("disabled", "disabled");
								      });
								    });
								            
                            /// send mail
                         
                            $("form#MailData").submit(function(e) {
                              e.preventDefault();    
                              var formData = new FormData(this);
                              var invoice_id = $("#invshow").val();
                              $.ajax({
                                  url: '/invoice/send/'+invoice_id,
                                  type: 'POST',
                                  data: formData,
                                  beforeSend: function() {
                                      $('#send-btn').hide();
                                      $('#mail-button-sending').show();
                                      $("#send-mail-btn").attr("disabled", "disabled");
                                  },
                                  success: function (data) {

                                     if (data['success']) {
                               toastr.success("Mail Sent successfully","Mail");
                                //$('.msgMail').append(data .msg);
                                      $('#mail-button-sending').hide();
                                      $('#send-btn').show();
                                      // $('#hidediv').show();
                                      $('#myModal').hide();
                                      $(".modal .close").click();
                                          //location.reload();
                            } else if (data['error']) {
                                toastr.error("Sorry First Connect to Stripe Account","Mail");
                                $('#myModal').hide();
                                $(".modal .close").click();
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        },
                                  cache: false,
                                  contentType: false,
                                  processData: false
                              });
                          });


                            /// reminder mail send model
                            $("form#ReminderMailData").submit(function(e) {
                              e.preventDefault();    
                              var formData = new FormData(this);
                              var invoice_id = $("#invshowID").val();
                              $.ajax({
                                  url: '/invoice/reminder/send/'+invoice_id,
                                  type: 'POST',
                                  data: formData,
                                  beforeSend: function() {
                                      $('#reminder-send-btn').hide();
                                      $('#reminder-button-sending').show();
                                      $("#send-mail-btn2").attr("disabled", "disabled");
                                  },
                                  success: function (data) {
                                     if (data['success']) {
                                      $('#loading').hide();
                                      toastr.success("Reminder Sent successfully","Reminder");
                                      $('#sendReminderModel').hide();
                                      $(".modal .close").click();
                                          //location.reload();
                                          //$('.msgMail').append(data .msg);
                                          // $('#hidediv').show();
                            } else if (data['error']) {
                                toastr.error("Sorry First Connect to Stripe Account","Reminder");
                                $('#sendReminderModel').hide();
                                $(".modal .close").click();
                                location.reload();
                            } else {
                                toastr.error("Reminder Sent after status OVERDUE","Reminder");
                                $('#sendReminderModel').hide();
                                $(".modal .close").click();
                                setTimeout(function(){
                                location.reload();
                              }, 5000);
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        },
                                  cache: false,
                                  contentType: false,
                                  processData: false
                              });
                          });
                          
                            /// show status div 
                      		$(document).ready(function () {
                      			var status = $("#amountStatus").val();
                      			if(status == "PAID-STRIPE"){
                      				$("#showStatus").show();
                      			}else{
                      				$("#showStatus").hide();
                      			}
                      		});


                          //// copy invoice data
                          // $('.copyInvoice').on('click',function() {
                          //   var id = $(this).attr('data');
                          //        $.ajax({
                          //               url: '/copy-invoice-data/'+id,
                          //               dataType: 'json',
                          //               method : 'post',
                          //               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                          //               data: 'ids='+id,
                          //               success: function (data) {
                          //                   if (data['success']) {
                          //                       toastr.success("Invoice copy success","Success");
                          //                       location.reload();
                          //                   } else if (data['error']) {
                          //                     toastr.error("Invoice not copy success","error");
                          //                   } else {
                          //                       alert('Whoops Something went wrong!!');
                          //                   }
                          //               },
                          //               error: function (data) {
                          //                   alert(data.responseText);
                          //               }
                          //           });
                          //       });

                          // Cancel Invoice 
                 
                           $(document).on('click', '.cancel_invoice', function(){  
                               var msg = confirm('Are you sure want to cancel invoice, this action can not be undone');
                               var invoiceCancelId = $(this).attr("CancelId");
                               if(msg){   
                                   window.location.href = '/cancel-invoice/'+invoiceCancelId;
                               }
                                 
                          }); 

                          // Delete Invoice 
                          $(document).on('click', '.del_invoice', function(){  
                               var msg = confirm('Are you sure? Delete Invoice');
                               var invoiceDelId = $(this).attr("DeleteId");
                               if(msg){   
                                   window.location.href = '/invoice/delete/'+invoiceDelId;
                               }
                                 
                          }); 
                    
 
function goBack() {
  window.history.back();
}
</script>

@endsection

  

                            