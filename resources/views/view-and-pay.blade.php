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
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"> -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script type="text/javascript"> //<![CDATA[ 
      var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
      document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
      //]]>
    </script>
</head>
<body>
 <nav class="navbar navbar-expand-lg navbar-dark static-top nav-bottom-border fix-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
          <img src="/images/mapleebooks_logo.svg" alt="Logo" class="nav-logo">
        </a>
    <button class="navbar-toggler m-right-15" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto nav-m-r">
        <li class="nav-item">
          <a class="nav-link nav-text" href="/about-us">About US</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link" href="/Contact-Us">Contact Us</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link" href="/login">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="invoice-pay-css">
    <div class="row top-row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <span class="inv-number-show">Invoice({{$inv->invoice_number}})</span>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="invoice-amount-pay-status invoice_payment_status_{{$inv->status}}" style="text-align: left;">
          @if($inv->status == "PAID-BANKWIRE" || $inv->status == "PAID-OFFLINE")
          HURRAY! PAID IN FULL ON DATE {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$inv->client->fname}} {{$inv->client->lname}}. @if($inv->deposit_amount > 0)   DEPOSIT of {{$inv->deposit_amount}} PAID ON {{ date('m/d/Y', strtotime($inv->deposit_date)) }} BY {{$inv->client->fname}} {{$inv->client->lname}} @endif
          @endif

          @if($inv->status == "PAID-STRIPE" || $inv->is_cancelled ==1)
            HURRAY! PAID IN FULL ON DATE {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$inv->client->fname}} {{$inv->client->lname}}
          @endif

          @if($inv->status == "DEPOSIT_PAID" || ($inv->status == "OVERDUE" && $inv->net_amount != $inv->due_amount) || $inv->is_cancelled ==2)
            DEPOSIT $ {{$inv->deposit_amount}} USD PAID ON {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$inv->client->fname}} {{$inv->client->lname}}
          @endif  
        </div>
      </div>
        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
          <div class="dwn-text downloadInvoice" data-id="{{$inv->id}}" inv-token="{{$inv->invoice_number_token}}" >Download Invoice</div>
        </div>
    </div>


    @if($inv->status == "CANCEL")
    <div class="row">
    <div class="col-12 refund-btn-show-on-mob txt-center">
      <div class="refund-btn-show-on-mob cancel-status-text">CANCELLED ON {{ date('m/d/Y', strtotime($inv->refund_date)) }}</div>
    </div>
  </div>
  @endif

 <!-- invoice data view -->
<div class="row-class invoice-change-col inv-pay-view-data">
   @if($inv->payment_mode == "STRIPE-PAYMENT")
    <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 padding-0">
    @else
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    @endif
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 inv-area p-r">
          <div class="inv-box-title-to hide-on-mob">
            INVOICE TO
          </div>
          <div class="col-12 col-sm-12 col-md-4 col-lg-5 col-xl-4 clint-data row-remove-pad">

            <div class="inv-name">{{$inv->user->fname}} {{$inv->user->lname}}</div>
            <div class="copmany-name">{{$inv->user->company_name}}</div>
            <div class="inv-email">{{$inv->user->email}}</div>
            <div>
              <div class="col-4 col-sm-3 col-md-7 col-lg-5 col-xl-4">
                @if(!empty($inv->user->avatar))
                <img src="/images/avatar/{{$inv->user->avatar}}" class="img-fluid">
                @else
                <div id="userImage"></div>
                @endif
              </div>
              <div class="col-8 col-sm-9 col-md-5 col-lg-7 col-xl-8 address-div">
                <div class="inv-address">{{$inv->user->address}}</div>
                <div class="inv-state">{{$inv->user->state}}</div>
                <div class="inv-city">{{$inv->user->city}}</div>
                <div class="inv-country">{{$inv->user->country}}</div>
              </div>
            </div>
          </div>
          <hr class="show-line row-remove-pad">
          <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-4 mob-date-div row-remove-pad">
            <div class="inv-date-title">ISSUE DATE</div>
            <div class="inv-date2">{{ date('m/d/Y', strtotime($inv->issue_date)) }}</div>
            <div class="inv-date-title">DUE DATE</div>
            <div class="inv-date2">{{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
          </div>
          
            <hr class="show-line row-remove-pad">
       
          <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 clint-data row-remove-pad">
            <div class="inv-name">{{$inv->client->fname}} {{$inv->client->lname}}</div>
            <div class="copmany-name">{{$inv->companies->name}}</div>
            <div class="inv-email">{{$inv->client->email}}</div>
            <div>
              <div class="col-4 col-sm-3 col-md-6 col-lg-5 col-xl-4">
                @if(!empty($inv->companies->logo))
                <img src="/company_logo/{{$inv->companies->logo}}" class="img-fluid">
                @else
                <div id="clientImage"></div>
                @endif
              </div>
              <div class="col-8 col-sm-9 col-md-6 col-lg-7 col-xl-8 address-div">
                <div class="inv-address">{{$inv->client->address}}</div>
                <div class="inv-state">{{$inv->client->state}}</div>
                <div class="inv-city">{{$inv->client->city}}</div>
                <div class="inv-country">{{$inv->client->country}}</div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 GST-Number">
            <div class="gst-num">{{$inv->user->gstin_number}}</div>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-remove-pad">
            <hr class="inv-line">
          </div>



          @foreach($invItem as $index => $item)
          <div class="col-sm-3 col-6 col-md-3 col-lg-2 col-xl-2 inv-data row-remove-pad" style="padding-left: 35px;">
            <div class="inv-heading">Item</div>
            {{$item->item_name}}
          </div>
          <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 inv-data hide-on-mob">
            <div class="inv-heading">Description</div>
            {!! nl2br($item->item_description) !!}
          </div>
          <div class="col-sm-3 col-6 col-md-3 col-lg-2 col-xl-2 inv-data">
            <div class="inv-heading">Rate</div>
            $ {{$item->rate}}
          </div>
          <div class="col-sm-3 col-6 col-md-3 col-lg-2 col-xl-2 inv-data margin-t">
            <div class="inv-heading">Quantity</div>
            $ {{$item->qty}}
          </div>
          <div class="col-sm-3 col-md-3 col-6 col-lg-2 col-xl-2 inv-data margin-t">
            <div class="inv-heading">Line Total</div>
            $ {{$item->total}}
          </div>

          <div class="col-6 col-sm-12 col-lg-12 inv-data show-on-mob row-remove-pad" style="display: none;">
            <div class="inv-heading">Description</div>
            {!! nl2br($item->item_description) !!}
          </div>

          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-remove-pad">
            <hr class="inv-line">
          </div>

          @endforeach




          <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-8 inv-heading row-remove-pad" style="padding-left: 35px;">

            <!-- <div>Notes: <br>
              {!! nl2br($inv->notes) !!}
            </div>
            <br> -->
            <div>Terms: <br>
              {!! nl2br($inv->terms) !!}
            </div>
            <hr class="show-line">
          </div>
          <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 row-remove-pad">



            @if(isset($inv->payment_mode))
            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Payment Method</div>
              <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount">@if($inv->payment_mode == "STRIPE-PAYMENT") STRIPE @elseif($inv->payment_mode == "BANKWIRE-PAYMENT") BANK @else OFFLINE @endif</div>
            </div>
            @endif
            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Sub Total</div>
              <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount">$ {{$inv->sub_total}}</div>
            </div>

            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Discount <span class="percentage-text">@if(!empty($inv->disInPer)){{$inv->disInPer}}% @else @endif</span></div>
              <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount">$ {{$inv->discount}}</div>
            </div>

            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Tax <span class="percentage-text">@if(!empty($inv->taxInPer)){{$inv->taxInPer}}% @else @endif</span></div>
              <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount">$ {{$inv->tax_rate}}</div>
            </div>

            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Deposit Amount</div>
              <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount">$ {{$inv->deposit_amount}}</div>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-remove-pad">
            <hr class="inv-line">
            </div>

            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Total Amount</div>    
                <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount">$ {{$inv->net_amount}}</div>
            </div>

            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Amount Paid</div>
              <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount">$ {{$inv->net_amount - $inv->due_amount}}</div>
                            <!-- @if($inv->status =="DEPOSIT_PAID")
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->deposit_amount}}</div>
                            @elseif($inv->status =="PAID-STRIPE")
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->net_amount}}</div>
                            @else
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ 0</div>
                            @endif -->
            </div>


            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Net Amount Due</div>
              <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount on-mob-pad-bottom" style="padding-bottom: 20px;">$ {{$inv->due_amount}}</div>
            </div>
          </div>
            </div>
    </div>
  @if($inv->payment_mode == "STRIPE-PAYMENT")
    <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
      @if($inv->status =="PAID-STRIPE")
      <div class="pay-div">
        <div class="form-top-title">Signup for free 30 days trail</div>
        <div class="form-style shadow-lg">
        <form action="/SignUp" method="post">
                          {{ csrf_field() }}
                           <div class="row">
                          <div class="col-12">
                           <div class="form-group">
                              <input type="text" class="form-control form-input" name="fname" id="fname" placeholder="First Name" required value="{{ old('fname') }}">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                          <div class="form-group">
                              <input type="text" class="form-control form-input" name="lname" placeholder="Last Name" required value="{{ old('lname') }}">
                          </div>
                          </div>
                      </div>
                          <div class="form-group">
                              <input type="email" name="email" class="form-control form-input" placeholder="Email" value="{{ old('email') }}" required>
                          </div>
                           <div class="row">
                            <div class="col-12">
                              <div class="form-group">
                                <input id="password-field" type="password" class="form-control form-input" name="password" placeholder="Password" required>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                </div>
                              </div>
                            </div>
                           <!-- <input type="checkbox" onclick="myFunction()"> &nbsp; <b>Show Password</b> -->
                           <br>
                          <button type="submit" class="btn btn-lg btn-block form-btn">
                          Get Started</button>
                          <br>
                          <div style="float: right;">Already have account ? <a href="/login" style="color: #0d47a1">Sign in</a></div>
                          <br>

                      </form>
                    </div>
        </div>
      @else

      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pay-box @if($inv->status !='DEPOSIT_PAID') pay-full-div-top @else pay-deposit-div-top @endif">
        <div class="pay-box-title">
          @if($inv->status =="OVERDUE" && $inv->net_amount != $inv->due_amount)
              <div class="pay-card-title">Overdue Invoice</div>
          @elseif((!empty($inv->deposit_amount))&& $inv->status !="DEPOSIT_PAID")
              <div class="pay-card-title">Pay Deposit</div>
          @else
              <div class="pay-card-title">Make a Payment</div>
          @endif
        </div>
        <form  method="post" id="InvoiceData">
            {{ csrf_field() }}
            <input type="hidden" name="invoice_id" value="{{$inv->id}}">
        <div class="col-5 t-c">
          <div class="amount-text">Amount <span class="usd"> USD</span>
           </div>
        </div>
        <div class="col-7 t-l">
          <div class="amount-show-pay-box">
          @if($inv->status =="PAID-STRIPE")
            $0
            <input type="hidden" name="amount"  value="0">
          @else
               @if($inv->status =="OVERDUE" && $inv->net_amount != $inv->due_amount)
                  ${{$inv->due_amount}}
              <input type="hidden" name="full_amount"  value="{{$inv->due_amount}}">
              @elseif((!empty($inv->deposit_amount))&& $inv->status !="DEPOSIT_PAID")
                  ${{$inv->deposit_amount}}
              <input type="hidden" name="deposit_amount"  value="{{$inv->deposit_amount}}">
              @else
                  ${{$inv->due_amount}}
              <input type="hidden" name="full_amount"  value="{{$inv->due_amount}}">
              @endif
          @endif
          </div>
        </div>
     <br>
        <div class="input-lable">
          Card Number
        </div>
        <input id="cc-number" name="card_number" type="tel" maxlength="19" onkeyup="ccNumber()" class="form-control cc-number card-number-input" placeholder="Card Number" required>

        <div class="input-lable2">
          Expiration Date
        </div>
        <div class="col-6 p-l-25">
          <select name="month" class="form-control card-select-month">
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
          <select name="year" class="form-control card-select-year">
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
        <div class="input-lable3">
          CVV CODE
        </div>
        <input id="cc-number" name="cvv" type="password" maxlength="4"  class="form-control cc-number card-number-input" placeholder="CVV" required>

        <br>
        <center>
             <button id="payment-button" type="submit" class="btn form-btn btn-lg btn-block" style="width: 50%;">
                  <span id="payment-button-amount">Pay Now</span>
                  <span id="payment-button-sending" style="display:none;">Processing…</span>
              </button>
         </center>
       </form>
      </div>

       @endif
    </div>
  @endif  <!-- payment method -->
</div>

<div class="container-fluid footer">
        
          <center>
            <a class="navbar-brand" href="/">
              <img src="/images/mapleebooks_logo_white.svg" alt="Logo" class="footer-img2" align="center"> 
            </a>
          </center>
          <div class="footer-txt">
            Invoice clients swiftly, securely and get paid
          </div>
          <div class="secure-logo">
                  <script language="JavaScript" type="text/javascript">
                TrustLogo("https://mapleebooks.com/images/positivessl_trust_seal_md_167x42.png", "CL1", "none");
                </script>
          </div>


              
            <div class="footer-txt2"> 
              All Right reserved @ 9711368 canada Inc
            </div>
        
      
</div>
</div>

                          <!-- client or user Name to Image -->

              <span id="clientFirstName" style="display: none;">{{$inv->client->fname}}</span>
              <span id="clientLastName" style="display: none;">{{$inv->client->lname}}</span>

              <span id="userFirstName" style="display: none;">{{$inv->user->fname}}</span>
              <span id="userLastName" style="display: none;">{{$inv->user->lname}}</span>


<button type="button" id="openModel" data-toggle="modal" data-target="#staticModal" style="display: none;">Model open</button> 

<div class="modal fade" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-sm alert-mdl" role="document">
                        <div class="modal-content" style="background-color: #fff !important;border-radius: 0.3rem !important;">
                            <div class="modal-header" style="border-bottom: none !important;">

                            </div>
                            <div class="modal-body">
                                <!-- <img src="/images/success-tick.gif" class="success-tick"> -->
                               <span class="alert-heading-text">Payment successful!</span> <br>
                               <span class="alert-text">On your statement the transaction will show as:</span>
                               <span class="alert-data-text">{{$inv->user->fname}} {{$inv->user->lname}} ({{$inv->companies->name}}) </span>
                            </div>
                            <div class="modal-footer" style="display: flex !important;">
                                   <button type="button" id="refresh" class="btn model-alert-btn" data-dismiss="modal">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
    <script src="{{ asset('js/vendor/jquery-2.1.4.min.js') }}"></script>
   <script src="{{ asset('js/plugins.js') }}"></script>
   <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
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

                    <script>
                        $("form#InvoiceData").submit(function(e) {
                              e.preventDefault();
                              var formData = new FormData(this);

                              $.ajax({
                                  url: '/pay-payment',
                                  type: 'post',
                                  data: formData,
                                  processData: false,
                                  contentType: false,
                                  dataType: 'json',
                                  beforeSend: function() {
                                      $('#payment-button-amount').hide();
                                      $('#payment-button-sending').show();
                                      $("#payment-button").attr("disabled", "disabled");
                                  },
                                  success: function (data) {
                                    $('#openModel').click();
                                      // $('#companies_id')
                                      //  .append($("<option selected></option>")
                                      //             .attr("value",data.id)
                                      //             .text(data.name));
                                      // $("#companyLogo").attr('src','/company_logo/'+data.logo);
                                      // $('#addCompanyModal').hide(); /// hide modal
                                      // $(".modal .close").click(); /// close modals
                                      // $('#show-logo').show();
                                  },
                                  error: function (data) {
                                    toastr.error(data.responseText);
                                    $('#payment-button-sending').hide();
                                    $('#payment-button-amount').show();
                                    $("#payment-button").removeAttr("disabled");
                                    //alert(data.responseText);

                                  }
                              });
                          });

                          // refesh page
                          $('#refresh').on("click", function () {
                            location.reload();
                          });

                          /// Download invoice pdf file
                         $(document).ready(function () {
                                $('.downloadInvoice').on('click', function(e) {
                                var id = $(this).attr('data-id');
                                var invToken = $(this).attr('inv-token');
                                  window.location.href = '/invoice/download/PDF/'+id+'/'+invToken;       
                              });
                            });
                    </script>

                    <script type="text/javascript">
                    $(document).ready(function(){
                         var firstName = $('#clientFirstName').text();
                         var lastName = $('#clientLastName').text();
                         var dot = '.';
                         var intials = firstName.charAt(0) + dot + lastName.charAt(0);
                         var profileImage = $('#clientImage').text(intials);
                         });
                    </script>
                    <script type="text/javascript">
                    $(document).ready(function(){
                         var firstName = $('#userFirstName').text();
                         var lastName = $('#userLastName').text();
                         var dot = '.';
                         var intials = firstName.charAt(0) + dot + lastName.charAt(0);
                         var profileImage = $('#userImage').text(intials);
                         });
                    </script>



    </body>
</html>
