@extends('layouts.app')
@section('content')

               <div class="add-plan-box">
            <div class="plan-box-title">
          
              <div class="plan-card-title">Choose Invoice Plan </div>
        </div>
        <form action="/choose-plan" method="post">
                  {{ csrf_field() }}
       
        <div class="plan-input-lable">
          Select Plans
        </div>
        <select name="plan" id="select" class="form-control cc-number plan-sel-input" required>
              <option value=""> -- Select Plan -- </option>
              @foreach ($plans as $plan)
              <option value="{{$plan->id}},{{$plan->name}},{{$plan->interval}},{{$plan->amount}},{{$plan->nickname}}">{{$plan->name}}</option>
              @endforeach
        </select>
        <div class="plan-input-lable">
          Card Number
        </div>
        <input id="cc-number" name="card_number" type="tel" maxlength="19" onkeyup="ccNumber()" class="form-control cc-number card-number-input" placeholder="Card Number" required>

        <div class="plan-input-lable2">
          Expiration Date
        </div>
        <div class="col-6 p-l-25">
          <select name="month" class="form-control plan-card-select-month">
                <option value="01">January</option>
                <option value="02">February </option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
        <div class="col-6 p-r-25">
          <select name="year" class="form-control plan-card-select-year">
              <option value="20"> 2020</option>
              <option value="21"> 2021</option>
              <option value="22"> 2022</option>
              <option value="23"> 2023</option>
              <option value="24"> 2024</option>
              <option value="25"> 2025</option>
              <option value="26"> 2026</option>
              <option value="27"> 2027</option>
              <option value="28"> 2028</option>
              <option value="29"> 2029</option>
              <option value="30"> 2030</option>
              <option value="31"> 2031</option>
              <option value="32"> 2032</option>
          </select>
        </div>
        <br>
        <div class="plan-input-lable3">
          CVV CODE
        </div>
        <input id="cc-number" name="cvv" type="password" maxlength="4"  class="form-control cc-number card-number-input" placeholder="CVV" required>

        <br>
       
             <!--  <input type="checkbox" name="save" class="card-chk-box"> <span class="card-save-txt">Save my Card for Future</span> -->
          
        <center>
             <button id="payment-button" type="submit" class="btn form-btn btn-lg btn-block" style="width: 50%;margin-top: 10px">
                  <span id="payment-button-amount"><span class="select-plan-amount" style="display: none;">$<span id="show_plan_amount"></span></span> Pay</span>
                  <span id="payment-button-sending" style="display:none;">Processing…</span>
              </button>
         </center>
       </form>
      </div>

       <script>
          function ccNumber() {
          // var account = document.getElementById('cc-number');
          // var changed = document.getElementById('cc_changed');

              // changed.value = new Array(account.value.length-3).join('X') + account.value.substr(account.value.length-4, 4);

              $('#cc-number').on('keyup', function(e){
                  var val = $(this).val();
                  var newval = '';
                  val = val.replace(/\s/g, '');
                  for(var i=0; i < val.length; i++) {
                      if(i%4 == 0 && i > 0) newval = newval.concat(' ');
                      newval = newval.concat(val[i]);
                  }
                  $(this).val(newval);
              });
            }
         /// on select plan show plan amount
         $(document).ready(function(){
           $('#select').on('change', function() {
              var amount = $(this).val().split(',')[3];
              if(amount){
                var plan_amount = amount / 100; //console.log(plan_amount);
                $('.select-plan-amount').show();
                $('#show_plan_amount').text(plan_amount);
              }else{
                $('.select-plan-amount').hide();
              }
           });

           ///on submit form 
          $('.form-btn').on('click', function() {
                $('#payment-button-amount').hide();
                $('#payment-button-sending').show();
           });  
         });
        </script>

       @endsection