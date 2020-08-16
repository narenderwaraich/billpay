@extends('layouts.app')
@section('content')
<form action="{{action('InvoiceController@updateInvoices',$id) }}" method="post" id="MailData">
  {{ csrf_field() }}
    <div class="row">
      <div class="col-12 col-sm-4 col-md-6 col-lg-5 col-xl-4">
      <span class="clients-title">EDIT INVOICE {{$inv->invoice_number}}</span> 
      </div>

      <div class="col-12 col-sm-8 col-md-6 col-lg-7 col-xl-8">
         <div class="top-btn">
            <a href="{{ (request()->is('invoice/*')) ? '/invoice/view' : '/dashboard' }}"><button type="button" class="save-btn"><img src="/images/invoice-icons/cancel_btn.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/cancel_btn-active.svg" class="form-top-btn-icon">
              <span class="form-top-btn-icon-title">Cancel</span></button></a>
              
            <a href="#"><button type="submit" class="save-btn"><img src="/images/invoice-icons/save-invoice-icon.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/save-invoice-icon-active.svg" class="form-top-btn-icon"><span class="form-top-btn-icon-title">Save</span></button></a> 
        </div>
      </div>
    </div> <!-- end row -->
  <div class="row  edit-inv-area">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">  
                
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-4">
                    <div class="drop-down">
                        <select id="client-div" name="client_id">
                            @foreach ($clientDD as $client)     
                             <option style="background-image:url('/company_logo/{{$client['logo']}}');background-size:20px" class="en icon_img" value="{{ $client['id'] }}, {{ $client['companies_id'] }}"
                             {{ ( $client['id']== $inv->client->id) ? 'selected' : '' }} 
                             >{{ $client['fname']}} {{ $client['lname']}}, {{$client['email']}}</option>
                            @endforeach             
                        </select>             
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-4 mob-date-div">
                    <div class="edit-inv-date-title">ISSUE DATE</div>
                    <div class="inv-date"><input type="text" name="issue_date" id="datepicker" value="{{ date('m/d/Y', strtotime($inv->issue_date)) }}" class="datePick" width="150" />
                    <!-- <input type="text" name="" class="date-input" id="datepicker"><span><i class="fa fa-calendar clender-icon"></i></span>  --></div>
                    <div class="edit-inv-date-title">DUE DATE</div>
                    <div class="inv-date"><input type="text" name="due_date" value="{{ date('m/d/Y', strtotime($inv->due_date)) }}" id="datepicker2" width="150" class="datePick" />
                    <!-- <input type="text" name="due_date" class="date-input"><span><i class="fa fa-calendar clender-icon"></i></span> --></div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <div id="hiddnbox">
                      <div class="inv-name"><span id="fn">{{$inv->client->fname}}</span>&nbsp;<span id="ln">{{$inv->client->lname}}</span></div>
                      <div id="companyName" class="copmany-name">{{$inv->companies->name}}</div>
                      <div class="inv-email" id="em">{{$inv->client->email}} </div>
                        <div>
                            <div class="col-3 col-sm-2 col-md-4 col-lg-4 col-xl-4">
                              <img src="/company_logo/{{$inv->companies->logo}}" class="edit-inv-logo" id="companyLogo">
                              <div id="clientImage" style="display: none;"></div>
                            </div>
                            <div class="col-9 col-sm-10 col-md-8 col-lg-8 col-xl-8">
                              <div class="inv-address" id="ad">{{$inv->client->address}}</div>
                              <div class="inv-city" id="ci">{{$inv->client->city}}</div>
                              <div class="inv-state" id="st">{{$inv->client->state}}</div>
                              <div class="inv-country" id="cu">{{$inv->client->country}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <hr class="inv-line">
                </div>
            </div>
          @foreach($invItem as $index => $item)
            <div class="row .dlt_{{$item->id}} frmCount" id="frm{{ $index }}">
                <div class="col-12 col-sm-6 col-md-5 col-lg-6 col-xl-6 edit-inv-heading" style="padding-left: 50px;">
                      <div class="form-group">
                        <label for="name">Item Description</label>
                        <input name="arr[{{$index}}][item_name]" type="text" value="{{$item->item_name}}" class="form-control input-filed input-border" placeholder="Enter-item-Name" required>
                        <textarea  class="form-control input-filed input-border" rows="2" id="comment" name="arr[{{$index}}][item_description]"  placeholder="Enter-item-description" required>{{$item->item_description}}</textarea>
                      </div>
                </div>
          
                  <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 edit-inv-heading">
                        <div class="form-group">
                          <label for="rate">Rate</label>
                          <input min="0" id="rate{{ $index }}" name="arr[{{$index}}][rate]"  value="{{$item->rate}}" type="text" class="form-control input-amt input-border" placeholder="Rate" onkeyup="calc(this, {{ $index }})"   required>
                        </div>
                  </div>
                  <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 edit-inv-heading">
                          <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input min="0" id="qty{{ $index }}" name="arr[{{$index}}][qty]" type="text" value="{{$item->qty}}" class="form-control input-amt input-border" placeholder="Quantity" onkeyup="calc(this, {{ $index }})" required>
                          </div>
                  </div>
                  <div class="col-12 col-sm-2 col-md-3 col-lg-2 col-xl-2 edit-inv-heading">
                          <p>Line Total</p>
                            <strong>$ <input type="text" readonly name="arr[{{$index}}][total]" onkeyup="calc(this, {{ $index }})"  class="tot input-calculation input-amt"  id="total{{ $index }}" value="{{$item->total}}" style="border: 0px solid;"></strong>
                              <span>       
                                  <i class="fa fa-trash fa-lg btn_remove delete-Item" DeleteId="{{$item->id}}" style="font-size: 22px; color: red;cursor: pointer;" name="remove" id="{{ $index }}"></i>
                              </span>
                  </div>

                    <input type="hidden" name="arr[{{$index}}][invoice_id]"  value='{{$item->invoice_id}}'>
                    <input type="hidden" name="arr[{{$index}}][item_id]" value='{{$item->id}}'>

                </div>
                @endforeach
                <input type="hidden" name="delete_id" id="storeId">
          
            <div class="row">
                <div id="dynamic_field" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-remove-pad dynamic-added-padding"></div>
            </div>
              <div class="row">
                  <button data-total-items="{{ $index + 1 }}" type="button" name="add" id="addForm" class="btn add-btn remove-top focus-border"><i class="fa fa-plus-square"></i> Add a Line</button>
              </div>
            <!-- end div form -->
          

          
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-6 col-xl-8 row-remove-pad padding-left-invoice edit-inv-heading">
                            <div class="remove-top" style="margin-top: 50px;">
                                <div class="form-group">
                                     <label for="comment">Notes</label>
                                      <textarea class="form-control input-border" rows="2" id="comment" name="notes" placeholder="Enter notes or bank transfer details (optional)">{{$inv->notes}}</textarea>
                                </div>
                            <div class="form-group">
                             <label for="comment">Terms</label>
                              <textarea class="form-control input-border" rows="2" id="comment" name="terms"  placeholder="Please write Terms of invoice here. it will go with invoice to client.">{{$inv->terms}}</textarea>
                            </div>
                        </div>   
            </div>
              <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-4 row-remove-pad">
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 add-inv-heading remove-top" style="margin-top: 50px;">Payment Method</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount remove-top" style="margin-top: 50px;">
                      <select name="payment_mode" class="form-control input-border" style="width: 110px;text-align: center;" required>
                        <option value="STRIPE-PAYMENT" {{ $inv->payment_mode == 'STRIPE-PAYMENT' ? 'selected' : ''}}>STRIPE</option>
                        <option value="BANKWIRE-PAYMENT" {{ $inv->payment_mode == 'BANKWIRE-PAYMENT' ? 'selected' : ''}}>BANK</option>
                        <option value="OFFLINE-PAYMENT" {{ $inv->payment_mode == 'OFFLINE-PAYMENT' ? 'selected' : ''}}>OFFLINE</option>
                      </select>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 edit-inv-heading remove-top" style="margin-top: 10px;">Sub Total</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount remove-top" style="margin-top: 10px;">$ <input type="number" name="sub_total" id="total" onchange="myFunction()"  readonly value="{{$inv->sub_total}}" class="input-calculation" style="outline: none;"></div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 edit-inv-heading"><span>Discount <span class="percentage-text"><input type="text" name="disInPer" value="{{$inv->disInPer}}" id="getValuePerDiscount" class="invoice-dis-value-input" readonly></span></span></div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ <input name="discount" id="discount" onchange="myFunction()"  readonly value="{{$inv->discount}}" class="input-calculation" placeholder="0" data-toggle="modal" data-target="#discountModal" style="outline: none;cursor: pointer;"></div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 edit-inv-heading"><span>Tax <span class="percentage-text"><input type="text" name="taxInPer" id="getValuePerTax" value="{{$inv->taxInPer}}" class="invoice-dis-value-input" readonly></span></span></div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ <input name="tax_rate" id="tax_rate" onchange="myFunction()"  readonly value="{{$inv->tax_rate}}" class="input-calculation" data-toggle="modal" data-target="#taxModal" style="outline: none;cursor: pointer;"></div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 edit-inv-heading">Deposit Amount</div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ <input type="text" name="deposit_amount" id="deposit" value="{{$inv->deposit_amount}}"  placeholder="enter-amount" onchange="myFunction()"  class="input-calculation on-focus-border"></div>
                  <div class="col-sm-12">
                  <hr class="inv-line-cal">
                  </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 edit-inv-heading">Total Amount</div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">
                      $ <input type="number" name="net_amount" id="net_amount"  readonly value="{{$inv->net_amount}}" onchange="myFunction()" class="input-calculation" style="outline: none;"></div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 edit-inv-heading">Amount Paid</div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">
                      $ <input type="number" name="" id="totalAmount" readonly value="{{ $inv->net_amount - $inv->due_amount }}" class="input-calculation" style="outline: none;"></div> 
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 edit-inv-heading">Net Amount Due</div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount on-mob-pad-bottom" style="padding-bottom: 20px;">$ <input type="number" name="due_amount" value="{{$inv->due_amount}}" id="duePending"  readonly  onchange="myFunction()" class="input-calculation" style="outline: none;"></div>
          </div>
          </div>
    </div>
   </div> 

   <input type="hidden" name="disInFlat" id="getValueFlatDiscount" value="{{$inv->disInFlat}}">
   <input type="hidden" name="taxInFlat" id="getValueFlatTax" value="{{$inv->taxInFlat}}">
   
</form>

 

                                  <!-- <div class="modal fade" id="myModal" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title">Send Invoice</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                            
                                            <div class="form-group">
                                                <label>To</label>
                                                <input type="text" name="email" readonly value="" id="email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Additional Email</label>
                                                <input type="text" name="additional_email" value=""  class="form-control" placeholder="Type email...">
                                            </div>
                                         
                                          </div>
                                          <div class="modal-footer">
                                            <span><img src="/images/wait.gif" id="loading" style="height: 65px; display: none;"> </span>
                                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="addOrRemoveEmail('remove')">Close</button>
                                            <button type="button"  class="btn btn-info" id="saveForm">Send</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div> -->
      
      <!-- discount Modal -->
<div class="modal fade add-discount-modal" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-sm dis-mdl" role="document">
                        <div class="modal-content" style="background-color: #fff !important;border-radius: 0.3rem !important;">
                            <div class="modal-header">
                              Add Discount
                            </div>
                            <div class="modal-body dis-tax-modal">
                              <div class="radio-btn">
                                <input type="radio" name="dis_type" id="flat_radio" checked="checked">
                              </div>

                              <div class="in-label">
                                Flat
                              </div>
                              <div class="input-div">
                                <input type="text" name="disValueFlat" placeholder="0" id="disValueFlat" value="{{$inv->disInFlat}}" class="dis-model-input" onkeyup="myFunction()"  />
                              </div>
                              <div class="radio-btn2">
                                <input type="radio" name="dis_type" id="percentage_radio">
                              </div>

                              <div class="in-label2">
                                Percentage
                              </div>
                              <div class="input-div2">
                                <input type="text" name="disValuePer" value="{{$inv->disInPer}}" placeholder="0" id="disValuePer" onkeyup="myFunction()" onchange="myFunction()" class="dis-model-input"  disabled="disabled" />
                              </div>
                            </div>
                            <div class="modal-footer" style="display: flex !important;">
                                   <button type="button" id="refresh" class="btn model-alert-btn" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Tax Modal -->
<div class="modal fade add-discount-modal" id="taxModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-sm dis-mdl" role="document">
                        <div class="modal-content" style="background-color: #fff !important;border-radius: 0.3rem !important;">
                            <div class="modal-header">
                              Add Tax
                            </div>
                            <div class="modal-body dis-tax-modal">
                              <div class="radio-btn">
                                <input type="radio" name="tax_type" id="tax_flat_radio" checked="checked">
                              </div>

                              <div class="in-label">
                                Flat
                              </div>
                              <div class="input-div">
                                <input type="text" name="taxValueFlat" placeholder="0" id="taxValueFlat" value="{{$inv->taxInFlat}}" class="dis-model-input" onkeyup="myFunction()"  />
                              </div>
                              <div class="radio-btn2">
                                <input type="radio" name="tax_type" id="tax_per_radio">
                              </div>

                              <div class="in-label2">
                                Percentage
                              </div>
                              <div class="input-div2">
                                <input type="text" name="taxValuePer" value="{{$inv->taxInPer}}" class="dis-model-input" placeholder="0" id="taxValuePer" onkeyup="myFunction()" onchange="myFunction()"  disabled="disabled" />
                              </div>
                            </div>
                            <div class="modal-footer" style="display: flex !important;">
                                   <button type="button" id="refresh" class="btn model-alert-btn" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>


                          

                  <script  src="{{ asset('js/invoice-edit.js') }}"></script> 

                  <script>
                    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                      $('#datepicker').datepicker({
                          uiLibrary: 'bootstrap4',
                          minDate: today,
                          format: 'mm/dd/yyyy'
                      });
                  </script>
               <script>
                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                      $('#datepicker2').datepicker({
                          uiLibrary: 'bootstrap4',
                          minDate: today,
                          format: 'mm/dd/yyyy'
                      });
                  </script>

                  

@endsection
