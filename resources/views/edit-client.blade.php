@extends('layouts.app')
@section('content')
<form action="{{action('ClientsController@updateClient', $id)}}" enctype="multipart/form-data" method="post" >
    {{ csrf_field() }}
    <div class="row-class" style="padding-bottom: 10px;">
      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
      <span class="clients-title">EDIT CLIENT</span> 
      </div>

      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
        <div class="top-btn">
            <a href="/client/view"><button type="button" class="save-btn"><img src="/images/invoice-icons/cancel_btn.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/cancel_btn-active.svg" class="form-top-btn-icon">
              <span class="form-top-btn-icon-title">Cancel</span></button></a>
              
            <a href="#"><button type="submit" class="save-btn"><img src="/images/invoice-icons/save-invoice-icon.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/save-invoice-icon-active.svg" class="form-top-btn-icon"><span class="form-top-btn-icon-title">Save</span></button></a> 
        </div>
      </div>
    </div> <!-- end row -->

    <div class="row client-area client-edit-form">
      <div class="col-md-12">
        
          <div class="row client-area-row">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="client-input-label">First Name</label>
                  <input type="text" class="form-control client-input input-border" value="{{$clients->fname}}" name="fname" placeholder="First Name" required>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                     <label class="client-input-label">Last Name</label>
                    <input type="text" class="form-control client-input input-border" name="lname" value="{{$clients->lname}}" placeholder="Last Name" required>
                  </div>
              </div>
          </div><!-- end row -->

          <div class="row client-area-row2">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                   <label class="client-input-label">Company Name</label>
                  <input type="hidden" name="companies_id" value="{{$clients->companies_id}}">
                    <input type="text" class="form-control company-input input-border" name="name" value="{{$clients->companies->name}}" placeholder="Company Name" required>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <img src="{{asset('/company_logo/'.$clients->companies->logo)}}" class="company-logo" id="profile-img-tag"><span class="logo-edit" onclick="document.getElementById('getFile').click()">EDIT LOGO<input type="file" name="logo" accept="image/*" style="visibility: hidden;" id="getFile"></span>
              </div>
          </div><!-- end row -->
          <div class="row client-area-row2">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                 <div class="form-group">
                  <label class="client-input-label">Email</label>
                     <input type="email" class="form-control client-input input-border {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$clients->email}}" placeholder="Email" required>
                     @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                    @endif
                 </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="client-input-label">Email-2</label>
                    <input type="email" class="form-control client-input input-border" name="email2" value="{{$clients->email2}}" placeholder="Email-2">
                </div>
              </div>
          </div><!-- end row -->

          <div class="row client-area-row2">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">   
                  <div class="form-group">
                    <label class="client-input-label">Country</label>
                      <select  name="country" id="country" class="form-control input-border">
                        <option value="">Select Country</option>
                         @foreach($country_data as $country)
                        <option value="{{$country->name}}" {{$country->name == $clients->country  ? 'selected' : ''}}>{{$country->name}}</option>
                         @endforeach
                      </select>
                  </div>
              </div>
                                
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label class="client-input-label">State</label>
                      <select name="state" id="state" class="form-control input-border">
                          <option value="">Select State</option>
                            @foreach($state_data as $state)
                          <option value="{{$state->name}}" {{$state->name == $clients->state  ? 'selected' : ''}}>{{$state->name}}</option>
                            @endforeach
                      </select>
                  </div>
              </div>
        </div><!-- end row -->

        <div class="row client-area-row2">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="client-input-label">City</label>
                  <input type="text" name="city" class="form-control client-input input-border" placeholder="City" value="{{$clients->city}}">
                       <!-- <select name="city" id="city" class="form-control">
                              <option value="{{$clients->city}}">{{ $clients->city}}</option>
                            </select> -->
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="client-input-label">ZipCode</label>
                    <input type="text" name="zipcode" class="form-control client-input input-border" value="{{$clients->zipcode}}" placeholder="ZipCode">
                </div>
            </div>
        </div>

        <div class="row client-area-row2 mobile-bottom" style="margin-bottom: 20px;">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label class="client-input-label">Address</label>
                <textarea name="address" id="textarea-input" rows="5" placeholder="Address" class="form-control input-border">{{$clients->address}}</textarea>
            </div>
          </div>
        </div>

      </div>
    </div>
    

</form>

        
                       
                            
                               
      <script>
        $("#files").change(function() {
          filename = this.files[0].name
          console.log(filename);
          });
      </script>                  
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
</script>

  <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#getFile").change(function(){
        readURL(this);
    });
</script>


 

        
@endsection