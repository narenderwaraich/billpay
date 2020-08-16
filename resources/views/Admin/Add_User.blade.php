@extends('layouts.master')
@section('content')
<script src="{{ asset('js/vendor/jquery-2.1.4.min.js') }}"></script>
<form action="/Register" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row-class">
      <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
      <span class="clients-title">Add User</span> 
      </div>

      <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
        <div class="top-btn">
            <a href="/admin"><button type="button" class="save-btn"><img src="/images/invoice-icons/cancel_btn.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/cancel_btn-active.svg" class="form-top-btn-icon">
              <span class="form-top-btn-icon-title">Back</span></button></a>
              
            <a href="#"><button type="submit" class="save-btn"><img src="/images/invoice-icons/save-invoice-icon.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/save-invoice-icon-active.svg" class="form-top-btn-icon"><span class="form-top-btn-icon-title">Save</span></button></a> 
        </div>
      </div>
    </div> <!-- end row -->

    <div class="row user-profile-area user-updte">
      <div class="col-md-12">
        <div class="row user-profile-row2">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="user-input-label">First Name</label>
                  <input type="text" class="form-control client-input input-border" maxlength="50" value="{{ old('fname') }}" name="fname" id="firstN" placeholder="First Name" required>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label class="user-input-label">Last Name</label>
                    <input type="text" class="form-control client-input input-border" maxlength="50" name="lname" value="{{ old('lname') }}" placeholder="Last Name"  required>
                  </div>
              </div>
          </div><!-- end row -->

          <div class="row user-profile-row">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="user-input-label">Phone</label>
                  <input type="text" class="form-control client-input input-border" minlength="10" maxlength="10" value="{{ old('phone_no') }}" name="phone_no" placeholder="Phone-Number">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label class="user-input-label">Email</label>
                    <input type="email" class="form-control client-input input-border {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email">
                    @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{old('email')}} {{ $errors->first('email') }}</strong>
                          </span>
                    @endif
                  </div>
              </div>
          </div><!-- end row -->

          <div class="row user-profile-row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="user-input-label">Company Name</label>
                  <input type="text" class="form-control client-input input-border" value="{{ old('company_name') }}" name="company_name" placeholder="Company">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label class="user-input-label">Company Logo</label>
                <div class="form-group">
                  <button type="button" class="btn logo-btn" id="selectFile">Choose Logo</button>
                   <img src="/images/avatar/" id="" class="show-compny-logo profile-img-tag">
                  <input type="file" name="avatar" id="getFile" value="{{ old('avatar') }}" accept="image/*" class="form-control input-border" style="display: none;">
                </div>
              </div>
          </div><!-- end row -->

          <div class="row user-profile-row">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">   
                  <div class="form-group">
                    <label class="user-input-label">Country</label>
                      <select  name="country" id="country" class="form-control input-border">
                          <option value="">Select Country</option>
                         @foreach($country_data as $country)
                        <option value="{{$country->name}}" {{$country->name == old('country')  ? 'selected' : ''}}>{{$country->name}}</option>
                         @endforeach
                       </select>
                  </div>
              </div>
                                
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label class="user-input-label">State</label>
                      <select name="state" id="state" class="form-control input-border">
                          <option value="">Select State</option>
                          @foreach($state_data as $state)
                          <option value="{{$state->name}}" {{$state->name == old('state')  ? 'selected' : ''}}>{{$state->name}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
        </div><!-- end row -->  

        <div class="row user-profile-row">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="user-input-label">City</label>
                  <input type="text" class="form-control client-input input-border" value="{{ old('city') }}" name="city" placeholder="City">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                     <label class="user-input-label">ZipCode</label>
                    <input type="text" class="form-control client-input input-border" name="zipcode" value="{{ old('zipcode') }}" placeholder="ZipCode">
                  </div>
              </div>
          </div><!-- end row -->

          <div class="row user-profile-row" >
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label class="user-input-label">CIN/GSTIN<span>  (Put here your CIN or GSTIN registration number which will show up on invoice Ex. CIN-234234234XXX)</span></label>
                   <input type="text" class="form-control client-input input-border" name="gstin_number" value="{{ old('gstin_number') }}" placeholder="CIN / GSTIN Number">
                </div>
              </div>
          </div><!-- end row -->

          <div class="row user-profile-row" style="margin-bottom: 25px;">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label class="user-input-label">Address</label>
                  <textarea name="address" id="textarea-input" rows="3" placeholder="Address..." class="form-control input-border">{{ old('address') }}</textarea>
                </div>
              </div>
          </div><!-- end row -->

      </div>
    </div>
</form>
<style>
  body{
    background-color: #fff;
  }
  .user-profile-area {
    margin-bottom: 20px;
}
#companyImage {
    padding: 12px;
    width: 90px;
}
</style>
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
                $("#state").append('<option>Select</option>');
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
   //  $('#state').on('change',function(){
   //  var stateID = $(this).val();    
   //  if(stateID){
   //      $.ajax({
   //         type:"GET",
   //         url:"{{url('get-city-list')}}?state_id="+stateID,
   //         success:function(res){               
   //          if(res){
   //              $("#city").empty();
   //              $.each(res,function(key,value){
   //                  $("#city").append('<option value="'+key+'">'+value+'</option>');
   //              });
           
   //          }else{
   //             $("#city").empty();
   //          }
   //         }
   //      });
   //  }else{
   //      $("#city").empty();
   //  }
        
   // });

  $(document).ready(function(){
    $('#selectFile').on('click', function() {
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
      $("#companyImage").hide();
        readURL(this);
    });
    });
</script>
@endsection