@extends('layouts.app')
@section('content')
<form action="/invoice" id="MailData" method="post">
  {{ csrf_field() }}
     <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <span class="clients-title">ADD INVOICE</span> 
      </div>

      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
           <div class="top-btn">
            <a href="/dashboard"><button type="button" class="save-btn"><img src="/images/invoice-icons/cancel_btn.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/cancel_btn-active.svg" class="form-top-btn-icon">
              <span class="form-top-btn-icon-title">Cancel</span></button></a>
              
            <a href="#"><button type="submit" class="save-btn"><img src="/images/invoice-icons/save-invoice-icon.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/save-invoice-icon-active.svg" class="form-top-btn-icon"><span class="form-top-btn-icon-title">Save</span></button></a> 
        </div>
      </div>
    </div> <!-- end row -->
<div class="row  add-inv-area">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
  <div class="row">    
          <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-4">
            @if($clients->isEmpty())
            <a href="/client"><div class="drop-down btn">
            </div></a>
            @else
            <div class="drop-down">
              <select id="client-div" name="client_id">
                  <option value=""></option>
                  @foreach ($clientDD as $client)     
                 <option class="en icon_img" value="{{ $client['id'] }}, {{ $client['companies_id'] }}" 
                 style="background-image:url('/company_logo/{{$client['logo']}}');background-size:20px">{{ $client['fname']}} {{ $client['lname']}}, {{$client['email']}}</option>
                  @endforeach             
               </select>   
            </div>
            @endif
          </div>

          <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-4 mob-date-div">
            <div class="add-inv-date-title">ISSUE DATE</div>
            <div class="inv-date"><input type="text" name="issue_date" id="datepicker"  class="datePick" width="150" />
              <!-- <input type="text" name="" class="date-input" id="datepicker"><span><i class="fa fa-calendar clender-icon"></i></span>  --></div>
            <div class="add-inv-date-title">DUE DATE</div>
            <div class="inv-date"><input type="text" name="due_date" id="datepicker2" width="150" class="datePick" />
              <!-- <input type="text" name="due_date" class="date-input"><span><i class="fa fa-calendar clender-icon"></i></span> --></div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div id="hiddnbox" style="display: none;">
            <div class="inv-name"><span id="fn"></span>&nbsp;<span id="ln"></span></div>
            <div id="companyName" class="copmany-name"></div>
            <div class="inv-email" id="em"></div>
            
              <div class="col-3 col-sm-2 col-md-4 col-lg-4 col-xl-4">
                <img src="" class="add-inv-logo" id="companyLogo">
                <div id="clientImage" style="display: none;"></div>
             </div>
              <div class="col-9 col-sm-10 col-md-8 col-lg-8 col-xl-8">
                <div class="inv-address" id="ad"></div>
                <div class="inv-city" id="ci"></div>
                <div class="inv-state" id="st"></div>
                <div class="inv-country" id="cu"></div>
              </div>
            </div>
          </div>
          </div>
   
        <div class="row">
          <div class="col-sm-12">
            <hr class="inv-line">
          </div>
        </div>
          <div class="row">
          <div class="col-12 col-sm-6 col-md-5 col-lg-6 col-xl-6 add-inv-heading padding-left-invoice">
            <div class="form-group">
                        <label for="name">Item Description</label>
                        <input name="item_name[]" type="text" class="form-control input-filed input-border" placeholder="Enter-item-Name" required>
                        <textarea  class="form-control input-filed input-border" rows="2" id="comment" name="item_description[]"  placeholder="Enter-item-description" required></textarea>
                      </div>
          </div>
          
          <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 add-inv-heading">
            <div class="form-group">
                      <label for="rate">Rate</label>
                      <input min="0" id="rate0" name="rate[]" type="text" class="form-control input-amt input-border" placeholder="Rate" onkeyup="calc(this, 0)" required>
                    </div>
          </div>
          <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 add-inv-heading">
            <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input min="0" id="qty0" name="qty[]" type="text" class="form-control input-amt input-border" placeholder="Quantity" onkeyup="calc(this, 0)" required>
                      </div>
          </div>
          <div class="col-12 col-sm-2 col-md-3 col-lg-2 col-xl-2 add-inv-heading">
            <p>Line Total</p>
                        <strong>$ <input type="text" readonly name="total[]" onkeyup="calc(this,0)" class="tot input-calculation input-amt"  id="total0" value="0" style="border: 0px solid;"></strong>
          </div>

         </div>
          <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-remove-pad dynamic-added-padding" id="dynamic_field"></div>
          </div>
            
          <div class="row">
            <button type="button" name="add" id="addForm" class="btn add-btn remove-top focus-border"><i class="fa fa-plus-square"></i> Add a Line</button>
          </div>
              
         
          

          
          <div class="row">
          <div class="col-12 col-sm-12 col-md-5 col-lg-6 col-xl-8 row-remove-pad padding-left-invoice">
            <div class="remove-top add-inv-heading" style="margin-top: 50px;">
                  <div class="form-group">
                                           <label for="comment">Notes</label>
                                            <textarea class="form-control input-border invoice-text-area-input" rows="2" id="comment" name="notes"  placeholder="Enter notes or bank transfer details (optional)"></textarea>
                                      </div>
                                       <div class="form-group">
                                           <label for="comment">Terms</label>
                                            <textarea class="form-control input-border invoice-text-area-input" rows="2" id="comment" name="terms"  placeholder="Please write Terms of invoice here. it will go with invoice to client."></textarea>
                                      </div>
                  </div>
          </div>
          <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-4 row-remove-pad">

              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 add-inv-heading remove-top" style="margin-top: 50px;">Payment Method</div>
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount remove-top" style="margin-top: 50px;">
                <select name="payment_mode" class="form-control input-border" style="width: 110px;text-align: center;" required>
                  <option value="STRIPE-PAYMENT" selected>STRIPE</option>
                  <option value="BANKWIRE-PAYMENT">BANK</option>
                  <option value="OFFLINE-PAYMENT">OFFLINE</option>
                </select>
              </div>
            
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 add-inv-heading remove-top" style="margin-top: 10px;">Sub Total</div>
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount remove-top" style="margin-top: 10px;">$ <input type="number" name="sub_total" id="total" onchange="myFunction()"  readonly value="0" class="input-calculation" style="outline: none;"></div>
           

            
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 add-inv-heading"><span>Discount <span class="percentage-text"><input type="text" name="disInPer" id="getValuePerDiscount" class="invoice-dis-value-input" readonly></span></span></div>
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ <input name="discount" id="discount" onchange="myFunction()"  readonly value="0" class="input-calculation" placeholder="0" data-toggle="modal" data-target="#discountModal" style="outline: none;cursor: pointer;"></div>
          

            
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 add-inv-heading"><span>Tax <span class="percentage-text"><input type="text" name="taxInPer" id="getValuePerTax" class="invoice-dis-value-input" readonly></span></span></div>
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ <input name="tax_rate" id="tax_rate" onchange="myFunction()"  readonly value="0" class="input-calculation" data-toggle="modal" data-target="#taxModal" style="outline: none;cursor: pointer;"></div>
            

            
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 add-inv-heading">Deposit Amount</div>
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ <input type="text" name="deposit_amount" id="deposit" placeholder="enter" onkeyup="myFunction()"  class="input-calculation on-focus-border"></div>
         

            <div class="col-sm-12">
            <hr class="inv-line">
            </div>

            
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 add-inv-heading">Amount Paid</div>
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ <input type="number" name="net_amount" id="net_amount"  readonly value="0" onchange="myFunction()" class="input-calculation" style="outline: none;"></div>
           

            
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 add-inv-heading">Net Amount Due</div>
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount on-mob-pad-bottom" style="padding-bottom: 20px;">$ <input type="number" name="due_amount" id="duePending"  readonly value="0" onchange="myFunction()" class="input-calculation" style="outline: none;"></div>
           
          </div>
        </div>
    </div>
  </div>
   <input type="hidden" name="disInFlat" id="getValueFlatDiscount">
   <input type="hidden" name="taxInFlat" id="getValueFlatTax">


  </form>



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
                                <input type="text" name="disValueFlat" placeholder="0" id="disValueFlat" class="dis-model-input" onkeyup="myFunction()" />
                              </div>
                              <div class="radio-btn2">
                                <input type="radio" name="dis_type" id="percentage_radio">
                              </div>

                              <div class="in-label2">
                                Percentage
                              </div>
                              <div class="input-div2">
                                <input type="text" name="disValuePer" placeholder="0" id="disValuePer" class="dis-model-input" onkeyup="myFunction()"  disabled="disabled" />
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
                                <input  type="radio" name="tax_type"  id="tax_flat_radio" checked="checked">
                              </div>

                              <div class="in-label">
                                Flat
                              </div>
                              <div class="input-div">
                                <input type="text" name="taxValueFlat" placeholder="0" id="taxValueFlat" class="dis-model-input" onkeyup="myFunction()" />
                              </div>
                              <div class="radio-btn2">
                                <input  type="radio" name="tax_type" id="tax_per_radio">
                              </div>

                              <div class="in-label2">
                                Percentage
                              </div>
                              <div class="input-div2">
                                <input type="text" name="taxValuePer" placeholder="0" id="taxValuePer" class="dis-model-input" onkeyup="myFunction()" disabled="disabled" />
                              </div>
                            </div>
                            <div class="modal-footer" style="display: flex !important;">
                                   <button type="button" id="refresh" class="btn model-alert-btn" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>



 <script  src="{{ asset('js/invoice.js') }}"></script>
 <script type="text/javascript">


    
 </script>
<script>
  var nowDate = new Date();
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            minDate: today,
            value: nowDate.getMonth()+1+"/"+nowDate.getDate()+"/"+nowDate.getFullYear(),
            format: 'mm/dd/yyyy'
        });
    </script>
 <script>
    var nowDate = new Date(); 
    nowDate.setDate(nowDate.getDate() + 7);
    // var mm = nowDate.getMonth();
    // var y = nowDate.getFullYear();

    // var FormattedDate = dd + '/' + mm + '/' + y;
    
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4',
            minDate: today,
            value: nowDate.getMonth()+1+"/"+nowDate.getDate()+"/"+nowDate.getFullYear(),
            format: 'mm/dd/yyyy'
        });
    </script>
@endsection
