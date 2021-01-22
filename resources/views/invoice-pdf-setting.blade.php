@extends('layouts.app')
@section('content')  
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
<div class="content">
	<div class="row mobile-column-reverse">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="title">Invoice PDF Setting</h5>
				</div>
				<div class="card-body">
					<form action="/invoice-pdf-setting/change" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<div class="label-title">Company Logo</div>
									<input type="checkbox" name="logo" @if(isset($userInvoiceSetting)) @if($userInvoiceSetting->logo ==1) checked @endif @endif data-toggle="toggle" data-onstyle="success">
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<div class="label-title">Company Logo Position <span style="font-size: 10px;">(only one button on/off)</span></div>
									<input type="checkbox" name="logo_left" @if(isset($userInvoiceSetting)) @if($userInvoiceSetting->logo_left ==1) checked @endif @endif data-toggle="toggle" data-onstyle="primary" data-width="85" data-on="Left" data-off="Left">
									<input type="checkbox" name="logo_center" @if(isset($userInvoiceSetting)) @if($userInvoiceSetting->logo_center ==1) checked @endif @endif data-toggle="toggle" data-onstyle="warning" data-width="85" data-on="Center" data-off="Center">
									<input type="checkbox" name="logo_right" @if(isset($userInvoiceSetting)) @if($userInvoiceSetting->logo_right ==1) checked @endif @endif data-toggle="toggle" data-onstyle="info" data-width="85" data-on="Right" data-off="Right">
									<input type="checkbox" name="logo_bg" @if(isset($userInvoiceSetting)) @if($userInvoiceSetting->logo_bg ==1) checked @endif @endif data-toggle="toggle" data-onstyle="dark" data-width="85" data-on="Back" data-off="Back">
								</div>
							</div>
						</div>
						<div class="row m-t-20">
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_due_days}}@endif" name="invoice_due_days" id="invoice_due_days" class="form-control">
									<label>Invoice Due Days</label>
                  <span style="font-size: 10px;">(example 1 to 365)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->logo_hight}}@endif" name="logo_hight" id="logo_hight" class="form-control">
									<label>Logo Hight</label>
                  <span style="font-size: 10px;">(example 50 to 200)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->logo_width}}@endif" name="logo_width" id="logo_width" class="form-control">
									<label>Logo Width</label>
                  <span style="font-size: 10px;">(example 50 to 200)</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->logo_opacity}}@endif" name="logo_opacity" id="logo_opacity" class="form-control">
									<label>Logo Opacity</label>
                  <span style="font-size: 10px;">(example 0.1 to 1)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_font_size}}@endif" name="invoice_font_size" id="invoice_font_size" class="form-control">
									<label>Invoice Font Size</label>
                  <span style="font-size: 10px;">(example 10 to 20)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_font_weight}}@endif" name="invoice_font_weight" id="invoice_font_weight" class="form-control">
									<label>Invoice Font Weight</label>
                  <span style="font-size: 10px;">(example 100 to 800)</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_font_size_1}}@endif" name="invoice_font_size_1" id="invoice_font_size_1" class="form-control">
									<label>Invoice Font Size_1</label>
                  <span style="font-size: 10px;">(example 10 to 20)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_font_size_2}}@endif" name="invoice_font_size_2" id="invoice_font_size_2" class="form-control">
									<label>Invoice Font Size_2</label>
                  <span style="font-size: 10px;">(example 10 to 25)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_font_size_3}}@endif" name="invoice_font_size_3" id="invoice_font_size_3" class="form-control">
									<label>Invoice Font Size_3</label>
                  <span style="font-size: 10px;">(example 10 to 30)</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_font_weight_1}}@endif" name="invoice_font_weight_1" id="invoice_font_weight_1" class="form-control">
									<label>Invoice Font Weight_1</label>
                  <span style="font-size: 10px;">(example 100 to 800)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_font_weight_2}}@endif" name="invoice_font_weight_2" id="invoice_font_weight_2" class="form-control">
									<label>Invoice Font Weight_2</label>
                  <span style="font-size: 10px;">(example 100 to 800)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_heading_title_color}}@endif" name="invoice_heading_title_color" id="invoice_heading_title_color" class="form-control">
									<label>Invoice Heading Title Color</label>
                  <span style="font-size: 10px;">(example color code #ffffff)</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_heading_date_color}}@endif" name="invoice_heading_date_color" id="invoice_heading_date_color" class="form-control">
									<label>Invoice Heading Date Color</label>
                  <span style="font-size: 10px;">(example color code #ffffff)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_heading_email_color}}@endif" name="invoice_heading_email_color" id="invoice_heading_email_color" class="form-control">
									<label>Invoice Heading Email Color</label>
                  <span style="font-size: 10px;">(example color code #ffffff)</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" value="@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_heading_gst_color}}@endif" name="invoice_heading_gst_color" id="invoice_heading_gst_color" class="form-control">
									<label>Invoice Heading GST Color</label>
                  <span style="font-size: 10px;">(example color code #ffffff)</span>
								</div>
							</div>
						</div>
						<div class="row">
		                    <div class="col-md-12">
		                      <div class="form-group">
		                        <textarea name="invoice_terms" id="invoice_terms" rows="4" cols="80" class="form-control">@if(isset($userInvoiceSetting)){{$userInvoiceSetting->invoice_terms}}@endif</textarea>
		                        <label>Terms</label>
		                      </div>
		                    </div>
		                </div>
		                  <div class="row">
		                    <div class="col-md-12">
		                      <div class="btn-group" role="group" aria-label="invoice pdf action button">
				                  <button type="submit" class="btn btn-success pay-btn">Save</button>
				                  <button type="button" class="btn btn-danger invoice-pdf-setting-reset">Reset</button>
				                </div>
		                    </div>
		                  </div>
					</form>
				</div>
			</div>
		</div>
		<!-- end col -->
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h5 class="title">Invoice PDF View</h5>
				</div>
				<div class="card-body">
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
					<section>
						@if($invoiceLogoEnable == 1)
              @if($invoiceLogoBg == 1)
                <img src="{{asset('/public/images/companies-logo/'.auth()->user()->avatar)}}" class="logo-bg">
              @endif
            @endif
            <div class="row">
                <div class="col-12 invoice-pdf-setting-t-left">
                   Invoice (INV00001)
               </div> 
            </div>
            <br>
            <div class="row">
                <div class="col-12 invoice-pdf-setting-t-center">
                    <div class="invoice-pdf-setting-invoice-amount-pay-status">HURRAY! PAID IN FULL ON DATE 15/01/2021</div>
               </div> 
            </div>
            <div class="company-info">
              @if($invoiceLogoEnable == 1)
                @if($invoiceLogoBg == 0)
                  <img src="{{asset('/public/images/companies-logo/'.auth()->user()->avatar)}}" class="inv-logo @if($invoiceLogoPosL ==1) logo-left @endif @if($invoiceLogoPosC ==1) logo-center @endif @if($invoiceLogoPosR ==1) logo-right @endif" style="display: none;">
                @endif
              @endif
              <div class="row">
                <div class="col-12 invoice-pdf-setting-user-company-name invoice-pdf-setting-fs-3">Bill Book</div>
              </div>
              <div class="row">
                <div class="col-12 invoice-pdf-setting-company-address f-w-1">sector-17, mohali, Punjab, India</div>
              </div>
              <div class="row">
                <div class="col-12 invoice-pdf-setting-title-txt invoice-pdf-setting-fs-1 invoice-pdf-setting-f-w-1">E-Mail :<span class="inv-email invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-1">hello@billbook.com</span></div>
              </div>
              <div class="row">
                <div class="col-12 invoice-pdf-setting-title-txt invoice-pdf-setting-fs-1 invoice-pdf-setting-f-w-1">GST/TIN No. <span class="invoice-pdf-setting-GSTIN-number invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-1">F0GH99WTHK66L</span></div>
              </div>
            </div>

            <hr>
                <table class="invoice-pdf-setting-table-w">
                  <tr class="invoice-pdf-setting-tr-border-bottom">
                    <td class="invoice-pdf-setting-td-15">
                      <div class="invoice-pdf-setting-pad-35">Invoice #</div>
                      <div class="invoice-pdf-setting-pad-35">Client #</div>
                      <div class="invoice-pdf-setting-pad-35">Address #</div>
                      <div class="invoice-pdf-setting-pad-35">E-Mail #</div>
                    </td>
                    <td class="invoice-pdf-setting-td-40">
                      <div class="">INV00001</div>
                      <div class="">Johan Doe</div>
                      <div class="">11, CA, Calfornia, USA</div>
                      <div class="invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-1">john@email.com</div>
                    </td>
                    <td class="invoice-pdf-setting-td-20">
                      <div class="invoice-pdf-setting-pad-35">Issue Date #</div>
                      <div class="invoice-pdf-setting-pad-35">Due Date #</div>
                      <div class="invoice-pdf-setting-pad-35">Mobile #</div>
                      <div class="invoice-pdf-setting-pad-35">Status #</div>
                    </td>
                    <td class="invoice-pdf-setting-td-25">
                      <div class="invoice-pdf-setting-inv-date invoice-pdf-setting-f-w-1">{{ date('m/d/Y') }}</div>
                      <div class="invoice-pdf-setting-inv-date invoice-pdf-setting-f-w-1">{{ date('m/d/Y') }}</div>
                      <div class="invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-1">+12585658</div>
                      <div class="">PAID</div>
                    </td>
                  </tr>
                </table>
                <hr>
                <table class="invoice-pdf-setting-item-table-w">
                <tr>
                  <td class="invoice-pdf-setting-td-item-name invoice-pdf-setting-bill-heading-title invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-2">
                    Item Name
                  </td>
                  <td class="invoice-pdf-setting-td-item-desc invoice-pdf-setting-bill-heading-title invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-2">
                     Description
                  </td>
                  <td class="invoice-pdf-setting-td-item-rate invoice-pdf-setting-bill-heading-title invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-2">
                    Rate
                  </td>
                  <td class="invoice-pdf-setting-td-item-qty invoice-pdf-setting-bill-heading-title invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-2">
                    Quantity
                  </td>
                  <td class="invoice-pdf-setting-td-item-total invoice-pdf-setting-bill-heading-title invoice-pdf-setting-fs-2 invoice-pdf-setting-f-w-2">
                    Total
                  </td>
                </tr>
                <tr class="invoice-pdf-setting-item-tr">
                  <td class="invoice-pdf-setting-td-item-name">
                    Books
                  </td>
                  <td class="invoice-pdf-setting-td-item-desc" style="padding-bottom: 10px;">
                    all books on sale rate
                  </td>
                  <td class="invoice-pdf-setting-td-item-rate">   
                    50
                  </td>
                  <td class="invoice-pdf-setting-td-item-qty">
                    <span style="margin-left: 15px; width: 100%; height: auto;">5</span>
                  </td>
                  <td class="invoice-pdf-setting-td-item-total">
                    Rs.2500
                  </td>
                </tr>
                <tr class="invoice-pdf-setting-item-tr">
                  <td class="invoice-pdf-setting-td-item-name">
                    Soap
                  </td>
                  <td class="invoice-pdf-setting-td-item-desc" style="padding-bottom: 10px;">
                    bath soap
                  </td>
                  <td class="invoice-pdf-setting-td-item-rate">   
                    80
                  </td>
                  <td class="invoice-pdf-setting-td-item-qty">
                    <span style="margin-left: 15px; width: 100%; height: auto;">2</span>
                  </td>
                  <td class="invoice-pdf-setting-td-item-total">
                    Rs.160
                  </td>
                </tr>
                <tr class="invoice-pdf-setting-item-tr">
                  <td class="invoice-pdf-setting-td-item-name">
                    Cloth
                  </td>
                  <td class="invoice-pdf-setting-td-item-desc" style="padding-bottom: 10px;">
                    all winter cloth
                  </td>
                  <td class="invoice-pdf-setting-td-item-rate">   
                    250
                  </td>
                  <td class="invoice-pdf-setting-td-item-qty">
                    <span style="margin-left: 15px; width: 100%; height: auto;">3</span>
                  </td>
                  <td class="invoice-pdf-setting-td-item-total">
                    Rs.750
                  </td>
                </tr>
              </table>
               <hr>
                   <div class="invoice-pdf-setting-bottom-box">
                    <div class="invoice-pdf-setting-bottom-box-left">
                      <strong>Terms:-</strong>
                      <br>
                        <span style="margin-left: 13px;">{!! nl2br($userInvoiceSetting->terms) !!}</span>
                    </div>
                    <div class="invoice-pdf-setting-bottom-box-right">
                      <div class="col-12">
                        <div class="invoice-pdf-setting-col-6-l">
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Payment Method</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Subtotal</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Discount</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Tax</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1"> Deposit Amount</div>
                          <hr>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Total Amount</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Amount Paid</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Amount Due</div>
                        </div>

                        <div class="invoice-pdf-setting-col-6-r">
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">CASH</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Rs.3410</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Rs.0:00</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Rs.0:00</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Rs.0:00</div>
                          <hr>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Rs.3410</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Rs.0:00</div>
                          <div class="invoice-pdf-setting-amount-title invoice-pdf-setting-fs-1">Rs.3410</div>
                        </div>
                      </div>
                          
                        </div>
                    </div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end content section -->
<style>
.label-title {
    padding: 3px 0px;
    font-size: 16px;
}
.card .toggle-group label {
    position: absolute;
    top: 0;
    left: 0;
    padding-right: unset;
    padding-left: unset;
    font-weight: unset;
    background: unset;
    -webkit-transform: unset;
    transform: unset;
    color: unset;
    cursor: unset;
    -webkit-transition: unset;
    transition: unset;
    transition: unset;
    transition: unset;
    -webkit-transform-origin: unset;
    transform-origin: unset;
    max-width: unset;
    white-space: unset;
    overflow: unset;
    text-overflow: unset;
    margin-bottom: unset;
}
.card .toggle-group .toggle-on {
    position: absolute !important;
    top: 0 !important;
    bottom: 0 !important;
    left: 0 !important;
    right: 50% !important;
    margin: 0 !important;
    border: 0 !important;
    border-radius: 0 !important;
}
.card .toggle-group .toggle-off {
    position: absolute !important;
    top: 0 !important;
    bottom: 0 !important;
    left: 50% !important;
    right: 0 !important;
    margin: 0 !important;
    border: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}


  section{
    font-size: <?php echo $invoiceFontSize ?>px;
    font-weight: <?php echo $invoiceFontWeight ?>;
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
  .invoice-pdf-setting-fs-1{
    font-size: <?php echo $invoiceFontSizeS ?>px;
  }
  .invoice-pdf-setting-fs-2{
    font-size: <?php echo $invoiceFontSizeM ?>px;
  }
  .invoice-pdf-setting-fs-3{
    font-size: <?php echo $invoiceFontSizeL ?>px;
  }
  .invoice-pdf-setting-f-w-1{
    font-weight: <?php echo $invoiceFontWeightS ?>;
  }
  .invoice-pdf-setting-f-w-2{
    font-weight: <?php echo $invoiceFontWeightM ?>;
  }
   .invoice-pdf-setting-container{
    /*background-image: url("{{asset('/images/avatar/')}}");*/
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
   .invoice-pdf-setting-t-center{
    text-align: center;
   }
   .invoice-pdf-setting-t-left{
    text-align: left;
   }
   .invoice-pdf-setting-invoice-amount-pay-status{
    color: #e91e63;
    } 
  .invoice-pdf-setting-table-w{
    width: 100%;
    height: auto;
    margin-top:10px;
  }
  .invoice-pdf-setting-td-15{
    width: 15%;
    height: auto;
  }
  .invoice-pdf-setting-td-20{
    width: 20%;
    height: auto;
  }
  .invoice-pdf-setting-td-25{
    width: 25%;
    height: auto;
  }
  .invoice-pdf-setting-td-40{
    width: 40%;
    height: auto;
  }
  .invoice-pdf-setting-td-1{
    width: 10%;
    height: auto;
  }
  .invoice-pdf-setting-td-2{
    width: 20%;
    height: auto;
  }
  .invoice-pdf-setting-td-3{
    width: 30%;
    height: auto;
  }
  .invoice-pdf-setting-bill-heading-title{
    color: <?php echo $invoiceTitleColor ?>;
  }
  .invoice-pdf-setting-item-table-w{
    width: 100%;
    height: auto;
    margin-top: 20px;
    margin-bottom: 20px;
  }
  .invoice-pdf-setting-td-item-name{
    width: 15%;
    height: auto;
  }
  .invoice-pdf-setting-td-item-desc{
    width: 50%;
    height: auto;
  }
  .invoice-pdf-setting-td-item-rate{
    width: 10%;
    height: auto;
  }
  .invoice-pdf-setting-td-item-qty{
    width: 10%;
    height: auto;
  }
  .invoice-pdf-setting-td-item-total{
    width: 15%;
    height: auto;
  }
  .invoice-pdf-setting-cal-table-w{
    width: 100%;
    height: auto;
    margin-top: 10px;
  }
  .invoice-pdf-setting-td-term{
  width: 60%;
  height: auto;
  display: block !important;
}
.invoice-pdf-setting-td-cal-title{
  width: 20%;
  height: auto;
  text-align: left;
}
.invoice-pdf-setting-td-amount{
  width: 20%;
  height: auto;
  text-align: left;
}
  .invoice-pdf-setting-t-l{
    text-align: left;
  }
  .invoice-pdf-setting-t-c{
    text-align: center;
  }
  .invoice-pdf-setting-t-r{
    text-align: right;
  }
  .invoice-pdf-setting-inv-date{
  color: <?php echo $invoiceDateColor ?>;
  }
.invoice-pdf-setting-inv-email{
  padding-bottom: 3px;
  color: <?php echo $invoiceEmailColor ?>;
   padding-left: 10px;
}
.invoice-pdf-setting-tr-border-bottom{
vertical-align: text-top !important;
padding-top: 10px;
}
.invoice-pdf-setting-item-tr{
  width: 100% !important;
  border-top: 1px solid rgba(0,0,0,.1) !important;
  vertical-align: middle !important;
  padding-bottom: 10px;
  padding-top: 10px;
}
.invoice-pdf-setting-bottom-box{
  width: 100%;
  height:  280px;
}
.invoice-pdf-setting-bottom-box-left{
  width: 60%;
  height:  auto;
  float: left;
}
.invoice-pdf-setting-bottom-box-right{
  width: 40%;
  height: auto;
  float: right;
}
.invoice-pdf-setting-amount-title{
  /*position: relative;*/
  text-align: left;
}
.invoice-pdf-setting-col-12{
  width: 100%;
  height: auto;
}
.invoice-pdf-setting-col-6-l{
  width: 50%;
  height: auto;
  float: left;
  margin-left: 10px;
}
.invoice-pdf-setting-col-6-r{
  width: 50%;
  height: auto;
  float: revert;
  margin-left: 150px;
}
.invoice-pdf-setting-GSTIN-number{
    color: <?php echo $invoiceGstColor ?>;
}
.invoice-pdf-setting-user-company-name{
    text-align: center;
    text-transform: uppercase;
}
.invoice-pdf-setting-company-address{
  text-align: center;
}
.invoice-pdf-setting-title-txt{
  text-align: center;
}
.invoice-pdf-setting-pad-35{
  padding-left: 35px;
}
</style>
<script>
  $(document).ready(function(){
  	$('.invoice-pdf-setting-reset').on('click', function(){
      window.location.href = '/invoice-pdf-setting/reset';
   });
  });
</script>
@endsection