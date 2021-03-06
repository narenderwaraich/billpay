@extends('layouts.app')
@section('content')  
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
  <div class="content">
        <div class="row mobile-column-reverse">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Profile</h5>
              </div>
              <div class="card-body">
                <form action="/user-update/{{ auth()->user()->id }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="avatar" id="getFile" value="{{ auth()->user()->avatar }}" accept="image/*" class="form-control input-border" style="display: none;">
                 <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" value="{{auth()->user()->company_name}}" name="company_name" id="firm_name" class="form-control" required>
                        <label>Company Name</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" value="{{auth()->user()->fname}}" name="fname" id="fname" class="form-control" required>
                        <label>First Name</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" name="lname" value="{{auth()->user()->lname}}" id="lname" class="form-control" required>
                        <label>Last Name</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input name="phone_no" type="text" id="phone" value="{{ auth()->user()->phone_no }}" class="form-control" required>
                        <label>Mobile</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{auth()->user()->email}}" required>
                        <label>Email</label>
                        @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <select  name="country" id="country" class="form-control" required>
                          <option value="">Select Country</option>
                         @foreach($country_data as $country)
                          <option value="{{ $country->name }}" {{ (auth()->user()->country == $country->name ? "selected":"") }}>{{$country->name}}</option>
                         @endforeach
                       </select>
                        <label>Country</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <select name="state" id="state" class="form-control" required>
                          <option value="">Select State</option>
                          @foreach($state_data as $state)
                            <option value="{{$state->name}}" {{ (auth()->user()->state == $state->name ? "selected":"") }}>{{$state->name}}</option>
                          @endforeach
                        </select>
                        <label>State</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <select name="city" id="city" class="form-control" required>
                          <option value="">Select City</option>
                          @foreach($city_data as $city)
                            <option value="{{$city->name}}" {{ (auth()->user()->city == $city->name ? "selected":"") }}>{{$state->name}}</option>
                          @endforeach
                        </select>
                        <label>City</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="number" name="zipcode" id="zip" value="{{auth()->user()->zipcode}}" class="form-control" required>
                        <label>Postal Code</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" value="{{auth()->user()->gstin_number}}" name="gstin_number" id="gstin_number" class="form-control">
                        <label>CIN/GSTIN</label>
                      </div>
                    </div>
                  </div>
<!--                   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input name="paytm_id" type="password" id="paytm-id" value="{{ auth()->user()->paytm_id }}" class="form-control">
                        <label>Paytm Id</label>
                        <span toggle="#paytm-id" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="password" class="form-control" name="paytm_key" id="paytm-key" value="{{auth()->user()->paytm_key}}">
                        <label>Paytm Key</label>
                        <span toggle="#paytm-key" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                      </div>
                    </div>
                  </div> -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea name="address" id="address" rows="4" cols="80" class="form-control" placeholder="Address" required>{{ auth()->user()->address }}</textarea>
                        <label>Address</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-success">Update</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- end col -->
          <div class="col-lg-4">
                        <div class="card card-user">
              <div class="image">
                <img src="/public/images/bg.jpg" alt="">
              </div>
              <div class="card-body">
                <div class="author">
                  @if(!empty(Auth::user()->avatar))
                   <img src="/public/images/companies-logo/{{Auth::user()->avatar}}" id="" class="avatar border-gray show-user-logo profile-img-tag">
                  @else
                  <div class="avatar border-gray user-profile-logo" id="userImage">
                  </div>
                  <img src="" id="showUpLog" class="avatar border-gray show-user-logo profile-img-tag" style="display: none;">
                    <script type="text/javascript">
                        $(document).ready(function(){
                        var dot = '.';
                        var intials = $('#firstName').text().charAt(0) + dot + $('#lastName').text().charAt(0);
                        var logoImage = $('#userImage').text(intials);
                      });
                    </script>
                  @endif
                  <i class="fa fa-camera img-change-btn-icon" id="selectImage"></i>
                    <h5 class="title"><span id="companies_name"></span></h5>
                  <hr class="hr-color">
                  <div class="client-data" id="client_name">Name :<span id="first_name"></span> <span id="last_name"></span></div>
                  <div class="client-data" id="client_email">Email : <span id="client_email_data"></span></div>
                  <div class="client-data" id="client_phone">Phone : <span id="client_phone_data"></span></div>
                  <div class="client-data" id="client_country">Country : <span id="client_country_data"></span></div>
                  <div class="client-data" id="client_state">State : <span id="client_state_data"></span></div>
                  <div class="client-data" id="client_city">City : <span id="client_city_data"></span></div>
                  <div class="client-data" id="client_zip">ZipCode : <span id="client_zip_data"></span></div>
                  <div class="client-data" id="client_address">Address : <span id="client_address_data"></span></div>
                  <br>
                  <h6 class="title" style="color: #e91e63;text-transform: uppercase;">Invoice Plan</h6>
                  <hr class="hr-color">
                  <div class="client-data">Name : <span>{{$plan->name}}</span></div>
                  <div class="client-data">Status : @if($userPlan->is_activated)<span style="color: #28a745;font-weight: 800;">Active</span> @else <span style="color: #e91e63;font-weight: 800;">Inactive</span> @endif</div>
                  <div class="client-data">Total Invoices : <span>{{$userPlan->get_invoice}}</span></div>
                  <div class="client-data">Left Invoices : <span>{{$userPlan->get_invoice - $totalInvoice}}</span></div>
                  <div class="client-data">Plan Exp : <span>{{ date('m/d/Y', strtotime($userPlan->expire_date)) }}</span></div>
                  <div class="client-data">Invoice PDF Custom Setting <a href="/invoice-pdf-setting">click here..</a></div>
                  <br>
                  <a href="/invoice/plans"><button type="button" class="btn btn-info btn-sm">Change Plan</button></a>
                </div>
              </div>
              
              <div class="button-container">

              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
      </div>
      <!-- end content section -->
<span id="firstName" style="display: none;">{{ auth()->user()->fname }}</span>
<span id="lastName" style="display: none;">{{ auth()->user()->lname }}</span>
<style>
  .client-data{
    display: block;
  }
</style>
<script>
    $(document).ready(function(){
    $('#selectImage').on('click', function() {
      $("#getFile").click();
    });
  
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('.profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#getFile").change(function(){
      $("#showUpLog").show();
      $("#userImage").hide();
        readURL(this);
    });
    });


    $('#country').change(function(){
    var countryName = $(this).val();    
    if(countryName){
        $.ajax({
           type:"GET",
           url:"{{url('get-state-list')}}?country_id="+countryName,
           success:function(res){               
            if(res){
                $("#state").empty();
                $("#state").append('<option>Select State</option>');
                $.each(res,function(key,value){
                    $("#state").append('<option value="'+value+'">'+value+'</option>');
                });
           
            }else{
               $("#state").empty();
            }
           }
        });
    }else{
        $("#state").empty();
        //$("#city").empty();
    }      
   });
    $('#state').on('change',function(){
    var stateName = $(this).val();    
    if(stateName){
        $.ajax({
           type:"GET",
           url:"{{url('get-city-list')}}?state_id="+stateName,
           success:function(res){               
            if(res){
                $("#city").empty();
                $.each(res,function(key,value){
                    $("#city").append('<option value="'+value+'">'+value+'</option>');
                });
           
            }else{
               $("#city").empty();
            }
           }
        });
    }else{
        $("#city").empty();
    }
        
   });


////// Client Data Show
$(document).ready(function(){
    clientDataShow();
   $('#firm_name').on('keyup', function(){
    var compnyName = $(this).val();
    if($('#firm_name').val()!=""){
      $('#companies_name').text(compnyName);
    }else{
      $('#companies_name').text('');
    }
   });

   $('#fname').on('keyup', function(){
    var fname = $(this).val();
    if($('#fname').val()!=""){
      $('#first_name').text(fname);
    }else{
      $('#fname').text('');
    }
   });

    $('#lname').on('keyup', function(){
      var lname = $(this).val();
      if($('#lname').val()!=""){
        $('#last_name').text(lname);
      }else{
        $('#lname').text('');
      }
    });

    $('#email').on('keyup', function(){
    var email = $(this).val();
    if($('#email').val()!=""){
      $('#client_email').show();
      $('#client_email_data').text(email);
    }else{
      $('#client_email').text('');
    }
   });

    $('#phone').on('keyup', function(){
    var phone = $(this).val();
    if($('#phone').val()!=""){
      $('#client_phone').show();
      $('#client_phone_data').text(phone);
    }else{
      $('#client_phone').text('');
    }
   });

    $('#country').on('change', function(){
    var country = $(this).val();
    if($('#country').val()!=""){
      $('#client_country').show();
      $('#client_country_data').text(country);
    }else{
      $('#client_country').text('');
    }
   });

    $('#state').on('change', function(){
      var state = $(this).val();
      if($('#state').val()!=""){
        $('#client_state').show();
        $('#client_state_data').text(state);
      }else{
        $('#client_state').text('');
      }
    });

    $('#city').on('change', function(){
    var city = $(this).val();
    if($('#city').val()!=""){
      $('#client_city').show();
      $('#client_city_data').text(city);
    }else{
      $('#client_city').text('');
    }
   });

    $('#zip').on('keyup', function(){
      var zip = $(this).val();
      if($('#zip').val()!=""){
        $('#client_zip').show();
        $('#client_zip_data').text(zip);
      }else{
        $('#client_zip').text('');
      }
    });

    $('#address').on('keyup', function(){
      var address = $(this).val();
      if($('#address').val()!=""){
        $('#client_address').show();
        $('#client_address_data').text(address);
      }else{
        $('#client_address').text('');
      }
    });

});

   function clientDataShow(){
      var companiesName = $('#firm_name').val(); 
      var fname = $('#fname').val();
      var lname = $('#lname').val();
      var email = $('#email').val();
      var phone = $('#phone').val();
      var country = $('#country').val();
      var state = $('#state').val();
      var city = $('#city').val();
      var zip = $('#zip').val();
      var address = $('#address').val();

      $('#companies_name').text(companiesName);
      $('#first_name').text(fname);
      $('#last_name').text(lname);
      $('#client_email_data').text(email);
      $('#client_phone_data').text(phone);
      $('#client_country_data').text(country);
      $('#client_state_data').text(state);
      $('#client_city_data').text(city);
      $('#client_zip_data').text(zip);
      $('#client_address_data').text(address);
    }

$(".toggle-password").click(function() {
$(this).toggleClass("fa-eye-slash fa-eye");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
input.attr("type", "text");
} else {
input.attr("type", "password");
}
});
</script>                
@endsection