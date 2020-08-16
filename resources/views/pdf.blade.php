<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Invoice PDF</title>
    <style type="text/css">
body{
      font-size: 13px;
    }
.pdf-page{
      width: 715px;
      height: auto;
      padding: 10px;
      background-color: #fff;
}
.status{
  width: auto;
  height: auto;
}
.invoice-amount-pay-status{
  color: #df59f9;
}
.invHeading{
  text-transform: uppercase;
      padding-bottom: 10px;
}
.inv-from {
    font-size: 12px;
    font-weight: 100;
    color: #df59f9;
    padding-left: 40px;
    float: left;
}
.inv-to {
    font-size: 12px;
    font-weight: 100;
    float: right;
    padding-right: 40px;
    color: #df59f9;
}
.inv-logo{
      width: 70px;
    height: 70px;
}
.inv-name{
    text-transform: uppercase;
    font-size: 14px;
}
.inv-email{
  padding-bottom: 3px;
  color: #df59f9;
  font-weight: 400;
  font-size: 14px;
}

.inv-date{
  color: #df59f9;
  font-weight: 400;
  font-size: 12px;
}
.imageData{
  width:100%;
  height:auto;
}
.box-left{
  width:65%;
  height:auto;
  float:left;
}
.part1{
  width:60%;
  height:auto;
  float:left;
  text-align: left;
}
.image{
  width:40%;
  height:auto;
  float:left;
  text-align: center;
}
.data{
  width:60%;
  height:auto;
  float:right;
  text-align: left;
}

.row{
  width: 100%;
  height: auto;
}
.col-sm-12{
  margin-left: 15px;
  margin-right: 15px;
  height: auto;
  width: 100%;
}
.col-sm-6{
  margin-left: 15px;
  margin-right: 15px;
  height: auto;
  width: 50%;
}
.col-sm-4{
  margin-left: 15px;
  margin-right: 15px;
  height: auto;
  width: 25%;
}
.box-right{
  width:35%;
  height:auto;
  float:right;
}
.part2{
  width:40%;
  height:auto;
  float:right;
  text-align: center;
}

.item-box{
  width:100%;
  height:auto;
  text-align: left;
  padding-left: 30px;
}
.item-1{
  width:50%;
  height:auto;
  float:left;
}
.itemin{
  width:100%;
  height:auto;
}
.item-name{
  width:50%;
  height:auto;
  float:left;
}
.item-rate{
  width:50%;
  height:auto;
  float:right;
}

.item-2{
  width:50%;
  height:auto;
  float:right;
}
.itemrg{
  width:100%;
  height:auto;
}
.item-qty{
  width:50%;
  height:auto;
  float:left;
}
.item-total{
  width:50%;
  height:auto;
  float:right;
}
.box{
  width:100%;
  margin-top:25px;
  height:150px;
}
.partDiv{
  width:100%;
  height:auto;
}
.container{
   padding: 30px;
 }
.item-desc{
  text-align: left;
  padding-left: 30px;
  float: left;
  padding-top: 10px;
}
.description-text{
clear: both;
    text-align: left;
    padding-left: 30px;
}
.m-r-100{
  margin-right: 100px;
}
.amount-title{
    padding-right: 50px;
    font-size: 13px;
    padding-top: 15px;
}
.amt{
  padding-left: 30px;
    font-size: 13px;
}
.term{
  margin-left: 30px;
      text-align: left;
}
.status{
  width:  auto;
  height:  auto;
}
.bottom-box{
  width: 100%;
  height:  250px;
}
.bottom-box-left{
  width: 50%;
  height:  auto;
  float: left;
}
.bottom-box-right{
  width: 50%;
  height: auto;
  float: right;
}


    </style>
 </head>
<body>
  <center>
    <div class="pdf-page">
     <div class="status">
        <h5 align="center">Invoice ({{$inv->invoice_number}}) from {{$user->fname}} {{$user->lname}} ({{$companyData->name}})
          <span style="float: right;">
            @if($inv->status == "PAID-STRIPE")
      <div class="invoice-amount-pay-status">HURRAY! PAID IN FULL ON DATE {{ date('d/m/Y', strtotime($inv->due_date)) }}</div>
      @endif

      @if($inv->status == "DEPOSIT_PAID")
      <div class="invoice-amount-pay-status">DEPOSIT $ {{$inv->deposit_amount}} USD PAID ON {{ date('d/m/Y', strtotime($inv->due_date)) }}</div>
      @endif
          </span>
        </h5>
      </div>

      <hr>
    <div class="invHeading">
      <span class="inv-from">From INVOICE</span> <span class="inv-to">INVOICE TO</span>
    </div>

    <div class="box">
    <div class="box-left">
      <div class="partDiv">
        <div class="part1">
          <div class="imageData">
            <div class="image">
              <img src="{{asset('/images/avatar/'.$user->avatar)}}" class="inv-logo">
            </div>
            <div class="data">
              <div class="inv-name">{{$user->fname}} {{$user->lname}}</div>
              <div class="inv-email">{{$user->email}}</div>
                <div class="inv-address">{{$user->address}}</div>
                <div class="inv-state">{{$user->state}}</div>
                <div class="inv-city">{{$user->city}}</div>
                <div class="inv-country">{{$user->country}}</div>
            </div>
          </div>
          </div>
        <div class="part2">
          <div class="inv-date-title">ISSUE DATE</div>
            <div class="inv-date">{{ date('m/d/Y', strtotime($inv->issue_date)) }}</div>
            <div class="inv-date-title">DUE DATE</div>
            <div class="inv-date">{{ date('d/m/Y', strtotime($inv->due_date)) }}</div>
        </div>
      </div>
     

          
        </div>
                <div class="box-right">
                    <div class="imageData">
                      <div class="image">
                        <img src="{{asset('/company_logo/'.$companyData->logo)}}" class="inv-logo" style="right: 10px;">
                      </div>
                      <div class="data">
                        <div class="inv-name">{{$clientData->fname}} {{$clientData->lname}}</div>
                        <div class="inv-email">{{$clientData->email}}</div>
                          <div class="inv-address">{{$clientData->address}}</div>
                          <div class="inv-state">{{$clientData->state}}</div>
                          <div class="inv-city">{{$clientData->city}}</div>
                          <div class="inv-country">{{$clientData->country}}</div>
                      </div>
                    </div>        
                </div>
     </div>
                             
 <hr><br>

 @foreach($invItem as $index => $item)
             <div class="item-box">
             <div class="item-1">
             <div class="itemin">
             <div class="item-name">
       <strong>Item Name</strong>
             </div>
             <div class="item-rate">
       <strong>Rate</strong>
             </div>
             </div>
             </div>
             <div class="item-2">
             <div class="itemrg">
             <div class="item-qty">
       <strong>Quantity</strong>
             </div>
             <div class="item-total">
       <strong>Line Total</strong>
             </div>
       </div>
             </div>
             </div>
             
             <div class="item-box">
             <div class="item-1">
             <div class="itemin">
             <div class="item-name">
       {{$item->item_name}}
             </div>
             <div class="item-rate">
       {{$item->rate}}
             </div>
             </div>
             </div>
             <div class="item-2">
             <div class="itemrg">
             <div class="item-qty">
       <span style="margin-left: 15px;">{{$item->qty}}</span>
             </div>
             <div class="item-total">
       $ {{$item->total}}
             </div>
       </div>
             </div>
             </div>
        
       <div class="item-desc">
       <strong>Description</strong>
       </div>
       <div class="description-text">
       {{$item->item_description}}
       </div>
       <br>
            @endforeach
      <div id="dynamic_field"></div>
                    <hr>

          <div class="bottom-box">
           <div class="bottom-box-left">
             <div class="term">
              <strong>Terms:-</strong> 
              <span style="margin-left: 13px;">{{$inv->terms}}</span>
             </div>
           </div>

           <div class="bottom-box-right">
             <div class="amount-title" align="right">Subtotal
          <span class="amt">
            $ {{$inv->sub_total}}
          </span>
        </div>

        <div class="amount-title" align="right">Discount
          <span class="amt">
            $ {{$inv->discount}}
          </span>
        </div>

        <div class="amount-title" align="right">Tax
          <span class="amt">
            $ {{$inv->tax_rate}}
          </span>
        </div>

        <div class="amount-title" align="right">Deposit Amount
          <span class="amt">
            $ {{$inv->deposit_amount}}
          </span>
        </div>

        <hr width="50%" align="right">

        <div class="amount-title" align="right">Amount Paid
          <span class="amt">
            @if($inv->status =="DEPOSIT_PAID")
                    $ {{$inv->deposit_amount}}
                @elseif($inv->status =="PAID-STRIPE")
                    $ {{$inv->net_amount}}
                @else
                    $ 0
                @endif
          </span>
        </div>

        <div class="amount-title" align="right">Amount Due($USD)
          <span class="amt">
            $ {{$inv->due_amount}}
          </span>
        </div> 
           </div>
         </div>  



   </div>
  </center>
                                  
</body>
</html>







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
    padding: 5%;
   }
   .t-center{
    text-align: center;
   }
   .invoice-amount-pay-status{
  color: #df59f9;
  } 
  .table-w{
    width: 100%;
    height: auto;
    margin-top: 10px;
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
    width: 20%;
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
    width: 10%;
    height: auto;
  }
  .cal-table-w{
    width: 100%;
    height: auto;
    margin-top: 10px;
  }
  .td-term{
  width: 70%;
  height: auto;
  display: block !important;
}
.td-cal-title{
  width: 15%;
  height: auto;
  text-align: left;
}
.td-amount{
  width: 15%;
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
    color: #df59f9;
    margin-left: 35px;
  }
  .inv-to{
    float: right;
    padding-top: 10px;
    font-weight: 100;
    font-size: 14px;
    color: #df59f9;
    margin-right: 180px;
  }
  .inv-date{
  color: #df59f9;
  font-weight: 400;
  font-size: 12px;
  }
  .inv-logo{
      width: 90px;
    height: 90px;
  }
  .inv-name{
    text-transform: uppercase;
    font-size: 22px;
     padding-left: 10px;
}
.copmany-name{
  color: #df59f9;
    font-size: 15px;
    font-weight: 100;
    padding-left: 10px;
}
.inv-email{
  padding-bottom: 3px;
  color: #df59f9;
  font-weight: 400;
  font-size: 14px;
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
  border-bottom: 2px solid #000;
}
.item-tr{
  border-bottom: 2px solid #000;
  display: block !important;
  padding-bottom: 20px;
}
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 t-center">
           Invoice ({{$inv->invoice_number}}) from {{$user->fname}} {{$user->lname}} ({{$companyData->name}})
       </div> 
    </div>

    <div class="row">
        <div class="col-12 t-center">
           @if($inv->status == "PAID-STRIPE")
            <div class="invoice-amount-pay-status">HURRAY! PAID IN FULL ON DATE {{ date('d/m/Y', strtotime($inv->due_date)) }}</div>
            @endif

            @if($inv->status == "DEPOSIT_PAID")
            <div class="invoice-amount-pay-status">DEPOSIT $ {{$inv->deposit_amount}} USD PAID ON {{ date('d/m/Y', strtotime($inv->due_date)) }}</div>
            @endif
       </div> 
    </div>

     <div class="row">
           <div class="col-6">
             <span class="inv-from">From INVOICE</span>
           </div> 
           <div class="col-6">
               <span class="inv-to">INVOICE TO</span>
           </div>
     </div>

     <table class="table-w">
      <tr class="tr-border-bottom">
        <td class="td-1 t-l">
          <img src="{{asset('/images/avatar/'.$user->avatar)}}" class="inv-logo">
        </td>
        <td class="td-3">
          <div class="inv-name">{{$user->fname}} {{$user->lname}}</div>
          <div class="copmany-name">{{$user->company_name}}</div>
              <div class="inv-email">{{$user->email}}</div>
                <div class="inv-address">{{$user->address}}</div>
                <div class="inv-state">{{$user->state}}</div>
                <div class="inv-city">{{$user->city}}</div>
                <div class="inv-country">{{$user->country}}</div>
        </td>
        <td class="td-2 t-l">
          <div class="inv-date-title">ISSUE DATE</div>
            <div class="inv-date">{{$inv->created_at->format('d/m/Y')}}</div>
            <div class="inv-date-title">DUE DATE</div>
            <div class="inv-date">{{ date('d/m/Y', strtotime($inv->due_date)) }}</div>
        </td>
        <td class="td-1 t-r">
          <img src="{{asset('/company_logo/'.$companyData->logo)}}" class="inv-logo">
        </td>
        <td class="td-3">
          <div class="inv-name">{{$clientData->fname}} {{$clientData->lname}}</div>
          <div class="copmany-name">{{$companyData->name}}</div>
          <div class="inv-email">{{$clientData->email}}</div>
          <div class="inv-address">{{$clientData->address}}</div>
          <div class="inv-state">{{$clientData->state}}</div>
          <div class="inv-city">{{$clientData->city}}</div>
          <div class="inv-country">{{$clientData->country}}</div>
        </td>
      </tr>
    </table>

<span style="page-break-after:always;"></span>
    <table class="item-table-w">
       @foreach($invItem as $index => $item)
      <tr class="item-tr">
        <td class="td-item-name">
          <strong>Item Name</strong><br>
          {{$item->item_name}}
        </td>
        <td class="td-item-desc">
          <strong>Description</strong><br>
          {!! nl2br($item->item_description) !!}
        </td>
        <td class="td-item-rate">
          <strong>Rate</strong><br>
          {{$item->rate}}
        </td>
        <td class="td-item-qty">
          <strong>Quantity</strong><br>
          <span style="margin-left: 15px;">{{$item->qty}}</span>
        </td>
        <td class="td-item-total">
          <strong>Line Total</strong><br>
          ${{$item->total}}
        </td>
      </tr>
      @endforeach
    </table>
<span style="page-break-after:always;"></span>
    <table class="cal-table-w">
      <tr>
        <td class="td-term">
          <strong>Terms:-</strong>
          <span style="margin-left: 13px;">{{$inv->terms}}</span>
        </td>
        <td class="td-cal-title">
          Subtotal <br>
          Discount <br>
          Tax <br>
          Deposit Amount <br>
          <hr>
          Total Amount <br>
          Amount Paid <br>
          Amount Due <br>
        </td>
        <td class="td-amount">
          ${{$inv->sub_total}} <br>
          ${{$inv->discount}} <br>
          ${{$inv->tax_rate}} <br>
          ${{$inv->deposit_amount}}<br>
          <hr>
          ${{$inv->net_amount}} <br>
          ${{$inv->net_amount - $inv->due_amount}} <br>
          ${{$inv->due_amount}} <br>
        </td>
      </tr>
     </table>
     <span style="page-break-after:always;"></span>
</div>
</body>
</html>
