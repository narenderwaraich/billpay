<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Invoice PDF</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
 <style>
  body{
    font-size: 11px;
    font-weight: 400;
  }
   .container{
    /*background-image: url("{{asset('/images/avatar/'.$inv->user->avatar)}}");*/
    background-position: center;
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
    color: #e91e63;
    font-weight: 700;
    font-size: 12px;
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
  color: #e91e63;
  font-weight: 400;
  }
/*  .inv-logo{
      width: 90px;
    height: 90px;
  }*/
  img{
    width: 100px;
    height: auto;
  }
.inv-email{
  padding-bottom: 3px;
  color: #e91e63;
  font-weight: 400;
  font-size: 12px;
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
  font-size: 11px;
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
  font-weight: 400;
    font-size: 12px;
    color: #e91e63;
}
.user-company-name{
    text-align: center;
    text-transform: uppercase;
    font-size: 14px;
}
.company-address{
  font-weight: 400;
  text-align: center;
}
.title-txt{
  font-size: 11px;
  font-weight: 400;
  text-align: center;
}
.pad-35{
  padding-left: 35px;
}
</style>
</head>
<body>
<div class="container">
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
            <div class="invoice-amount-pay-status">DEPOSIT $ {{$inv->deposit_amount}} USD PAID ON {{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
            @endif
       </div> 
    </div>
    <div class="row">
      <div class="col-12 user-company-name">{{$inv->user->company_name}}</div>
    </div>
    <div class="row">
      <div class="col-12 company-address">{{$inv->user->address}}, {{$inv->user->city}}, {{$inv->user->state}}, {{$inv->user->country}}</div>
    </div>
    <div class="row">
      <div class="col-12 title-txt">E-Mail :<span class="inv-email">{{$inv->user->email}}</span></div>
    </div>
    <div class="row">
      <div class="col-12 title-txt">GST/TIN No. <span class="GSTIN-number">{{$inv->user->gstin_number}}</span></div>
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
          <div class="inv-date">{{ date('m/d/Y', strtotime($inv->issue_date)) }}</div>
          <div class="inv-date">{{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
          <div class="">{{$inv->client->phone}}</div>
          <div class="">{{$inv->status}}</div>
        </td>
      </tr>
    </table>
    <hr>
    <table class="item-table-w">
      <tr>
        <td class="td-item-name bill-heading-title">
          Item Name
        </td>
        <td class="td-item-desc bill-heading-title">
           Description
        </td>
        <td class="td-item-rate bill-heading-title">
          Rate
        </td>
        <td class="td-item-qty bill-heading-title">
          Quantity
        </td>
        <td class="td-item-total bill-heading-title">
          Line Total
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
          ${{$item->total}}
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
            <div class="amount-title">Payment Method</div>
            <div class="amount-title">Subtotal</div>
            <div class="amount-title">Discount</div>
            <div class="amount-title">Tax</div>
            <div class="amount-title"> Deposit Amount</div>
            <hr>
            <div class="amount-title">Total Amount</div>
            <div class="amount-title">Amount Paid</div>
            <div class="amount-title">Amount Due</div>
          </div>

          <div class="col-6-r">
            <div class="amount-title">{{$inv->payment_mode}}</div>
            <div class="amount-title">${{$inv->sub_total}}</div>
            <div class="amount-title">${{$inv->discount}}</div>
            <div class="amount-title">${{$inv->tax_rate}}</div>
            <div class="amount-title">${{$inv->deposit_amount}}</div>
            <hr>
            <div class="amount-title">${{$inv->net_amount}}</div>
            <div class="amount-title">${{$inv->net_amount - $inv->due_amount}}</div>
            <div class="amount-title">${{$inv->due_amount}}</div>
          </div>
        </div>
            
          </div>
        </div>
</div>
</body>
</html>
