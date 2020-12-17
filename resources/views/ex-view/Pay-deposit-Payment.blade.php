<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MapleBooks</title>
    <meta name="description" content="MapleBooks">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"> -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--     <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script> -->
    
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color: #000;">

          <!-- Error Message  -->
              @if(count($errors)>0)
                
              @foreach($errors ->all() as $error)

              <div class="alert alert-danger">
              {{$error}}
              </div>
              @endforeach
              @endif

              <!-- Success Message -->
              @if(session('success'))
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                  <span class="badge badge-pill badge-success">Success</span> {{session('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                 @endif

                <div class="content mt-3">
            <div class="animated fadeIn">

              <center>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card" style="width: 600px; height: auto; text-align: left; margin-top: 70px;">
                        <div class="card-header">
                            <strong class="card-title">Pay Payment</strong><span style="padding-left: 50px;"> <img src="/images/mapleebooks_logo.png" alt="Logo"></span>
                        </div>
                        <div class="card-body">
                          <!-- Credit Card -->
                          <div id="pay-invoice">
                              <div class="card-body">
                                  <div class="card-title">
                                      <h3 class="text-center">Enter Card</h3>
                                  </div>
                                  <hr>
                                  <form action="/pay-payment" method="post">
                                      {{ csrf_field() }}
                                      <div class="form-group text-center">
                                          <ul class="list-inline">
                                              <li class="list-inline-item"><i class="text-muted fa fa-cc-visa fa-2x"></i></li>
                                              <li class="list-inline-item"><i class="fa fa-cc-mastercard fa-2x"></i></li>
                                              <li class="list-inline-item"><i class="fa fa-cc-amex fa-2x"></i></li>
                                              <li class="list-inline-item"><i class="fa fa-cc-discover fa-2x"></i></li>
                                          </ul>
                                      </div> 
                                      <input type="hidden" name="invoice_id" value="{{$id}}">
                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="select" class=" form-control-label">Amount</label></div>
                                        <div class="col-12 col-md-9">
                                          <input type="tel" name="amount" class="form-control" value="{{$depositPayment}}" readonly>
                                        </div>
                                      </div>
                                       <div class="row form-group">
                                        <div class="col col-md-3"><label for="cc-number" class=" form-control-label">Card number</label></div>
                                        <div class="col-12 col-md-9">
                                          <input id="cc-number" name="card_number" type="tel" maxlength="19" onkeyup="ccNumber()" class="form-control cc-number identified visa" placeholder="Enter Card Number (1111 2222 3333 4444)" value="" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number" autocomplete="cc-number">
                                          <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                        </div>
                                      </div>
                                      
                                      <!-- <input type="hidden" name="card_number" id="cc_changed"> -->
                                      <div class="row">
                                          <div class="col-6">
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
                                                      <option value="19"> 2019</option>
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
                                          <div class="col-6">
                                              <label for="x_card_code" class="control-label mb-1">CVV code</label>
                                              <div class="input-group">
                                                  <input id="x_card_code" name="cvv" type="tel" maxlength="4" placeholder="Enter-CVV (123)" class="form-control cc-cvc" value="" data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" autocomplete="off">
                                              
                                              </div>
                                          </div>
                                      </div>
                                      <div>
                                          <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                              <i class="fa fa-lock fa-lg"></i>&nbsp;
                                              <span id="payment-button-amount">Pay Now</span>
                                              <span id="payment-button-sending" style="display:none;">Sending…</span>
                                          </button>
                                      </div>
                                  </form>
                              </div>
                          </div>

                        </div>
                    </div> <!-- .card -->

                  </div><!--/.col-->
              </div>
          </center>
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
                    </script>

      <script src="{{ asset('js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
<script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

    </body>
</html>  