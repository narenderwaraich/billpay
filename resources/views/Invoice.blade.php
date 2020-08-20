@extends('layouts.app')
@section('content')
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
<div class="content">
  <form action="/invoice" method="post" autocomplete="">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-lg-8">
        <div class="card card-user">
            <div class="image">
                <img src="/images/bg.jpg" alt="">
            </div>
          <div class="card-body">
              <div class="author">
                <a href="#">
                  <img class="avatar border-gray" src="/images/icon/user.jpg" alt="Client">
                  <h5 class="title"><span id="first_name">{{$client->fname}}</span> <span id="last_name">{{$client->lname}}</span></h5>
                </a>
                <hr>
                <div class="client-data" id="client_email">Email : <span id="client_email_data">{{$client->email}}</span></div>
                <div class="client-data" id="client_phone">Phone : <span id="client_phone_data">{{$client->phone}}</span></div>
                <div class="client-data" id="client_country">Country : <span id="client_country_data">{{$client->country}}</span></div>
                <div class="client-data" id="client_state">State : <span id="client_state_data">{{$client->state}}</span></div>
                <div class="client-data" id="client_city">City : <span id="client_city_data">{{$client->city}}</span></div>
                <div class="client-data" id="client_zip">ZipCode : <span id="client_zip_data">{{$client->zipcode}}</span></div>
                <div class="client-data" id="client_address">Address : <span id="client_address_data">{{$client->address}}</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Invoice Date</h5>
            <hr>
          </div>
          <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="text" name="issue_date" id="datepicker"  class="form-control datePick" width="150" />
                    <label>ISSUE DATE</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="text" name="due_date" id="datepicker2" width="150" class="form-control datePick" />
                    <label>DUE DATE</label>
                  </div>
                </div>
              </div>
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
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <input name="item_name[]" type="text" class="form-control" required>
                    <label>Item Name</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input min="0" id="rate0" name="rate[]" type="text" class="form-control input-amt" onkeyup="calc(this, 0)" required>
                    <label>Rate</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input min="0" id="qty0" name="qty[]" type="text" class="form-control input-amt" onkeyup="calc(this, 0)" required>
                    <label>Quantity</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" readonly name="total[]" onkeyup="calc(this,0)" class="tot input-calculation input-amt form-control"  id="total0" value="0" style="background-color: transparent;">
                    <label>Total</label>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <!-- <label>Remove</label> -->
                  </div>
                </div>
              </div>

              <div class="dynamic-added-padding" id="dynamic_field"></div>

              <div class="row">
                <div class="col-md-12">
                  <button type="button" name="add" id="addForm" class="btn add-btn remove-top focus-border"><i class="fa fa-plus-square"></i> Add New Item</button>
                </div>
              </div>

              <div class="row">
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <textarea class="form-control" rows="8" name="notes" style="width: 50%;"></textarea>
                          <label>Notes (optional)</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                     <div class="form-group">
                          <textarea class="form-control" rows="8" name="terms" style="width: 50%;"></textarea>
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
                      <select name="payment_mode" class="form-control" style="border: none;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;border-bottom: 1px solid #dadce0;padding: 0;height: unset;width: 75%;" required>
                        <option value="Cash" selected>Cash</option>
                        <option value="Online">Online</option>
                      </select>
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
                       <input type="number" name="sub_total" id="total" onchange="myFunction()"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="0" class="input-calculation form-control">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                      <label style="margin-top: 6px;">Discount</label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="disInPer" id="getValuePerDiscount" value="0" class="form-control invoice-dis-value-input" readonly style="background-color: transparent;width: 75%;border: none;padding: 0;">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                       <label style="margin-top: 6px;">Tax</label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="taxInPer" id="getValuePerTax" value="0" class="form-control invoice-dis-value-input" readonly style="background-color: transparent;width: 75%;border: none;padding: 0;">
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
                      <input type="text" name="deposit_amount" id="deposit" onkeyup="myFunction()" style="border: none;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;border-bottom: 1px solid #dadce0;padding: 0;width: 75%;"  class="input-calculation form-control">
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
                      <input type="number" name="net_amount" id="net_amount"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="0" onchange="myFunction()" class="input-calculation form-control">
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
                      <input type="number" name="due_amount" id="duePending"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="0" onchange="myFunction()" class="input-calculation form-control">
                     </div>
                   </div>
                 </div>



                </div>
              </div>


          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="disInFlat" id="getValueFlatDiscount">
    <input type="hidden" name="taxInFlat" id="getValueFlatTax">
  </form>
</div>

<!-- <div class="row  add-inv-area">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
  <div class="row">    


          <div class="col-12 col-sm-5 col-md-3 col-lg-3 col-xl-3 mob-date-div">
            <div class="add-inv-date-title">ISSUE DATE</div>
            <div class="inv-date"><input type="text" name="issue_date" id="datepicker"  class="datePick" width="150" /> -->
              <!-- <input type="text" name="" class="date-input" id="datepicker"><span><i class="fa fa-calendar clender-icon"></i></span>  -->
            <!-- </div>
            <div class="add-inv-date-title">DUE DATE</div>
            <div class="inv-date"><input type="text" name="due_date" id="datepicker2" width="150" class="datePick" /> -->
              <!-- <input type="text" name="due_date" class="date-input"><span><i class="fa fa-calendar clender-icon"></i></span> -->
           <!--  </div>
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


 -->
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



<style>
  .client-data{
    display: block;
  }
</style>
<script src="{{ asset('jquery/jquery-3.2.1.min.js') }}"></script>
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
    <script>
      //// add multi items
                        $(document).ready(function(){      
                          var postURL = "<?php echo url('Invoice'); ?>";
                          var i=1;  

                          $('#addForm').click(function(){    
                          $('#dynamic_field').append('<div class="row" id="frm'+i+'"><div class="col-md-5"><div class="form-group"><input name="item_name[]" type="text" class="form-control" required><label>Item Name</label></div></div><div class="col-md-2"><div class="form-group"><input min="0" name="rate[]" type="text" class="form-control input-amt" id="rate'+i+'" onkeyup="calc(this,'+i+')" onchange="calc(this,'+i+')" required><label>Rate</label></div></div><div class="col-md-2"><div class="form-group"><input min="0" name="qty[]" type="text" class="form-control input-amt" id="qty'+i+'" onkeyup="calc(this,'+i+')" onchange="calc(this,'+i+')" required><label>Quantity</label></div></div><div class="col-md-2"><div class="form-group"><input type="text" readonly name="total[]" class="tot input-calculation input-amt form-control"  id="total'+i+'" onkeyup="calc(this,'+i+')" onchange="calc(this,'+i+')" value="0" style="background-color: transparent;"><label>Total</label></div></div><div class="col-md-1"><div class="form-group"><span><i class="fa fa-trash btn_remove" style="font-size: 22px; color: red;cursor: pointer;margin-top: 6px;" name="remove" id="'+i+'"></i></span></div></div></div>');
                               i++;
                          });  

                          $(document).on('click', '.btn_remove', function(){  
                               var button_id = $(this).attr("id");   
                               $('#frm'+button_id+'').remove();
                               myFunction();  
                          });  
                        });  


                        // discount modal radio button enable or disable

                          $('#percentage_radio').on('click', function(e) {
                               if($(this).is(':checked',true))  
                               {
                                $("#disValuePer").prop('disabled', false);
                                $("#disValueFlat").prop('disabled', true);
                                $("#disValueFlat").attr('value', '');
                                document.getElementById('getValueFlatDiscount').value =  '';
                                document.getElementById("disValueFlat").value = '';
                               }else{
                                $("#disValueFlat").prop('disabled', false);
                                $("#disValuePer").prop('disabled', true);
                                $("#disValuePer").attr('value', '');

                               }
                          });
                          $('#flat_radio').on('click', function(e) {
                               if($(this).is(':checked',true))  
                               {
                                $("#disValuePer").prop('disabled', true);
                                $("#disValueFlat").prop('disabled', false);
                                document.getElementById('getValuePerDiscount').value =  '';
                                document.getElementById("disValuePer").value = '';
                               }else{
                                $("#disValueFlat").prop('disabled', true);
                                $("#disValuePer").prop('disabled', false);
                               }
                          });


                          // tax modal radio button enable or disable

                          $('#tax_per_radio').on('click', function(e) {
                               if($(this).is(':checked',true))  
                               {
                                $("#taxValuePer").prop('disabled', false);
                                $("#taxValueFlat").prop('disabled', true);
                                document.getElementById('getValueFlatTax').value =  '';
                                document.getElementById("taxValueFlat").value = '';
                               }else{
                                $("#taxValueFlat").prop('disabled', false);
                                $("#taxValuePer").prop('disabled', true);
                               }
                          });
                          $('#tax_flat_radio').on('click', function(e) {
                               if($(this).is(':checked',true))  
                               {
                                $("#taxValuePer").prop('disabled', true);
                                $("#taxValueFlat").prop('disabled', false);
                                document.getElementById('getValuePerTax').value =  '';
                                document.getElementById("taxValuePer").value = '';
                               }else{
                                $("#taxValueFlat").prop('disabled', true);
                                $("#taxValuePer").prop('disabled', false);
                               }
                          });



                          //// Calculation form
                           var rate = 0;
                            var qty = 0;
                            var lineTotal = 0;
                            function calc(obj, i) {
                                var e = obj.id.toString();
                                e = e.slice(0, -1);

                                if (e == 'rate') {
                                    rate = Number(obj.value);
                                    qty = Number(document.getElementById('qty'+i).value);
                                } else {
                                    rate = Number(document.getElementById('rate'+i).value);
                                    qty = Number(obj.value);
                                }
                                lineTotal = rate * qty;
                                var netTotal = lineTotal.toFixed(2);
                                document.getElementById('total'+i).value = netTotal;
                                 
                                myFunction();   
                            }

                      //// Discount nd tax

                          //var dis = 0;
                          var total = 0;
                          var net = 0;
                          var val = 0;
                          //var due = 0;
                          //var pending = 0;
                          var discount = 0;
                          //var vat = 0;
                          var tax = 0;
                          var disValuePer = 0;
                          var taxValuePer = 0;
                        var disValueFlat = 0;
                        var taxValueFlat = 0;
                        var netDiscount =0;
                        var netTax = 0;
                        var nowAmount = 0;
                   
                    function myFunction() {
                        var itemTotals = $(".tot");
                                var subTotal = 0;
                                for(var i= 0; i < itemTotals.length; i++){
                                  subTotal += Number(itemTotals[i].value);
                                }
                                var nowTotal = subTotal.toFixed(2);
                                $("#total").val(nowTotal); 
                              //discount
                              var disValuePer = document.getElementById("disValuePer").value;
                              var disValueFlat = document.getElementById("disValueFlat").value;     
                              //tax
                              var taxValuePer = document.getElementById("taxValuePer").value;
                              var taxValueFlat = document.getElementById("taxValueFlat").value;

                              //var due = document.getElementById("deposit").value; //deposit value

                              var total = document.getElementById("total").value;
                              var val = document.getElementById("net_amount").value;
                              if(document.getElementById("flat_radio").checked){
                                discount = +disValueFlat;
                                document.getElementById('getValueFlatDiscount').value =  disValueFlat;
                              }
                              if(document.getElementById("percentage_radio").checked){
                                discount = total * disValuePer / 100;
                                document.getElementById('getValuePerDiscount').value =  disValuePer;
                              } 
                              if(document.getElementById("tax_flat_radio").checked){
                                tax = +taxValueFlat;
                                document.getElementById('getValueFlatTax').value =  taxValueFlat;
                              }
                               if(document.getElementById("tax_per_radio").checked){
                                  tax = total * taxValuePer / 100;
                                  document.getElementById('getValuePerTax').value =  taxValuePer;
                                }
                                // console.log(discount);
                                //console.log("Discount :"+discount+" - Tax :"+tax);
                                 net = total - discount + tax; /// Total = subtotal - discount + tax - due
                                 netDiscount = discount.toFixed(2);
                                 netTax = tax.toFixed(2);
                                 nowAmount = net.toFixed(2);
                                document.getElementById('discount').value = netDiscount; //total discount
                                document.getElementById('tax_rate').value = netTax; // total tax 
                                document.getElementById('net_amount').value = nowAmount; /// subtotal - discount + tax = Total
                              /// total - deposit
                              // var due = document.getElementById("deposit").value; //deposit value
                              // pending = nowAmount - due;
                               document.getElementById('duePending').value = nowAmount;

                          }


                                    // $(document).ready(function(){
                                    //   // we call the function
                                    //   myFunction();
                                    //   calc();
                                    // });
                                  
                      ///add Company nd client by ajax
                     
                      jQuery().ready(function() {  
                    /* Custom select design */    
                    jQuery('.drop-down').append('<div class="client_btn"></div>');    
                    jQuery('.drop-down').append('<ul class="select-list"></ul>');   

                    jQuery('.drop-down select option').each(function() {  
                      var bg = jQuery(this).css('background-image');
                      var optionText = jQuery(this).text();
                      var options = optionText.split(",");
                      optionText = options.join("<br/>");
                      if(optionText !='')
                        jQuery('.select-list').append('<li class="clsAnchor"><span value="' + jQuery(this).val() + '" class="' + jQuery(this).attr('class') + '" style=background-image:' + bg + '>' + optionText + '</span></li>');   
                    });

                    jQuery('.drop-down .client_btn').html('<a href="javascript:void(0);" class="select-list-link btnCss" style="margin-right:10px; color: grey;"><i class="fa fa-plus-square"></i> ADD <br> CLIENT</a>');   

                    jQuery('.drop-down ul li').each(function() {   
                      if (jQuery(this).find('span').text() == jQuery('.drop-down select').find(':selected').text()) {  
                      jQuery(this).addClass('active');       
                      }      
                    });      

                    // change select on click
                    jQuery('.drop-down .select-list span').on('click', function(){          
                      var dd_text = jQuery(this).text();    
                      var dd_val = jQuery(this).attr('value');   
                      jQuery('.drop-down .client_btn').html('<a href="javascript:void(0);" class="select-list-link" style="margin-right:10px; color: grey;"><i class="fa fa-plus-square"></i> CHANGE <br> CLIENT</a>');      
                      jQuery('.drop-down .select-list span').parent().removeClass('active');    
                      jQuery(this).parent().addClass('active');     
                      
                      $('.drop-down select[name=client_id]').val( dd_val );
                      
                       getClientInfo(dd_val); // get client detail
                       //getCompanyInfo(dd_val); // get Company detail
                      
                      $('.drop-down .select-list li').slideUp();     
                    });

                    jQuery('.drop-down .client_btn').on('click','a.select-list-link', function(){      
                      jQuery('.drop-down ul li').slideToggle();  
                    });     
                    /* End */       
                    });


                     
                      /// select client  show ditails
                     
                         function getClientInfo(value){ // or $(this).val()

                          var client_id = value.split(",")[0];
                          if(client_id) {

                            $.ajax({
                              type: 'GET',
                              url: '/getClient?client_id='+client_id,
                              dataType: 'json',
                              success: function(data){
                                console.log(data);
                                $("#hiddnbox #fn").text(data.fname);
                                $("#hiddnbox #ln").text(data.lname);

                                $("#hiddnbox #em").text(data.email);
                                $("#hiddnbox #ad").text(data.address);
                                $("#hiddnbox #ci").text(data.city);
                                $("#hiddnbox #st").text(data.state);
                                $("#hiddnbox #cu").text(data.country);
                                $("#hiddnbox #companyName").text(data.name);
                                $("#hiddnbox #companyLogo").attr('src','/company_logo/'+data.logo);
                                if(!data.logo){
                                  $('#companyLogo').hide();
                                  $('#clientImage').show();
                                   var dot = '.';
                                   var intials = data.fname.charAt(0) + dot + data.lname.charAt(0);
                                   var profileImage = $('#clientImage').text(intials);
                                }else{
                                  $('#companyLogo').show();
                                  $('#clientImage').hide();
                                }
                                
                                // $("#email").val(data.email);
                                 
                                $('#hiddnbox').show();
                              }
                            });
                          } else {
                           $('#hiddnbox').hide();
                          }
                          }
                     

                     /// select  company show ditails
                     
                         // function getCompanyInfo(value){ // or $(this).val()

                         //  var company_id = value.split(",")[1];
                         //  if(company_id) {

                         //    $.ajax({
                         //      type: 'GET',
                         //      url: '/getCompany?company_id='+company_id,
                         //      dataType: 'json',
                         //      success: function(data){
                         //        //console.log(data);
                         //        $("#hiddnbox #companyName").text(data.name);
                         //        $("#hiddnbox #companyLogo").attr('src','/company_logo/'+data.logo);
                                
                                
                         //        // $("#email").val(data.email);
                                 
                         //        $('#hiddnbox').show();
                         //      }
                         //    });
                         //  } else {
                         //   $('#hiddnbox').hide();
                         //  }
                         //  }
                        
                                     //// Show slied discount

                                        $('.slideButton').on('click',function() {
                                        $('#showmenu').toggle(
                                            function() {
                                                $('.menu').slideDown("fast");
                                            }
                                        );
                                    });
                                   

                                        //// Show slied tax
                        
                                        $('.slideButton2').on('click',function() {
                                        $('#showmenu2').toggle(
                                            function() {
                                                $('.menu2').slideDown("fast");
                                            }
                                        );
                                    });
                        

                                      ////Send data & mail
                                              $("#MailData").submit(function(){
                                                if($("select[name='client_id']").val() == ''){
                                                  alert("Please select client!");
                                                  return false;
                                                }
                                                return true;
                                              });
                                        
                                            // $("#saveForm").click(function(){
                                      
                                            //   $("#MailData").submit();
                                            //   $('#loading').show();
                                            // });


                    function addOrRemoveEmail(action){
                      if(action=='add')
                        $("#email").val($("#hiddnbox #em").text());
                      else
                        $("#email").val();
                    }

                  /// delete items in edit in voices 

                  $(document).ready(function () {
                    $('.delete-Item').on('click', function(e) {
                        var invoiceItemId = $(this).attr("DeleteId"); 

                      $.ajax({
                        url: '/deleteItem/'+invoiceItemId,
                        type: 'DELETE',
                        dataType: 'json',
                        method : 'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'id='+invoiceItemId,
                        success: function (data) {
                            if (data['success']) {
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                        });
                    });
                  });
    </script>
@endsection
