@extends('layouts.app')
@section('content')
<form action="/client" method="post" autocomplete="">
    {{ csrf_field() }}
    <div class="row-class" style="padding-bottom: 10px;">
      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <span class="clients-title">ADD CLIENT</span> 
      </div>

      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
        <div class="top-btn">
            <a href="/dashboard"><button type="button" class="save-btn"><img src="/images/invoice-icons/cancel_btn.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/cancel_btn-active.svg" class="form-top-btn-icon">
              <span class="form-top-btn-icon-title">Cancel</span></button></a>
              
            <a href="#"><button type="submit" class="save-btn"><img src="/images/invoice-icons/save-invoice-icon.svg" class="form-top-btn-icon"><img src="/images/invoice-icons/save-invoice-icon-active.svg" class="form-top-btn-icon"><span class="form-top-btn-icon-title">Save</span></button></a> 
        </div>
      </div>
    </div> <!-- end row -->

    <div class="row client-area">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        
          <div class="row client-area-row">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group">
                  <input type="text" class="form-control client-input input-border" value="{{old('fname')}}" name="fname" placeholder="First Name" required>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                  <div class="form-group">
                    <input type="text" class="form-control client-input input-border" name="lname" value="{{old('lname')}}" placeholder="Last Name" required>
                  </div>
              </div>
          </div><!-- end row -->

          <div class="row client-area-row2">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group">
                    <select data-placeholder="Choose a Company" class="form-control input-border" tabindex="1" name="companies_id" id="companies_id">
                          <option value=""> -- Select Company --</option>
                          <option value="new" class="clearValue">Add New</option>
                              @foreach ($companies as $company)
                          <option class="company-id-get" value="{{ $company->id }}" {{ (old("companies_id") == $company->id ? "selected":"") }}>{{ $company->name}}</option>
                              @endforeach
                    </select>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div id="show-logo">
                  <img src="" class="client-btn" id="companyLogo">
                </div>
                <button type="button" class="hide-btn" data-toggle="modal" data-target="#addCompanyModal" id="openModel"></button>
              </div>
          </div><!-- end row -->
          <div class="row client-area-row2">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                 <div class="form-group">
                     <input type="email" class="form-control client-input input-border {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{old('email')}}" placeholder="Email" required>
                     @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                 </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group">
                    <input type="email" class="form-control client-input input-border {{ $errors->has('email2') ? ' is-invalid' : '' }}" name="email2" value="{{old('email2')}}" placeholder="Email-2">
                    @if ($errors->has('email2'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('email2') }}</strong>
                          </span>
                    @endif
                </div>
              </div>
          </div><!-- end row -->

          <div class="row client-area-row2">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">   
                  <div class="form-group">
                      <select  name="country" id="country" class="form-control input-border">
                          <option value="">Select Country</option>
                         @foreach($country_data as $country)
                        <option value="{{ $country->name }}" {{ (old("country") == $country->name ? "selected":"") }}>{{$country->name}}</option>
                         @endforeach
                       </select>
                  </div>
              </div>
                                
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                  <div class="form-group">
                      <select name="state" id="state" class="form-control input-border">
                          <option value="">Select State</option>
                          @foreach($state_data as $state)
                          <option value="{{$state->name}}" {{ (old("state") == $state->name ? "selected":"") }}>{{$state->name}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
        </div><!-- end row -->

        <div class="row client-area-row2">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group">
                  <input type="text" name="city" class="form-control client-input input-border" placeholder="City" value="{{old('city')}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group">
                    <input type="text" name="zipcode" class="form-control client-input input-border" value="{{old('zipcode')}}" placeholder="ZipCode">
                </div>
            </div>
        </div>

        <div class="row client-area-row2 mobile-bottom" style="margin-bottom: 35px;">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="form-group">
                <textarea name="address" id="textarea-input" rows="5" placeholder="Address" class="form-control input-border"></textarea>
            </div>
          </div>
        </div>

      </div>
    </div>
    

</form>



              <!-- Add Company Model -->

                        <div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
                          <div class="modal-dialog modal-sm" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                            <div class="modal-title-text">
                                              Add Company
                                            </div>
                                          </div>
                                  <div class="modal-body">
                                      <form id="CompanyData" method="post" enctype="multipart/form-data">
                                         {{ csrf_field() }}
                                          <div class="form-group">
                                              <label>Company Name</label>
                                              <input type="text" class="form-control input-border" id="companyName" name="name" placeholder="Enter Company Name" required>
                                          </div>
                                          <div class="form-group">
                                            <label for="logo">Company Logo</label><br>
                                            <input type="file" name="logo" id="companyLogo" accept="image/*" class="form-control input-border">
                                           </div>
                                        
                                         </div>
                                           <div class="modal-footer">
                                            
                                            <center><button type="submit" id="send-mail-btn" class="btn modal-btn">
                                              Confirm
                                              </button></center>
                                              <button type="button" class="close" data-dismiss="modal">&times;</button> 
                                          </div>
                                        </form>
                                  </div>
                              </div>
                          </div>
                             
                 <!-- End model -->


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
                <!--- Submit add Company Data by Ajax -->

                      <script>
                            $("form#CompanyData").submit(function(e) {
                              e.preventDefault();    
                              var formData = new FormData(this);

                              $.ajax({
                                  url: 'add-company', 
                                  type: 'POST',
                                  data: formData,
                                  success: function (data) {
                                      console.log(data);
                                      $('#companies_id')
                                       .append($("<option selected></option>")
                                                  .attr("value",data.id)
                                                  .text(data.name));
                                      $("#companyLogo").attr('src','/company_logo/'+data.logo);
                                      $('#addCompanyModal').hide(); /// hide modal 
                                      $(".modal .close").click(); /// close modals
                                      $('#show-logo').show();
                                  },
                                  error: function (data) {
                                    alert(data.responseText);
                                },
                                  cache: false,
                                  contentType: false,
                                  processData: false
                              });
                          }); 



                          $("#companies_id").on("change", function () {
                                 if($(this).val() === 'new'){
                                  $("#openModel").click();
                              }   
                              //  $('#addCompanyModal').modal('show');
                              // if($(this).val() === 'new'){
                              //     $modal.modal.show();
                              // }
                          });


                          $('#companies_id').on('change', function(){            
                          var company_id = $(this).val();   
                          if(company_id) {

                            $.ajax({
                              type: 'GET',
                              url: '/getCompany?company_id='+company_id,
                              dataType: 'json',
                              success: function(data){
                                // $("#hiddnbox #companyName").text(data.name);
                                $("#companyLogo").attr('src','/company_logo/'+data.logo);   
                                $('#show-logo').show();
                              }
                            });
                          } else {
                           $('#show-logo').hide();
                          }
                        });   
                      </script>

@endsection