@extends('layouts.app')
@section('content')
                <div class="col-sm-4">
                  <h5>Yours Company</h5>  
                </div>
                <div class="col-sm-8">
                    <a href="/ShowCompany"><button type="button" class="btn" id="clear-btn"> <i class="fa fa-remove" style="color: #df59f9;"></i> Clear Search</button></a>
                </div>
                <div class="search-bar">
                  <form action="" id="SearchData" method="POST" >
                    {{ csrf_field() }}
                  <div class="col-sm-2">
                    <div class="dropdown">
                      <button type="button" class="btn dropdown-toggle action-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled="disabled" id="action-btn">
                        ACTIONS <span class="caret"></span>
                      </button>
                      <div class="dropdown-menu">
                        <!-- <a class="dropdown-item action-list" href="#">SEND EMAIL</a> -->
                        <a class="dropdown-item action-list" href="#">EDIT</a>
                        <a class="dropdown-item action-list" href="#">DELETE</a>
                        <!-- <a class="dropdown-item action-list" href="#">MARK AS SENT</a> -->
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    
                  <input type="text" name="q" value="{{request('q')}}" class="form-control" id="search" placeholder="Search by Company name">
                  </div>
                  <div class="col-sm-2">
                   <div class="col-sm-12">
                      <div class="col-sm-4">
                        <input type="text" name="start" id="datepicker"  class="datePick" width="2" />
                        <span class="cle-icon-title" style="margin-left: -30px;">From</span>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="end" id="datepicker2"  class="datePick" width="2" />
                        <span class="cle-icon-title" style="margin-left: -25px;">To</span>
                       <!--  <i class="fa fa-calendar search-icon"></i><br><span class="cle-icon-title">To</span> -->
                      </div>
                      <div class="col-sm-4">
                        <button type="submit" id="searchBtn" class="search-btn"><img src="/images/search_btn.png"> <br><span class="cle-icon-title">Search</span></button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12" id="show-result-data">
                  <div class="show-result">From: <span>
                      <input type="text" readonly name="" id="reqStartDate" value="{{request('start')}}"> </span> To : <span><input type="text" readonly name="" id="reqEndDate" value="{{request('end')}}"></span>
                    <span>@if( ! empty( $total_row)) {{ $total_row}} results found @else results not found @endif</span>
                    </div>
                </div>
                </form>
                </div>
                <div class="col-sm-12 data-table">
                        <table class="table">
                              <thead>
                                <tr>
                                  
                                  <th scope="col" class="table-heading">Company Name</th>
                                    <th scope="col" class="table-heading">Company Logo</th>
                                  <th scope="col" class="table-heading">CREATED DATE</th>
                                  <th scope="col" class="table-heading">UPDATED DATE</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if(count($companies) > 0)
                                @foreach ($companies as $company)
                                <tr id="tr_{{$company->id}}" class="clickable-row" data-href='/update-company/{{$company->id}}' style="cursor: pointer;">
                                  
                                  <td scope="row" class="td-inv-name"><input type="checkbox" class="sub_chk" data-id="{{$company->id}}"><span style="padding-left: 10px">{{ $company->name}}</span></td>
                                  <td class="td-inv-name"><img src="{{asset('/company_logo/'.$company->logo)}}" style="width: 50px; height: 50px; border-radius: 50%;"></td>
                                  <td class="td-inv-name">{{ $company->created_at->format('d/m/Y') }}</td>
                                  <td class="td-inv-name">{{ $company->updated_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                                 @else
                                <tr>
                                    <td align="center" colspan="5">No Data Found</td>
                                </tr>                                     
                                
                                @endif
                              </tbody>
                            </table>
                            <div id="page">{{ $companies->links() }}</div>
                       </div>

                      

        <script>
              if($('#search').val()==""){
                $('#clear-btn').hide();
              }else{
                $('#clear-btn').show();
              }
              if($('#reqStartDate').val()==""){
                $('#show-result-data').hide();
              }else{
              $('#show-result-data').show();
              $('#clear-btn').show();
              }
        </script>
        <script>
          jQuery(document).ready(function($) {
              $(".clickable-row").click(function(e) {
                if(e.target.tagName != 'INPUT'){
                  window.location = $(this).data("href");
                }
              });
          });

          /// date picker
                            var startDate = document.getElementById('reqStartDate').value;
                            $('#datepicker').datepicker({
                            icons: {
                             rightIcon: ' <i class="fa fa-calendar search-icon"></i>'
                         },
                          format: 'dd/mm/yyyy',
                          value : startDate,
                          
                        });
                            var endDate = document.getElementById('reqEndDate').value;
                            $('#datepicker2').datepicker({
                            
                            icons: {
                             rightIcon: ' <i class="fa fa-calendar search-icon"></i>'
                         },
                         format: 'dd/mm/yyyy',
                         value : endDate,
                            
                        });

        </script>

@endsection
