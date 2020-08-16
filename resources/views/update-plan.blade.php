@extends('layouts.app')
@section('content')



  <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
    <div class="bank-trns-box">
      <div class="bank-trns-box-title">
        <span class="bank-trns-main-title-text">Bank Transactions</span> 
      </div>
      <div class="table-responsive">
          <table class="table table-striped">
              <thead>
                  <tr>
                    <th scope="col" style="padding-left: 10px;">No.</th>
                    <th scope="col">Plan</th>
                    <th scope="col">Card</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Payment Date</th>
                    <th scope="col">Status</th>
                  </tr>
              </thead>
            <tbody>
              @foreach ($tranfer as $number => $transaction)
              <tr>
                <th scope="row" style="padding-left: 10px;">{{1+$number++}}</th>
                <td>{{$transaction->plan}}</td>
                <td>{{$transaction->card_number}}</td>
                <td>$ {{$transaction->amount}}</td>
                <td>{{date('m/d/Y h:i:s', strtotime($transaction->payment_date))}}</td>
                <td class="pay-status_{{$transaction->status}}">{{$transaction->status}}</td>
              </tr>
            </tbody>
            @endforeach
          </table>
          {{ $tranfer->links() }}
        </div>
    </div>
  </div>

  <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
    <div class="plan-or-card-box">
      <div class="user-plan-box">
        <div class="title-text">
          Your Plan
        </div>

            <div class="row">
                <div class="col-md-12 plan-name-text">
                    Active Plan
                    @if(isset($userPlan))
                        <span>
                              @if($userPlan->status == 0)
                              You have no active plan
                              @else
                              {{$userPlan->plan}}
                              @endif
                        </span> 
                    @endif
                </div>
            </div>

        @if(isset($userPlan))
        <div class="btn-div">
          @if($userPlan->status == 0)
          <button  type="button" class="btn btn-css change-plan"  data-toggle="modal" data-target="#planModal">
             Add Plan
          </button>
          @else
          <button  type="button" class="btn btn-css change-plan"  data-toggle="modal" data-target="#planModal">
             Change Plan
          </button>
          <button type="button" class="btn btn-danger cancel-sub" data-toggle="modal" data-target="#cancelSubModal">
            Cancel Subscription
          </button>
          @endif
        </div>
        @endif
      </div>
      <div class="card-box">
        <div class="title-text">
          Your Cards
        </div>
        @if(isset($card))
            <div class="row" style="margin-top: 15px;">
              <div class="col-md-12 card-data">
                <div class="card-data-text">
                  Card - 
                  <span>
                    XXXX-XXXX-XXXX-{{$card->card_number}}
                    @if(isset($userPlan))
          @if($userPlan->status == 0)<i class="fa fa-trash fa-lg delete-card" DeleteId="{{$card->customer_id}}" style="font-size: 20px; color: red;cursor: pointer; margin-left: 5px;"></i>@endif
                    @endif
                  </span> 
                </div>
              </div>
            </div>
        @else
          <p class="no-card-record">!Empty</p>
        @endif
        @if(isset($card))                                                           
        <button  type="button" class="btn btn-css" data-toggle="modal" data-target="#changeCardModal" >
               Change Card
        </button>
        @else
        <button  type="button" class="btn btn-css" data-toggle="modal" data-target="#addCardModal" >
               Add Card
        </button>
        @endif
      </div>
    </div>
  </div>


          

                                  <!--- Change Plan Model -->
    <div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title-text">
              Add New Plan
            </div>
          </div>
              <div class="modal-body">
                  <form action="/update-plan" method="post" id="PlanData">
                    {{ csrf_field() }}


                  <div class="row">
                      <div class="col-12 form-group">
                        <label for="select_plan" class="form-control-label">Plans</label>
                        <select name="plan" id="select_plan" class="form-control" required>
                          <option value=""> -- Select Plan -- </option>
                          @foreach ($plans as $plan)
                          <option value="{{$plan->id}},{{$plan->name}},{{$plan->interval}},{{$plan->amount}},{{$plan->nickname}}">{{$plan->name}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>

                <div class="row">
                    <div class="col-12 form-group">
                    <label for="cc-number" class="form-control-label">Card</label>
                    <select name="customer_id" id="select" class="form-control" required>
                      @if(isset($card))
                      <option value="{{$card->customer_id}}">XXXX-XXXX-XXXX-{{$card->card_number}}</option>
                      @else
                      <option value=""> -- Empty Card -- </option>
                      @endif
                    </select>
                  </div>
                </div>
            </div> <!-- model body -->
      <div class="modal-footer">
          <button type="submit" id="send-mail-btn" class="btn modal-btn">
              <span id="send-btn"><span class="select-plan-amount" style="display: none;">$<span id="show_plan_amount"></span></span> Pay</span>
                <span id="mail-button-sending2" style="display:none;"><i class="fa fa-spin fa-refresh"></i> Wait…</span>
          </button>

          <button type="button" class="close" data-dismiss="modal">&times;</button> 

            </div> <!-- model footer -->
          </form>
        </div>
    </div>
</div>

                  <!-- end model -->



                  
                  
                 
                  <!--- Add Card Model -->
                  <div class="modal fade" id="addCardModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <div class="modal-title-text">
                            Add Card
                          </div>
                        </div>
                        <div class="modal-body">
                          <form action="/new-card" method="post" id="addCardData">
                            {{ csrf_field() }}

                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                                <label>Card number</label>
                              <div class="row">
                                <div class="col-12">
                                <input id="add-cc-number" name="card_number" type="tel" maxlength="19" onkeyup="addCardNumber()" class="form-control cc-number identified visa" placeholder="Enter Card Number (1111 2222 3333 4444)" value="" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number" autocomplete="cc-number">
                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                               </div>
                              </div>
                            </div>
                          </div>
                        </div>

                            <!-- <input type="hidden" name="card_number" id="cc_changed"> -->
                            <div class="row">
                              <div class="col-12">
                                <div class="form-group" id="expiration-date">
                                  <label>Expiration Date</label>
                                  <div class="row">
                                    <div class="col-7">
                                      <select name="month" class="form-control">
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
                                    <div class="col-5">
                                      <select name="year" class="form-control">
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
                                  </div>
                                </div>

                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12">
                                <label for="x_card_code" class="control-label mb-1">CVV code</label>
                                <div class="input-group">
                                  <input id="x_card_code" name="cvv" type="password" maxlength="4" placeholder="Enter-CVV (123)" class="form-control cc-cvc" value="" data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" autocomplete="off">

                                </div>
                              </div>
                            </div>
                            <div>

                            </div>

                          </div>
                          <div class="modal-footer">

                            <button type="submit" id="add-send-mail-btn" class="btn modal-btn">
                              <span id="add-send-btn">Submit</span>
                              <span id="add-mail-button-sending" style="display:none;"><i class="fa fa-spin fa-refresh"></i> Wait…</span>
                            </button>

                            <button type="button" class="close" data-dismiss="modal">&times;</button> 

                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- end model -->


                  <!--- Change Card Model -->
                  <div class="modal fade" id="changeCardModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <div class="modal-title-text">
                            Change Card
                          </div>
                        </div>
                        <div class="modal-body">
                          <form action="/update-card" method="post" id="changeCardData">
                            {{ csrf_field() }}

                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                  <label>Card number</label>
                                  <div class="row">
                                    <div class="col-12">
                                    <input id="cc-number" name="card_number" type="tel" maxlength="19" onkeyup="ccNumber()" class="form-control cc-number identified visa" placeholder="Enter Card Number (1111 2222 3333 4444)" value="" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number" autocomplete="cc-number">
                                    <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                            <!-- <input type="hidden" name="card_number" id="cc_changed"> -->
                            <div class="row">
                              <div class="col-12">
                                <div class="form-group" id="expiration-date">
                                  <label>Expiration Date</label>
                                  <div class="row">
                                    <div class="col-7">
                                      <select name="month" class="form-control">
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
                                    <div class="col-5">
                                      <select name="year" class="form-control">
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
                                  </div>
                                </div>

                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12">
                                <label for="x_card_code" class="control-label mb-1">CVV code</label>
                                <div class="input-group">
                                  <input id="x_card_code" name="cvv" type="password" maxlength="4" placeholder="Enter-CVV (123)" class="form-control cc-cvc" value="" data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" autocomplete="off">

                                </div>
                              </div>
                            </div>
                            <div>

                            </div>

                          </div>
                          <div class="modal-footer">

                            <button type="submit" id="send-mail-btn" class="btn modal-btn">
                              <span id="change-send-btn">Change</span>
                              <span id="mail-button-sending" style="display:none;"><i class="fa fa-spin fa-refresh"></i> Wait…</span>
                            </button>

                            <button type="button" class="close" data-dismiss="modal">&times;</button> 

                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- end model -->
                      
                      <!--- Cancel Subcription Model -->
                              <div class="modal fade" id="cancelSubModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                          <div class="modal-title-text">
                                            Cancel Subscription
                                          </div>
                                        </div>
                                        
                                                <div class="modal-body">
                                                  <h6 style="padding-bottom: 15px; color: #CC0000;">Are you sure? Cancel Subscription</h6>
                                                </div>
                                                  <div class="modal-footer">
                                            
                                            <center><a href="/cancel-subscription"><button type="button" id="send-mail-btn" class="btn modal-btn">
                                              <span id="send-btn">Confirm</span>
                                              
                                                </button></a></center>
                                            
                                                <button type="button" class="close" data-dismiss="modal">&times;</button> 

                                          </div>
                                        </div>
                                      </div>
                                    </div>
 
                  <!-- end model -->
<script>
  function addCardNumber() {
    $('#add-cc-number').on('keyup', function(e){
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

  function ccNumber() {
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

// function cardNumber() {
// // var account = document.getElementById('cc-number');
// // var changed = document.getElementById('cc_changed');

//     // changed.value = new Array(account.value.length-3).join('X') + account.value.substr(account.value.length-4, 4);

//     $('#card-number').on('keyup', function(e){
//         var val = $(this).val();
//         var newval = '';
//         val = val.replace(/\s/g, '');
//         for(var i=0; i < val.length; i++) {
//             if(i%4 == 0 && i > 0) newval = newval.concat(' ');
//             newval = newval.concat(val[i]);
//         }
//         $(this).val(newval);
//     });
//   }

///// delete card
$(".delete-card").click(function(ev){
  let delete_id = $(this).attr("DeleteId");
  var msg = confirm('Are you sure? Delete Card');
  if(msg){
    window.location.href = '/delete-card/'+delete_id;
//     $.ajax({
//       type: 'DELETE',
//       url: 'delete-card',
//       dataType: 'json',
//       method : 'post',
//       headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//       data: {
//         "id":delete_id,
//         "_token": "{{ csrf_token() }}"
//       },
//       success: function (data) {
//         if (data['success']) {
//           toastr.success("Card Deleted","Success");
//           $('#cancelSubModal').hide();
//           $(".modal .close").click();
//           location.reload();
// //toastr.success(data.message, data.title);
// } else if (data['error']) {
//   toastr.error("Sorry Card can not deleted","Error");
//   $('#cancelSubModal').hide();
//   $(".modal .close").click();
// } else {
//   toastr.error("Whoops Something went wrong!!","Error");
// }
// },

// error: function (error) {
//   console.log(error);
// }
// });
  }

});

/// Submit add New Card Data by Ajax

/// add new card data
$("form#addCardData").submit(function(e) {
  e.preventDefault();    
  var formData = new FormData(this);

  $.ajax({
    url: 'new-card',
    type: 'POST',
    data: formData,
    beforeSend: function() {
      $('#add-send-btn').hide();
      $('#add-mail-button-sending').show();
    },
    success: function (data) {
      if (data['success']) {
//$('#loading').hide();
toastr.success("Card Add","Success");
$('#addCardModal').hide();
$(".modal .close").click();
setTimeout(function(){
    location.reload();
  }, 2000);
//$('.msgMail').append(data .msg);
// $('#hidediv').show();
} else if (data['error']) {
  toastr.error(data['error'],"Error");
  $('#addCardModal').hide();
  $(".modal .close").click();
  setTimeout(function(){
    location.reload();
  }, 2000);
} else {
  toastr.error("Whoops Something went wrong!!","Error");
}
},
error: function (data) {
  toastr.error(data.responseText,"Error");
},
cache: false,
contentType: false,
processData: false
});
});

//// change card
$("form#changeCardData").submit(function(e) {
  e.preventDefault();    
  var formData = new FormData(this);

  $.ajax({
    url: 'update-card',
    type: 'POST',
    data: formData,
    beforeSend: function() {
      $('#change-send-btn').hide();
      $('#mail-button-sending').show();
    },
    success: function (data) {
      if (data['success']) {
//$('#loading').hide();
toastr.success("Card Updated","Success");
$('#cardModal').hide();
$(".modal .close").click();
setTimeout(function(){
    location.reload();
  }, 2000);
//$('.msgMail').append(data .msg);
// $('#hidediv').show();
} else if (data['error']) {
  toastr.error(data['error'],"Error");
  $('#cardModal').hide();
  $(".modal .close").click();
 setTimeout(function(){
    location.reload();
  }, 2000);
} else {
  toastr.error("Whoops Something went wrong!!","Error");
}
},
error: function (data) {
  toastr.error(data.responseText,"Error");
},
cache: false,
contentType: false,
processData: false
});
});


/// Submit add Update Plan Data by Ajax
$("form#PlanData").submit(function(e) {
  e.preventDefault();    
  var formData = new FormData(this);

  $.ajax({
    url: 'update-plan',
    type: 'POST',
    data: formData,
    beforeSend: function() {
      $('#send-btn').hide();
      $('#mail-button-sending2').show();
    },
    success: function (data) {
      if (data['success']) {
//$('#loading').hide();
toastr.success("Plan Updated","Success");
$('#planModal').hide();
$(".modal .close").click();
setTimeout(function(){
    location.reload();
  }, 2000);
//$('.msgMail').append(data .msg);
// $('#hidediv').show();
} else if (data['error']) {
  toastr.error(data['error'],"Error");
  $('#planModal').hide();
  $(".modal .close").click();
  setTimeout(function(){
    location.reload();
  }, 2000);
} else {
  toastr.error("Whoops Something went wrong!!","Error");
}
},
error: function (data) {
  toastr.error(data.responseText,"Error");
},
cache: false,
contentType: false,
processData: false
});
});


 $(document).ready(function(){
/// update plan on select plan show plan amount
   $('#select_plan').on('change', function() {
      var amount = $(this).val().split(',')[3];
      if(amount){
        var plan_amount = amount / 100; //console.log(plan_amount);
        $('.select-plan-amount').show();
        $('#show_plan_amount').text(plan_amount);
      }else{
        $('.select-plan-amount').hide();
      }
   });    
 });

</script>
                  
                  <!-- Cancel Subcriptions -->

                  
     
 @endsection