<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>
<meta name="description" content="Bill Pay">
<style>
body{
  margin-left:100px;
  margin-right:100px;
  margin-top: 100px;
  margin-bottom: 100px;
}
.inv-heading-text{
  font-size: 20px;
    font-weight: 200;
    /* text-align: center; */
    padding: 20px 40px 20px 100px;
}
.inv-text{
  font-size: 20px;
  font-weight: 200;
}
.pay-btn{
    background-color: #E565F3;
    color: #FFFFFF;
    text-transform: uppercase;
    border-radius: 30px;
    height: 40px;
    width: 200px;
    font-size: 14px;
    border: 2px solid #E565F3;
}
.pay-btn:hover{
    background-color: #FFFFFF;
    color: #E565F3;
    border: 2px solid #E565F3;
    cursor: pointer;
}
button:focus {
    box-shadow: none !important;
    outline: none !important;
}
</style>
</head>
<body>
<div class="container">
<div>Hi {{$inv->client->fname}} {{$inv->client->lname}}</div>
<br>

<p class="inv-heading-text">{{$inv->user->fname}} {{$inv->user->lname}}  @if(!empty($inv->user->company_name))({{$inv->user->company_name}}) @endif <span class="inv-text">sent you an invoice ({{$inv->invoice_number}}) for</span>@if($inv->status =="CASH") &#8360; 0 @else @if($inv->status =="OVERDUE" && $inv->net_amount != $inv->due_amount) &#8360; {{$inv->due_amount}} @elseif((!empty($inv->deposit_amount))&& $inv->status !="DEPOSIT_PAID") &#8360; {{$inv->deposit_amount}} @else &#8360; {{$inv->due_amount}} @endif @endif <span class="inv-text">that's due on</span>  {{ date('m/d/Y', strtotime($inv->due_date)) }}.</p>
<center>
  <a href="{{env('APP_URL')}}/view-and-pay-invoice/{{$inv->id}}/{{$inv->invoice_number_token}}"><input type="button" name="" class="pay-btn" value="SEE INVOICE AND PAY"></a>
</center>

<br>
<br>
<div class="inv-text">
      Thanks <br>
      Team Mapleebooks.
    </div>
</div>
                          

</body>
</html>