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
   .container{
    /*background-image: url("{{asset('/images/avatar/'.$inv->user->avatar)}}");*/
    background-position: center;
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
  .td-50{
    width: 50%;
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
  .inv-from{
    float: left;
    padding-top: 10px;
    font-weight: 100;
    font-size: 14px;
    color: #e91e63;
    margin-left: 35px;
  }
  .inv-to{
    float: right;
    padding-top: 10px;
    font-weight: 100;
    font-size: 14px;
    color: #e91e63;
    margin-right: 180px;
  }
  .inv-date{
  color: #e91e63;
  font-weight: 400;
  font-size: 12px;
  }
/*  .inv-logo{
      width: 90px;
    height: 90px;
  }*/
  img{
    width: 100px;
    height: auto;
  }
  .inv-name{
    text-transform: uppercase;
    font-size: 18px;
     padding-left: 10px;
}
.copmany-name{
  color: #e91e63;
    font-size: 14px;
    font-weight: 100;
    padding-left: 10px;
}
.inv-email{
  padding-bottom: 3px;
  color: #e91e63;
  font-weight: 400;
  font-size: 13px;
   padding-left: 10px;
}
.inv-address{
  font-weight: 100;
  padding-left: 10px;
}
.inv-state{
  font-weight: 100;
  padding-left: 10px;
}
.inv-city{
  font-weight: 100;
  padding-left: 10px;
}
.inv-country{
  font-weight: 100;
  padding-left: 10px;
}
.tr-border-bottom{
vertical-align: text-top !important;
padding-top: 10px;
}
.item-tr{
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
  font-size: 14px;
  text-align: left;
}
.amount-cl{
  position: absolute;
    right: 60px;
    text-align: left;
    width: 120px;
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
#clientImage{
    background: #1e2027;
    color: #fff;
    font-size: 32px;
    padding: 10px;
    width: 80px;
    height: 70px;
    text-align: center;
    text-transform: uppercase;
    border: 2px solid #e91e63;
    display: inline-block;
}
#userImage{
    background: #1e2027;
    color: #fff;
    font-size: 32px;
    padding: 10px;
    width: 80px;
    height: 70px;
    text-align: center;
    text-transform: uppercase;
    border: 2px solid #e91e63;
    display: inline-block;
}
.GSTIN-number-div{
  font-weight: 400;
    font-size: 14px;
    color: #000;
}
.GSTIN-number{
  font-weight: 400;
    font-size: 14px;
    color: #e91e63;
}
.user-company-name{
    text-align: center;
    text-transform: uppercase;
    font-size: 18px;
}
.company-address{
  font-weight: 100;
  text-align: center;
}
.title-txt{
  font-weight: 100;
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
        <div class="col-12 t-center">
           Invoice ({{$inv->invoice_number}}) from <!-- {{$inv->user->fname}} {{$inv->user->lname}}  -->{{$inv->user->company_name}}
       </div> 
    </div>

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
      <div class="col-12 title-txt">TIN NO. <span class="GSTIN-number">{{$inv->user->gstin_number}}</span></div>
    </div>
    <div class="row">
      <div class="col-12 title-txt">E-Mail :<span class="inv-email">{{$inv->user->email}}</span></div>
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
        <td class="td-50">
          <div class="">{{$inv->invoice_number}}</div>
          <div class="">{{$inv->client->fname}} {{$inv->client->lname}}</div>
          <div class="">{{$inv->client->address}}, {{$inv->client->state}}, {{$inv->client->city}}, {{$inv->client->country}}</div>
          <div class="">{{$inv->client->email}}</div>
        </td>
        <td class="td-15">
          <div class="pad-35">Issue Date #</div>
          <div class="pad-35">Due Date #</div>
          <div class="pad-35">Mobile #</div>
          <div class="pad-35">Status #</div>
        </td>
        <td class="td-20">
          <div class="inv-date">{{ date('m/d/Y', strtotime($inv->issue_date)) }}</div>
          <div class="inv-date">{{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
          <div class="">{{$inv->client->phone}}</div>
          <div class="">{{$inv->status}}</div>
        </td>
      </tr>
    </table>


<!--      <table class="table-w">
      <tr class="tr-border-bottom">
        <td class="td-1 t-l">
          @if(!empty($inv->user->avatar))
              <img src="{{asset('/images/avatar/'.$inv->user->avatar)}}" class="inv-logo">
          @else
              <div id="userImage">
                {{$inv->user->fname[0]}} {{$inv->user->lname[0]}}
              </div>
          @endif
          
        </td>
        <td class="td-3">
          <div class="user-block">
            <div class="inv-name">@if($inv->user->company_name){{$inv->user->company_name}} @else{{$inv->user->fname}} {{$inv->user->lname}}@endif</div>
            <div class="inv-email">{{$inv->user->email}}</div>
            <div class="inv-address">{{$inv->user->address}}</div>
            <div class="inv-state">{{$inv->user->state}}</div>
            <div class="inv-city">{{$inv->user->city}}</div>
            <div class="inv-country">{{$inv->user->country}}</div>
          </div>
          
        </td>
        <td class="td-2 t-l">
          <div class="date-block">
            <div class="inv-date-title">ISSUE DATE</div>
            <div class="inv-date">{{ date('m/d/Y', strtotime($inv->issue_date)) }}</div>
            <div class="inv-date-title">DUE DATE</div>
            <div class="inv-date">{{ date('m/d/Y', strtotime($inv->due_date)) }}</div>
          </div>
          
        </td>
       <td class="td-1 t-r">

        </td>
        <td class="td-3">
          <div class="client-block">
            <div class="inv-name">{{$inv->client->fname}} {{$inv->client->lname}}</div>
      
            <div class="inv-email">{{$inv->client->email}}</div>
            <div class="inv-address">{{$inv->client->address}}</div>
            <div class="inv-state">{{$inv->client->state}}</div>
            <div class="inv-city">{{$inv->client->city}}</div>
            <div class="inv-country">{{$inv->client->country}}</div>
          </div>
        </td>
      </tr>
      <tr>
        <td class="GSTIN-number-div" colspan="5">
          <div class="GSTIN-number">{{$inv->user->gstin_number}}</div>
        </td>
      </tr>
    </table> -->
    <hr>
    <table class="item-table-w">
      <tr>
        <th class="td-item-name">
          <strong>Item Name</strong>
        </th>
        <th class="td-item-desc">
           <strong>Description</strong>
        </th>
        <th class="td-item-rate">
          <strong>Rate</strong>
        </th>
        <th class="td-item-qty">
          <strong>Quantity</strong>
        </th>
        <th class="td-item-total">
          <strong>Line Total</strong>
        </th>
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
          <span style="margin-left: 15px; width: 100%; height: auto; float: left;">{{$item->qty}}</span>
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
