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
    <input type="hidden" name="client_id" value="{{$client->id}}">
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
                          <input type="text" name="issue_date" id="datepicker"  class="form-control datePick" width="150" />
                          <label style="z-index: 2;">ISSUE DATE</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="text" name="due_date" id="datepicker2" width="150" class="form-control datePick" />
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
            <button type="submit" class="btn btn-success btn-lg">Save</button>
            <button type="button" class="btn btn-info btn-lg">Print</button>
            <a href="/dashboard"><button type="button" class="btn btn-danger btn-lg">Cancel</button></a>
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
               <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <textarea  class="form-control" rows="2" id="comment" name="item_description[]"></textarea>
                    <label>Description</label>
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
                      <label style="margin-top: 6px;">Discount<span class="percentage-text" id="show-percentage-val" style="display: none;margin-left: 5px;">(<input type="text" name="disInPer" id="getValuePerDiscount" class="invoice-dis-value-input" readonly style="min-width: 17px;max-width: 22px;border: none;">%)</span></label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="discount" id="discount" onchange="myFunction()"  readonly value="0" class="form-control input-calculation" placeholder="0" data-toggle="modal" data-target="#discountModal" readonly style="background-color: transparent;width: 75%;border: none;padding: 0;">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                       <label style="margin-top: 6px;">Tax<span class="percentage-text" id="show-tax-val" style="display: none;margin-left: 5px;">(<input type="text" name="taxInPer" id="getValuePerTax" class="invoice-dis-value-input" readonly style="min-width: 17px;max-width: 22px;border: none;">%)</span></label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="tax_rate" id="tax_rate" onchange="myFunction()"  readonly value="0" class="form-control input-calculation" data-toggle="modal" data-target="#taxModal" readonly style="background-color: transparent;width: 75%;border: none;padding: 0;">
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


<script>
  var nowDate = new Date();
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            minDate: today,
            value: nowDate.getMonth()+1+"/"+nowDate.getDate()+"/"+nowDate.getFullYear(),
            format: 'mm/dd/yyyy'
        });

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

      //// add multi items
                        $(document).ready(function(){      
                          var postURL = "<?php echo url('Invoice'); ?>";
                          var i=1;  

                          $('#addForm').click(function(){    
                          $('#dynamic_field').append('<div class="row" id="frm'+i+'"><div class="col-md-5"><div class="form-group"><input name="item_name[]" type="text" class="form-control" required><label>Item Name</label></div></div><div class="col-md-2"><div class="form-group"><input min="0" name="rate[]" type="text" class="form-control input-amt" id="rate'+i+'" onkeyup="calc(this,'+i+')" onchange="calc(this,'+i+')" required><label>Rate</label></div></div><div class="col-md-2"><div class="form-group"><input min="0" name="qty[]" type="text" class="form-control input-amt" id="qty'+i+'" onkeyup="calc(this,'+i+')" onchange="calc(this,'+i+')" required><label>Quantity</label></div></div><div class="col-md-2"><div class="form-group"><input type="text" readonly name="total[]" class="tot input-calculation input-amt form-control"  id="total'+i+'" onkeyup="calc(this,'+i+')" onchange="calc(this,'+i+')" value="0" style="background-color: transparent;"><label>Total</label></div></div><div class="col-md-1"><div class="form-group"><span><i class="fa fa-trash btn_remove" style="font-size: 22px; color: red;cursor: pointer;margin-top: 6px;" name="remove" id="'+i+'"></i></span></div></div></div><div class="row"><div class="col-md-5"><div class="form-group"><textarea  class="form-control" rows="2" id="comment" name="item_description[]"></textarea><label>Description</label></div></div></div>');
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
                                $('#show-percentage-val').show();
                              } 
                              if(document.getElementById("tax_flat_radio").checked){
                                tax = +taxValueFlat;
                                document.getElementById('getValueFlatTax').value =  taxValueFlat;
                              }
                               if(document.getElementById("tax_per_radio").checked){
                                  tax = total * taxValuePer / 100;
                                  document.getElementById('getValuePerTax').value =  taxValuePer;
                                  $('#show-tax-val').show();
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
                     
                        
    </script>
@endsection
