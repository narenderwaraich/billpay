<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bill Pay</title>
    <meta name="description" content="Online Bill Pay">
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
</head>
<body>
<div class="wrapper ">
  <div class="main-panel" id="main-panel">
<!-- sidebar with menu -->
<div class="sidebar">
  <div class="logo">
    <a href="#" class="logo-mini">
      <img src="/public/images/icon/template-mini-logo.svg" alt="Web Logo" class="template-logo">
    </a>
    <a href="/dashboard" class="logo-normal">
      <img src="/public/images/icon/template-logo.svg" alt="Web Logo" class="template-logo">
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <li class="active">
        <a href="#">
          <i class="menu-icon fa fa-dashboard"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <li class="{{ (request()->is('about-us')) ? 'active' : '' }}">
        <a href="/about-us">
          <i class="menu-icon fa fa-users"></i>
          <p>About Us</p>
        </a>
      </li>

      <li class="{{ (request()->is('contact-Us')) ? 'active' : '' }}">
        <a href="/contact-Us">
          <i class="menu-icon fa fa-files-o"></i>
          <p>Contact Us</p>
        </a>
      </li>            
      <li>
        <a href="/login">
          <i class="menu-icon fa fa-user"></i>
          <p>Login</p>
        </a>
      </li>
    </ul>
  </div>
</div>
<!-- end sidebar -->


<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
<div class="content">
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
                          <input type="text" name="issue_date" value="{{ date('m/d/Y', strtotime($inv->issue_date)) }}" id="datepicker"  class="form-control datePick" width="150" />
                          <label style="z-index: 2;">ISSUE DATE</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="text" name="due_date" value="{{ date('m/d/Y', strtotime($inv->due_date)) }}" id="datepicker2" width="150" class="form-control datePick" />
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
            <div class="row">
                <div class="col-lg-12" style="margin: auto;text-align: center;">
                @if($inv->payment_mode == "PAID")
                <a href="/invoice/pay/{{$inv->id}}" class="btn-success btn-lg">Pay</a>
                @endif
                <a href="/invoice/download/PDF/{{$inv->id}}/{{$inv->invoice_number_token}}" class="btn-primary btn-lg">Download</a>
            </div>
        </div>
        <br>
          </div>
        </div>
      </div>
    </div>

    <!-- Invoice items add section -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Invoice Items <span>@if($inv->status == "PAID")
          HURRAY! PAID IN FULL ON DATE {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$inv->client->fname}} {{$inv->client->lname}}. @if($inv->deposit_amount > 0)   DEPOSIT of {{$inv->deposit_amount}} PAID ON {{ date('m/d/Y', strtotime($inv->deposit_date)) }} BY {{$inv->client->fname}} {{$inv->client->lname}} @endif
          @endif

          @if($inv->status == "PAID" || $inv->is_cancelled ==1)
            HURRAY! PAID IN FULL ON DATE {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$inv->client->fname}} {{$inv->client->lname}}
          @endif

          @if($inv->status == "DEPOSIT_PAID" || ($inv->status == "OVERDUE" && $inv->net_amount != $inv->due_amount) || $inv->is_cancelled ==2)
            DEPOSIT $ {{$inv->deposit_amount}} USD PAID ON {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$inv->client->fname}} {{$inv->client->lname}}
          @endif  </span></h5>
            <hr>
          </div>
          <div class="card-body">
            @foreach($invItem as $index => $item)
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <input type="text" name="arr[{{$index}}][item_name]" value="{{$item->item_name}}" class="form-control" readonly style="background-color: transparent;">
                    <label>Item Name</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input min="0" id="rate{{ $index }}" name="arr[{{$index}}][rate]"  value="{{$item->rate}}" type="text" class="form-control input-amt input-border" onkeyup="calc(this, {{ $index }})" readonly style="background-color: transparent;">
                    <label>Rate</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input min="0" id="qty{{ $index }}" name="arr[{{$index}}][qty]" type="text" value="{{$item->qty}}" class="form-control input-amt" onkeyup="calc(this, {{ $index }})" readonly style="background-color: transparent;">
                    <label>Quantity</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" name="arr[{{$index}}][total]" onkeyup="calc(this, {{ $index }})"  class="tot input-calculation input-amt form-control"  id="total{{ $index }}" value="{{$item->total}}" readonly style="background-color: transparent;">
                    <label>Total</label>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                   
                  </div>
                </div>
              </div>
              @if($item->item_description)
               <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <textarea  class="form-control" rows="2" id="comment" name="arr[{{$index}}][item_description]" readonly style="background-color: transparent;">{{$item->item_description}}</textarea>
                    <label>Description</label>
                  </div>
                </div>
              </div>
              @endif
             @endforeach
             <hr><br>
              <div class="row">
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-12">
                     <div class="form-group">
                          <textarea class="form-control" rows="8" name="terms" readonly style="background-color: transparent;width: 50%;">{{$inv->terms}}</textarea>
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
                      <div style="font-weight: 500;color: #757575;font-size: 10px;">{{$inv->payment_mode}}</div>
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
                       <input type="number" name="sub_total" id="total" onchange="myFunction()"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="{{$inv->sub_total}}" class="input-calculation form-control">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                      <label style="margin-top: 6px;">Discount <span class="percentage-text" id="show-percentage-val" style="display: none;margin-left: 5px;">(<input type="text" name="disInPer" value="{{$inv->disInPer}}" id="getValuePerDiscount" class="invoice-dis-value-input" readonly style="min-width: 17px;max-width: 22px;border: none;">%)</span></label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="discount" id="discount" onchange="myFunction()"  readonly value="{{$inv->discount}}" class="form-control input-calculation" placeholder="0" data-toggle="modal" data-target="#discountModal" readonly style="background-color: transparent;width: 75%;border: none;padding: 0;">
                     </div>
                   </div>
                 </div>

                  <div class="row">
                    <div class="col-md-5">
                     <div class="form-group amount-details-title" style="margin-bottom: 10px;">
                       <label style="margin-top: 6px;">Tax<span class="percentage-text" id="show-tax-val" style="display: none;margin-left: 5px;">(<input type="text" name="taxInPer" value="{{$inv->taxInPer}}" id="getValuePerTax" class="invoice-dis-value-input" readonly style="min-width: 17px;max-width: 22px;border: none;">%)</span></label>
                     </div>
                   </div>
                    <div class="col-md-7">
                     <div class="form-group" style="margin-bottom: 10px;">
                      <input type="text" name="tax_rate" id="tax_rate" onchange="myFunction()"  readonly value="{{$inv->tax_rate}}" class="form-control input-calculation" data-toggle="modal" data-target="#taxModal" readonly style="background-color: transparent;width: 75%;border: none;padding: 0;">
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
                      <input type="text" name="deposit_amount" id="deposit" value="{{$inv->deposit_amount}}" onkeyup="myFunction()" style="border: none;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;padding: 0;width: 75%;"  class="input-calculation form-control">
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
                      <input type="number" name="net_amount" id="net_amount" value="{{$inv->net_amount}}"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="0" onchange="myFunction()" class="input-calculation form-control">
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
                      <input type="number" name="due_amount" id="duePending"  readonly style="background-color: transparent;width: 75%;border: none;padding: 0;" value="{{$inv->due_amount}}" onchange="myFunction()" class="input-calculation form-control">
                     </div>
                   </div>
                 </div>



                </div>
              </div>


          </div>
        </div>
      </div>
    </div>
</div>
    </div>
</div>







<!-- <div class="invoice-pay-css">
    <div class="row top-row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <span class="inv-number-show">Invoice({{$inv->invoice_number}})</span>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="invoice-amount-pay-status invoice_payment_status_{{$inv->status}}" style="text-align: left;">
          @if($inv->status == "PAID")
          HURRAY! PAID IN FULL ON DATE {{ date('m/d/Y', strtotime($inv->payment_date)) }} by {{$inv->client->fname}} {{$inv->client->lname}}. @if($inv->deposit_amount > 0)   DEPOSIT of {{$inv->deposit_amount}} PAID ON {{ date('m/d/Y', strtotime($inv->deposit_date)) }} BY {{$inv->client->fname}} {{$inv->client->lname}} @endif
          @endif

          @if($inv->status == "PAID" || $inv->is_cancelled ==1)
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
            <div class="copmany-name"></div>
            <div class="inv-email">{{$inv->client->email}}</div>
            <div>
              <div class="col-4 col-sm-3 col-md-6 col-lg-5 col-xl-4">
                <div id="clientImage"></div>
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
                            @if($inv->status =="DEPOSIT_PAID")
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->deposit_amount}}</div>
                            @elseif($inv->status =="PAID-STRIPE")
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ {{$inv->net_amount}}</div>
                            @else
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 inv-amount">$ 0</div>
                            @endif
            </div>


            <div>
              <div class="col-6 col-sm-6 col-md-7 col-lg-6 col-xl-6 inv-heading">Net Amount Due</div>
              <div class="col-6 col-sm-6 col-md-5 col-lg-6 col-xl-6 inv-amount on-mob-pad-bottom" style="padding-bottom: 20px;">$ {{$inv->due_amount}}</div>
            </div>
          </div>
            </div>
    </div>
  @if($inv->payment_mode == "PAID")
    <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
      @if($inv->status =="PAID")
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
          @if($inv->status =="PAID")
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
  @endif 
</div>

</div> -->


             


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
                               <span class="alert-data-text">{{$inv->user->fname}} {{$inv->user->lname}}  </span>
                            </div>
                            <div class="modal-footer" style="display: flex !important;">
                                   <button type="button" id="refresh" class="btn model-alert-btn" data-dismiss="modal">Done</button>
                            </div>
                        </div>
                    </div>
                </div>

  <style>
  .client-data{
    display: block;
  }
</style>
    <script src="{{ asset('js/vendor/jquery-2.1.4.min.js') }}"></script>
   <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}               
    </body>
</html>
