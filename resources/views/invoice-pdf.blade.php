<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Invoice PDF</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <?php

  $invoiceLogoEnable = $userInvoiceSetting ? $userInvoiceSetting->logo : 0;
  $invoiceLogoPosL = $userInvoiceSetting ? $userInvoiceSetting->logo_left : 0;
  $invoiceLogoPosC = $userInvoiceSetting ? $userInvoiceSetting->logo_center : 0;
  $invoiceLogoPosR = $userInvoiceSetting ? $userInvoiceSetting->logo_right : 0;
  $invoiceLogoBg = $userInvoiceSetting ? $userInvoiceSetting->logo_bg : 0;
  $invoiceLogoOpacity = $userInvoiceSetting ? $userInvoiceSetting->logo_opacity : 1;
  $invoiceLogoH = $userInvoiceSetting ? $userInvoiceSetting->logo_hight : 90;
  $invoiceLogoW = $userInvoiceSetting ? $userInvoiceSetting->logo_width : 90;
  $invoiceFontSize = $userInvoiceSetting ? $userInvoiceSetting->invoice_font_size : 11;
  $invoiceFontWeight = $userInvoiceSetting ? $userInvoiceSetting->invoice_font_weight : 400;
  $invoiceFontSizeS = $userInvoiceSetting ? $userInvoiceSetting->invoice_font_size_1 : 11;
  $invoiceFontSizeM = $userInvoiceSetting ? $userInvoiceSetting->invoice_font_size_2 : 12;
  $invoiceFontSizeL = $userInvoiceSetting ? $userInvoiceSetting->invoice_font_size_3 : 14;
  $invoiceFontWeightS = $userInvoiceSetting ? $userInvoiceSetting->invoice_font_weight_1 : 400;
  $invoiceFontWeightM = $userInvoiceSetting ? $userInvoiceSetting->invoice_font_weight_2 : 700;
  $invoiceTitleColor = $userInvoiceSetting ? $userInvoiceSetting->invoice_heading_title_color : '#e91e63';
  $invoiceDateColor = $userInvoiceSetting ? $userInvoiceSetting->invoice_heading_date_color : '#e91e63';
  $invoiceEmailColor = $userInvoiceSetting ? $userInvoiceSetting->invoice_heading_email_color : '#e91e63';
  $invoiceGstColor = $userInvoiceSetting ? $userInvoiceSetting->invoice_heading_gst_color : "#e91e63";

  ?>
 <style>
  body{
    font-size: <?php echo $invoiceFontSize ?>px;
    font-weight: <?php echo $invoiceFontWeight ?>;
  }
  .fs-1{
    font-size: <?php echo $invoiceFontSizeS ?>px;
  }
  .fs-2{
    font-size: <?php echo $invoiceFontSizeM ?>px;
  }
  .fs-3{
    font-size: <?php echo $invoiceFontSizeL ?>px;
  }
  .f-w-1{
    font-weight: <?php echo $invoiceFontWeightS ?>;
  }
  .f-w-2{
    font-weight: <?php echo $invoiceFontWeightM ?>;
  }
   .container{
    
   }
   section{
    position: relative;
    z-index: 1;
   }
    section .logo-bg{
      position: absolute;
/*      background-position: center;
      background-size: cover;*/
      opacity: <?php echo $invoiceLogoOpacity ?>;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -1;
   }
   .company-info{
    position: relative;
   }
   .inv-logo{
      width: <?php echo $invoiceLogoW ?>px;
      height: <?php echo $invoiceLogoH ?>px;
  }
/*  img{
    width: 100px;
    height: auto;
  }*/
   .logo-left{
      position: absolute;
      top: 0;
      left: 0;
      display: block !important;
   }
   .logo-right{
      position: absolute;
      top: 0;
      right: 0;
      display: block !important;
   }
   .logo-center{
      text-align: center;
      margin: 10px auto;
      display: block !important;
   }
   hr{
      box-sizing: content-box;
      height: 0;
      overflow: visible;
      margin-top: 1rem;
      margin-bottom: 1rem;
      border: 0;
      border-top: 1px solid rgba(0,0,0,.1);
   }
   table{
     
   }
   tr{
   
   }
   th{

   }
   td{
   
   }
   .t-center{
    text-align: center;
   }
   .t-left{
    text-align: left;
   }
   .invoice-amount-pay-status{
      color: #e91e63;
      text-align: left;
    } 
  .table-w{
    width: 100%;
    height: auto;
    margin-top:10px;
  }
  .td-15{
    width: 15%;
    height: auto;
  }
  .td-20{
    width: 20%;
    height: auto;
  }
  .td-25{
    width: 25%;
    height: auto;
  }
  .td-40{
    width: 40%;
    height: auto;
  }
  .td-1{
    width: 10%;
    height: auto;
  }
  .td-2{
    width: 20%;
    height: auto;
  }
  .td-3{
    width: 30%;
    height: auto;
  }
  .bill-heading-title{
    color: <?php echo $invoiceTitleColor ?>;
  }
  .item-table-w{
    width: 100%;
    height: auto;
    margin-top: 20px;
    margin-bottom: 20px;
  }
  .td-item-name{
    width: 15%;
    height: auto;
  }
  .td-item-desc{
    width: 50%;
    height: auto;
  }
  .td-item-rate{
    width: 10%;
    height: auto;
  }
  .td-item-qty{
    width: 10%;
    height: auto;
  }
  .td-item-total{
    width: 15%;
    height: auto;
  }
  .cal-table-w{
    width: 100%;
    height: auto;
    margin-top: 10px;
  }
  .td-term{
  width: 60%;
  height: auto;
  display: block !important;
}
.td-cal-title{
  width: 20%;
  height: auto;
  text-align: left;
}
.td-amount{
  width: 20%;
  height: auto;
  text-align: left;
}
  .t-l{
    text-align: left;
  }
  .t-c{
    text-align: center;
  }
  .t-r{
    text-align: right;
  }
  .inv-date{
    color: <?php echo $invoiceDateColor ?>;
  }
.inv-email{
  padding-bottom: 3px;
  color: <?php echo $invoiceEmailColor ?>;
   padding-left: 10px;
}
.tr-border-bottom{
vertical-align: text-top !important;
padding-top: 10px;
}
.item-tr{
  width: 100% !important;
  border-bottom: 2px solid #000 !important;
  vertical-align: text-top !important;
  padding-bottom: 20px;
}
.bottom-box{
  width: 100%;
  height:  280px;
}
.bottom-box-left{
  width: 60%;
  height:  auto;
  float: left;
}
.bottom-box-right{
  width: 40%;
  height: auto;
  float: right;
}
.amount-title{
  /*position: relative;*/
  text-align: left;
}
.col-12{
  width: 100%;
  height: auto;
}
.col-6-l{
  width: 50%;
  height: auto;
  float: left;
  margin-left: 10px;
}
.col-6-r{
  width: 50%;
  height: auto;
  float: left;
  margin-left: 150px;
}
.GSTIN-number{
    color: <?php echo $invoiceGstColor ?>;
}
.user-company-name{
    text-align: center;
    text-transform: uppercase;
}
.company-address{
  text-align: center;
}
.title-txt{
  text-align: center;
}
.pad-35{
  padding-left: 35px;
}
</style>
</head>
<body>
<div class="container">
  <section>
    @if($invoiceLogoEnable == 1)
      @if($invoiceLogoBg == 1)
        <img src="{{asset('/public/images/companies-logo/'.$inv->user->avatar)}}" class="logo-bg">
      @endif
    @endif
    <div class="row">
        <div class="col-12 t-left">
           Invoice ({{$inv->invoice_number}})
       </div> 
    </div>
    <br>
    <div class="row">
        <div class="col-12 t-center">
           @if($inv->status == "PAID")
            <div class="invoice-amount-pay-status">HURRAY! PAID IN FULL ON DATE {{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
            @endif

            @if($inv->status == "DEPOSIT_PAID")
            <div class="invoice-amount-pay-status">DEPOSIT Rs. {{$inv->deposit_amount}} USD PAID ON {{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
            @endif
       </div> 
    </div>
    <div class="company-info">
      @if($invoiceLogoEnable == 1)
        @if($invoiceLogoBg == 0)
          <img src="{{asset('/public/images/companies-logo/'.$inv->user->avatar)}}" class="inv-logo @if($invoiceLogoPosL ==1) logo-left @endif @if($invoiceLogoPosC ==1) logo-center @endif @if($invoiceLogoPosR ==1) logo-right @endif" style="display: none;">
        @endif
      @endif
      <div class="row">
        <div class="col-12 user-company-name fs-3">{{$inv->user->company_name}}</div>
      </div>
      <div class="row">
        <div class="col-12 company-address f-w-1">{{$inv->user->address}}, {{$inv->user->city}}, {{$inv->user->state}}, {{$inv->user->country}}</div>
      </div>
      <div class="row">
        <div class="col-12 title-txt fs-1 f-w-1">E-Mail :<span class="inv-email fs-2 f-w-1">{{$inv->user->email}}</span></div>
      </div>
      <div class="row">
        <div class="col-12 title-txt fs-1 f-w-1">GST/TIN No. <span class="GSTIN-number fs-2 f-w-1">{{$inv->user->gstin_number}}</span></div>
      </div>
    </div>

    <hr>
    <table class="table-w">
      <tr class="tr-border-bottom">
        <td class="td-15">
          <div class="pad-35">Invoice #</div>
          <div class="pad-35">Client #</div>
          <div class="pad-35">Address #</div>
          <div class="pad-35">E-Mail #</div>
        </td>
        <td class="td-40">
          <div class="">{{$inv->invoice_number}}</div>
          <div class="">{{$inv->client->fname}} {{$inv->client->lname}}</div>
          <div class="">{{$inv->client->address}}, {{$inv->client->state}}, {{$inv->client->city}}, {{$inv->client->country}}</div>
          <div class="">{{$inv->client->email}}</div>
        </td>
        <td class="td-20">
          <div class="pad-35">Issue Date #</div>
          <div class="pad-35">Due Date #</div>
          <div class="pad-35">Mobile #</div>
          <div class="pad-35">Status #</div>
        </td>
        <td class="td-25">
          <div class="inv-date f-w-1">{{ date('m/d/Y', strtotime($inv->issue_date)) }}</div>
          <div class="inv-date f-w-1">{{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
          <div class="">{{$inv->client->phone}}</div>
          <div class="">{{$inv->status}}</div>
        </td>
      </tr>
    </table>
    <hr>
    <table class="item-table-w">
      <tr>
        <td class="td-item-name bill-heading-title fs-2 f-w-2">
          Item Name
        </td>
        <td class="td-item-desc bill-heading-title fs-2 f-w-2">
           Description
        </td>
        <td class="td-item-rate bill-heading-title fs-2 f-w-2">
          Rate
        </td>
        <td class="td-item-qty bill-heading-title fs-2 f-w-2">
          Quantity
        </td>
        <td class="td-item-total bill-heading-title fs-2 f-w-2">
          Total
        </td>
      </tr>
       @foreach($invItem as $item)
      <tr class="item-tr">
        <td class="td-item-name">
          {{$item->item_name}}
        </td>
        <td class="td-item-desc" style="padding-bottom: 10px;">
          {!! nl2br($item->item_description) !!}
        </td>
        <td class="td-item-rate">   
          {{$item->rate}}
        </td>
        <td class="td-item-qty">
          <span style="margin-left: 15px; width: 100%; height: auto;">{{$item->qty}}</span>
        </td>
        <td class="td-item-total">
          Rs.{{$item->total}}
        </td>
      </tr>
      @endforeach
    </table>
     <hr>
    <div class="bottom-box">
      <div class="bottom-box-left">
        <strong>Terms:-</strong>
        <br>
          <span style="margin-left: 13px;">{!! nl2br($inv->terms) !!}</span>
      </div>
      <div class="bottom-box-right">
        <div class="col-12">
          <div class="col-6-l">
            <div class="amount-title fs-1">Payment Method</div>
            <div class="amount-title fs-1">Subtotal</div>
            <div class="amount-title fs-1">Discount</div>
            <div class="amount-title fs-1">Tax</div>
            <div class="amount-title fs-1"> Deposit Amount</div>
            <hr>
            <div class="amount-title fs-1">Total Amount</div>
            <div class="amount-title fs-1">Amount Paid</div>
            <div class="amount-title fs-1">Amount Due</div>
          </div>

          <div class="col-6-r">
            <div class="amount-title fs-1">{{$inv->payment_mode}}</div>
            <div class="amount-title fs-1">Rs.{{$inv->sub_total}}</div>
            <div class="amount-title fs-1">Rs.{{$inv->discount}}</div>
            <div class="amount-title fs-1">Rs.{{$inv->tax_rate}}</div>
            <div class="amount-title fs-1">Rs.{{$inv->deposit_amount}}</div>
            <hr>
            <div class="amount-title fs-1">Rs.{{$inv->net_amount}}</div>
            <div class="amount-title fs-1">Rs.{{$inv->net_amount - $inv->due_amount}}</div>
            <div class="amount-title fs-1">Rs.{{$inv->due_amount}}</div>
          </div>
        </div>
            
          </div>
        </div>
    </section>
</div>
</body>
</html>
