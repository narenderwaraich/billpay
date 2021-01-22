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
            <div class="card">
              <div class="card-header">
                <h5 class="title">Invoice Payment</h5>
              </div>
              <div class="card-body">
                <form name="calculator">
                <input type="text" name="answer" id="answer" />
                <div class="calculator-btn-section">
                <br>
                <input type="button" value=" 1 " onclick="calculator.answer.value += '1'" />
                <input type="button" value=" 2 " onclick="calculator.answer.value += '2'" />
                <input type="button" value=" 3 " onclick="calculator.answer.value += '3'" />
                <br/>
                
                <input type="button" value=" 4 " onclick="calculator.answer.value += '4'" />
                <input type="button" value=" 5 " onclick="calculator.answer.value += '5'" />
                <input type="button" value=" 6 " onclick="calculator.answer.value += '6'" />
                </br>
              
                <input type="button" value=" 7 " onclick="calculator.answer.value += '7'" />
                <input type="button" value=" 8 " onclick="calculator.answer.value += '8'" />
                <input type="button" value=" 9 " onclick="calculator.answer.value += '9'" />
                </br>
                <input type="button" value="Clear" id="clear" onclick="calculator.answer.value = ''" />
                <input type="button" value=" 0 " onclick="calculator.answer.value += '0'" />
                <input type="button" value="Result" id="result" />
                
                </br></br></br>
                </div>
                </form>
              </div>
            </div>
          </div>
          <!-- end col -->
          <div class="col-lg-4">
            <div class="card card-user">
              <div class="card-body">
                <div class="w-100">
                  <div class="select-pay-type">
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" id="deposit_amt" name="inv_ampunt">Deposit Pay
                    </label>
                  </div>
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" id="full_amt" name="inv_ampunt">Full Pay
                    </label>
                  </div>
                </div>
                  <div class="w-55">
                    <div class="cash-show-title">Invoice Amount</div>
                    <div class="cash-show-title">Cash Take</div>
                    <div class="cash-show-title" style="color: #e91e63;">Cash Return</div>
                  </div>
                  <div class="w-45">
                    <div class="cash-show-title">: <span id="invoice_amount">0</span></div>
                    <div class="cash-show-title">: <span id="answer_show_value">0</span></div>
                    <div class="cash-show-title" style="color: #e91e63;">: <span id="return_cash">0</span></div>
                  </div>
                </div>    
              </div>
              <hr>
              <div class="invoice-pay-action-btn">
                <div class="btn-group btn-group-lg" role="group" aria-label="invoice action button">
                  <button type="button" class="btn btn-danger cancel-invoice">Cancel</button>
                  <button type="button" class="btn btn-success pay-btn" disabled>Pay Now</button>
                  <button type="button" class="btn btn-dark invoice-pay-later">Pay Later</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
      </div>
      <!-- end content section --> 

<style type="text/css">
            
#calc-contain{
  position: relative;
  width: 400px;
  border: 2px solid black;
  border-radius: 12px;
  margin: 0px auto;
  padding: 20px 20px 100px 20px;
}
#agh{
  position: relative;
  float: right;
  margin-top: 15px;
}
#agh p{
  font-size: 20px;
  font-weight: 900;
}
input[type=button] {
  background: lightGray;
  width: 30%;
  height: 50px;
  font-size: 20px;
  font-weight: 900;
  border-radius: 7px;
  margin-left: 13px;
  margin-top: 10px;
}
input[type=button]:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
input[type=button]:hover {
  background-color: #e91e63;
  color: white;
}

input[type = text] {
  position: relative;
  display: block;
  width: 80%;
  margin: 5px auto;
  font-size: 20px;
  padding: 10px;
  box-shadow: 4px 0px 12px black inset;
}
.calculator-btn-section {
    width: 80%;
    height: auto;
    margin: auto;
}
.card-user .card-body {
    min-height: 160px;
}
.w-100{
  width: 100%;
  height: auto;
  display: block;
  margin-top: 10px;
}
.w-55{
  width: 55%;
  height: auto;
  display: block;
  float: left;
}
.w-45{
  width: 45%;
  height: auto;
  display: block;
  float: right;
}
.invoice-pay-action-btn {
    margin: 25px auto;
    text-align: center;
}
.cash-show-title {
    font-size: 22px;
    font-weight: 600;
    margin-left: 15px;
}
</style>
<script>
  $(document).ready(function(){
    var invoiceAmount = 0;
    var invoiceDepositAmount = "<?php echo $invoice->deposit_amount; ?>";
    var invoiceNetAmount = "<?php echo $invoice->net_amount; ?>";
    var invoiceDueAmount = "<?php echo $invoice->due_amount; ?>";
    if(invoiceDepositAmount > 0 && invoiceNetAmount == invoiceDueAmount){
      $("#deposit_amt").prop('checked', true);
      $("#deposit_amt").attr('disabled', false);
      invoiceAmount = invoiceDepositAmount;
    }else{
      $("#deposit_amt").prop('checked', false);
      $("#deposit_amt").attr('disabled', true);
    }

    if(invoiceNetAmount != invoiceDueAmount){
      $("#full_amt").prop('checked', true);
      $("#full_amt").attr('disabled', true);
      invoiceAmount = invoiceDueAmount;
    }

    
    $('#invoice_amount').text(invoiceAmount);
    $('#deposit_amt').on('click', function(){
      if($("#deposit_amt").prop('checked')){
         invoiceAmount = invoiceDepositAmount;
         $('#invoice_amount').text(invoiceAmount);
         calculation();
      }
    });
    $('#full_amt').on('click', function(){
      if($("#full_amt").prop("checked")){
           invoiceAmount = invoiceNetAmount;
           $('#invoice_amount').text(invoiceAmount);
           calculation();
      }
    });
    $('#result').on('click', function(){
      calculation();
   });

    function calculation(){
        var answer = $('#answer').val();
        var retunCash = 0.00;
        if($('#answer').val()!=""){
          retunCash = answer - invoiceAmount;
          $('#return_cash').text(Math.round(retunCash));
          $('#answer_show_value').text(answer);
          if(retunCash >= 0){
            $('.pay-btn').prop('disabled', false);
          }else{
            $('.pay-btn').prop('disabled', true);
          }
        }
    }

    $('#clear').on('click', function(){
      $('#return_cash').text(0);
      $('#answer_show_value').text(0);
      $('.pay-btn').prop('disabled', true);
   });

    $('.pay-btn').on('click', function(){
      var Id = "{{$invoice->id}}";
    if($("#deposit_amt").prop('checked')){
        window.location.href = '/invoice/cash/deposit/payment/'+Id;
      }else{
        window.location.href = '/invoice/cash/full/payment/'+Id;
      }
    });


   $('.cancel-invoice').on('click', function(){
      var Id = "{{$invoice->id}}";
      window.location.href = '/cancel-invoice-bill/'+Id;
   });

   $('.invoice-pay-later').on('click', function(){
      var Id = "{{$invoice->id}}";
      window.location.href = '/invoice/view/'+Id;
   });


  });
</script>                            
@endsection