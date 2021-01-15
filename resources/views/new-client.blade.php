@extends('layouts.app')
@section('content')  
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
  <div class="content">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">New Client</h5>
              </div>
              <div class="card-body">
                <form action="/client" method="post" autocomplete="">
                    {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" value="{{old('fname')}}" name="fname" id="fname" class="form-control">
                        <label>First Name</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" name="lname" value="{{old('lname')}}" id="lname" class="form-control">
                        <label>Last Name</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input name="phone" type="text" id="phone" value="{{$phone}}" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" readonly>
                        <label>Mobile</label>
                        @if ($errors->has('phone'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('phone') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{old('email')}}">
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
                        <select  name="country" id="country" class="form-control">
                          <option value="">Select Country</option>
                         @foreach($country_data as $country)
                          <option value="{{ $country->name }}" {{ (old("country") == $country->name ? "selected":"") }}>{{$country->name}}</option>
                         @endforeach
                       </select>
                        <label>Country</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <select name="state" id="state" class="form-control">
                          <option value="">Select State</option>
                          @foreach($state_data as $state)
                            <option value="{{$state->name}}" {{ (old("state") == $state->name ? "selected":"") }}>{{$state->name}}</option>
                          @endforeach
                        </select>
                        <label>State</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <select name="city" id="city" class="form-control">
                          <option value="">Select City</option>
                          @foreach($city_data as $city)
                            <option value="{{$city->name}}" {{ (old("city") == $city->name ? "selected":"") }}>{{$state->name}}</option>
                          @endforeach
                        </select>
                        <label>City</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="number" name="zipcode" id="zip" value="{{old('zipcode')}}" class="form-control">
                        <label>Postal Code</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea name="address" id="address" rows="4" cols="80" class="form-control" placeholder="Address"></textarea>
                        <label>Address</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-success">Save</button>
                      <button type="button" class="btn btn-danger">Clear</button>
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
                  <a href="#">
                    <img class="avatar border-gray" src="/public/images/icon/user.jpg" alt="Client">
                    <h5 class="title"><span id="first_name"></span> <span id="last_name"></span></h5>
                  </a>
                  <hr class="hr-color">
                  <div class="client-data" id="client_email">Email : <span id="client_email_data"></span></div>
                  <div class="client-data" id="client_phone">Phone : <span id="client_phone_data"></span></div>
                  <div class="client-data" id="client_country">Country : <span id="client_country_data"></span></div>
                  <div class="client-data" id="client_state">State : <span id="client_state_data"></span></div>
                  <div class="client-data" id="client_city">City : <span id="client_city_data"></span></div>
                  <div class="client-data" id="client_zip">ZipCode : <span id="client_zip_data"></span></div>
                  <div class="client-data" id="client_address">Address : <span id="client_address_data"></span></div>
                  <!-- <p class="description">
                    michael24
                  </p> -->
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


<script type="text/javascript">
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


///// Client Data Show
$(document).ready(function(){
    if($('#phone').val()!=""){
      $('#client_phone').show();
      var phone = $('#phone').val();
      $('#client_phone_data').text(phone);
    }else{
      $('#client_phone').hide();
    }

   $('#fname').on('keyup', function(){
    var fname = $(this).val();
    if($('#fname').val()!=""){
      $('#first_name').text(fname);
    }else{
      $('#fname').hide();
    }
   });

    $('#lname').on('keyup', function(){
      var lname = $(this).val();
      if($('#lname').val()!=""){
        $('#last_name').text(lname);
      }else{
        $('#lname').hide();
      }
    });

    $('#email').on('keyup', function(){
    var email = $(this).val();
    if($('#email').val()!=""){
      $('#client_email').show();
      $('#client_email_data').text(email);
    }else{
      $('#client_email').hide();
    }
   });

    $('#country').on('change', function(){
    var country = $(this).val();
    if($('#country').val()!=""){
      $('#client_country').show();
      $('#client_country_data').text(country);
    }else{
      $('#client_country').hide();
    }
   });

    $('#state').on('change', function(){
      var state = $(this).val();
      if($('#state').val()!=""){
        $('#client_state').show();
        $('#client_state_data').text(state);
      }else{
        $('#client_state').hide();
      }
    });

    $('#city').on('change', function(){
    var city = $(this).val();
    if($('#city').val()!=""){
      $('#client_city').show();
      $('#client_city_data').text(city);
    }else{
      $('#client_city').hide();
    }
   });

    $('#zip').on('keyup', function(){
      var zip = $(this).val();
      if($('#zip').val()!=""){
        $('#client_zip').show();
        $('#client_zip_data').text(zip);
      }else{
        $('#client_zip').hide();
      }
    });

    $('#address').on('keyup', function(){
      var address = $(this).val();
      if($('#address').val()!=""){
        $('#client_address').show();
        $('#client_address_data').text(address);
      }else{
        $('#client_address').hide();
      }
    });

});
</script>                               
@endsection