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
                  <div class="w-55">
                    <div class="cash-show-title">Invoice Amount</div>
                    <div class="cash-show-title">Cash Take</div>
                    <div class="cash-show-title" style="color: #e91e63;">Cash Return</div>
                  </div>
                  <div class="w-45">
                    <div class="cash-show-title">: <span>{{$invoice->net_amount}}</span></div>
                    <div class="cash-show-title">: <span id="answer_show_value">0</span></div>
                    <div class="cash-show-title" style="color: #e91e63;">: <span id="return_cash">0</span></div>
                  </div>
                </div>    
              </div>
              <hr>
                <a href="/invoice/cash/payment/status/{{$invoice->id}}"><button type="button" class="btn btn-success pay-btn" disabled>Pay</button></a>
              <div class="button-container">

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
  margin-top: 20px;
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
.pay-btn{
    margin: auto;
    display: block;
    margin-top: 20px;
    width: 120px;
    font-weight: 800;
    font-size: 24px;
    margin-bottom: 20px;
}
.cash-show-title {
    font-size: 22px;
    font-weight: 600;
    margin-left: 15px;
}
</style>
<script>
  $(document).ready(function(){
    $('#result').on('click', function(){
    var answer = $('#answer').val();
    var retunCash = 0.00;
    var invoiceAmount = "<?php echo $invoice->net_amount; ?>";
    if($('#answer').val()!=""){
      retunCash = answer - invoiceAmount;
      $('#return_cash').text(retunCash);
      $('#answer_show_value').text(answer);
      if(retunCash >= 0){
        $('.pay-btn').prop('disabled', false);
      }else{
        $('.pay-btn').prop('disabled', true);
      }
    }
   });

    $('#clear').on('click', function(){
      $('#return_cash').text(0);
      $('#answer_show_value').text(0);
      $('.pay-btn').prop('disabled', true);
   });
  });
</script>                            
@endsection