<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>
<meta name="description" content="MapleBooks">
<style>
body{
  margin-left:100px;
  margin-right:100px;
  margin-top: 100px;
  margin-bottom: 100px;
}
.inv-heading-text{
  font-size: 20px;
    font-weight: 400;
    /* text-align: center; */
    padding: 20px 40px 20px 100px;
}
.amount-text{
  font-size: 20px;
  font-weight: 400;
  color: #E565F3;
}
.inv-text{
  font-size: 18px;
  font-weight: 200;
  text-decoration: none !important;
}
hr{
  color: #9192EC;
  border: 1px solid;
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
    <hr>
    <br>
    <div class="inv-text">Hi {{$userData->fname}} {{$userData->lname}},</div>
    <p class="inv-heading-text">{{$clientData->fname}} {{$clientData->lname}} has paid $ <span class="amount-text">{{$pay}} USD</span> for Invoice {{$invData->invoice_number}}.</p> 
    <center>
      <a href="{{env('APP_URL')}}/view-and-pay-invoice/{{$invData->id}}/{{$invData->invoice_number_token}}"><input type="button" name="" class="pay-btn" value="SEE INVOICE">
    </center>

    <br>
    <br>
    <div class="inv-text">
      Thanks <br>
      Team Mapleebooks.
    </div>
</div>
    <br>
    <hr>                      

</body>
</html>