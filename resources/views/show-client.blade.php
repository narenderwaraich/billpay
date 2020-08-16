@extends('layouts.app')
@section('content')
                <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2" style="padding-top: 15px;">
                    <h5>Yours Clients</h5>
                </div> 
                <div class="col-6 col-sm-8 col-md-8 col-lg-9 col-xl-10 view-page-add-btn">
                 <a href="/client"><button type="button" class="btn add-client-btn"><img src="/images/invoice-icons/add-client-icon.svg"><img src="/images/invoice-icons/add-client-icon-active.svg"></button></a>
                </div>
                

                <div class="search-bar">
                  <form action="/client/search" method="POST" id="SearchData" role="search" autocomplete="off">
                    {{ csrf_field() }}
                  <div class="col-xs-3 col-sm-12 col-md-3 col-lg-3 col-xl-2" style="clear: both;">
                    <div class="dropdown btn-move">
                      <button type="button" class="btn dropdown-toggle action-btn mobile-view-action-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="action-btn" disabled="disabled">
                        ACTIONS <span class="caret"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item action-list editClient" href="#" id="editButton" style="display: none;">EDIT</a>
                        <a class="dropdown-item  action-list delete_all" href="#">DELETE</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-5 col-lg-6 col-xl-8">
                    
                  <input type="text" name="q" value="{{request('q')}}" id="search" class="form-control serach-input" placeholder="Search by client name, company Name">
                  </div>
                  <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 search-icon-div row-remove-pad m-t-15">
                        <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <input  name="start" id="datepicker"  class="datePick" width="2" />
                          <span class="cle-icon-title from-label">From</span>
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <input  name="end" id="datepicker2"  class="datePick" width="2" />
                          <span class="cle-icon-title2">To</span>
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                         <button type="submit" class="search-btn" id="searchBtn"><img src="/images/search_btn.png"><span class="search-icon-title">Search</span></button>
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                         <a href="/client/view"><button type="button" class="clear-btn-icon" id="clear-btn"><img src="/images/delete-invoice-icon.svg" width="34px"> <br><span class="clear-icon-title">Clear</span></button></a>
                    </div>
                    </div>
                </form>
              </div> <!-- end row -->
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="show-result-data">
                  <div class="show-result"><span class="hide-data-mobile-view">From</span><span>
                      <input type="text" readonly name="" value="{{request('start')}}" id="reqStartDate"> </span><span class="hide-data-mobile-view">To </span><span><input type="text" value="{{request('end')}}" readonly name="" id="reqEndDate"></span>
                    </div>
                </div>
                  <div class="col-xs-6 col-md-12 col-sm-12 result-status">
                    @if(isset($message))
                         <p>{{ $message }}</p>
                    @endif
                    <!-- <span id="record">@if( ! empty( $total_row)) {{ $total_row}} Client found match your search @else Client not found match Your search @endif</span> --></div>
                
                <div class="col-sm-12 m-t-35">
                   <div class="table-responsive">
                        <table class="table">
                              <thead>
                                <tr>
                                  
                                  <th scope="col" class="table-heading"><input type="checkbox" id="master">  CLIENT <br>
                                    <span style="padding-left: 15px;font-weight: 400;">(Name / email)</span></th>
                                    <th scope="col" class="table-heading">COMPANY</th>
                                  <th scope="col" class="table-heading hide-data-mobile-view">CREATED DATE</th>
                                  <th scope="col" class="table-heading">INVOICES RAISED</th>
                                  <th scope="col" class="table-heading">INVOICED AMOUNT</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if(isset($clients))
                                @foreach ($clients as $key => $client)
                                <tr id="tr_{{$client->id}}" class="clickable-row" data-href='/client/update/{{$client->id}}' style="cursor: pointer;">
                                  
                                  <td scope="row" class="td-inv-name"><input type="checkbox" class="sub_chk" data-id="{{$client->id}}">  {{ $client->fname}}  {{ $client->lname}}<br>
                                   <span class="td-inv-no">{{ $client->email}}</span></td>
                                  <td class="td-inv-name">{{ $client->companies->name}}</td>
                                  <td class="td-inv-name hide-data-mobile-view">{{ $client->created_at->format('m/d/Y') }}</td>
                                  <td class="td-inv-name"> {{ $client->totalInvoices }}</td>
                                  <td class="td-inv-name">@if(empty($client->invoiceAmount)) $0 @else ${{ $client->invoiceAmount }} @endif</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            @if($clients){!! $clients->render() !!}@endif
          
                            @endif
                          </div>
                       </div>
                   <center>
                    @if(isset($invoices))
                    @foreach ($invoices->take(3) as $invoice)
                
                    <div class="col-sm-4">
                     <div class="invoice-status-box2">

                       <div class="inv-title-text2">{{ $invoice->client->fname }}  {{ $invoice->client->lname }} 
                      <br>
                      <div class="em">{{ $invoice->client->email }}</div>
                      <div class="invoi-company-name">{{ $invoice->companies->name }}</div>
                       <hr class="inv-box-line">
                       <div class="amt">Invoiced Amount</div>
                       <div class="amount-show">${{ $invoice->net_amount}}
                       <br>
                       USD </div>
                       <hr class="inv-box-line">
                       <div class="amount_PAID">PAID</div>
                       <div class="tot-amt">${{ $invoice->paidInvAmount}} USD</div>
                       </div>
                     </div>
                   </div>
           
                  @endforeach 
                  @endif
                 </center>
                   <!-- <div class="col-sm-4">
                     <div class="invoice-status-box2">

                       <div class="inv-title-text2">{{Auth::user()->fname}} {{Auth::user()->lname}}
                      <br>
                      <div class="em">{{Auth::user()->email}}</div>
                       <hr class="inv-box-line">
                       <div class="amt">Invoiced Amount</div>
                       <div class="amount-show">123456.40
                       <br>
                       USD </div>
                       <hr class="inv-box-line">
                       <div class="amount_OVERDUE">Amount Overdue</div>
                       <div class="tot-amt">458552.00 USD</div>
                       </div>
                     </div>
                   </div>
                   <div class="col-sm-4">
                     <div class="invoice-status-box2">

                       <div class="inv-title-text2">{{Auth::user()->fname}} {{Auth::user()->lname}}
                      <br>
                      <div class="em">{{Auth::user()->email}}</div>
                       <hr class="inv-box-line">
                       <div class="amt">Invoiced Amount</div>
                       <div class="amount-show">123456.40
                       <br>
                       USD </div>
                       <hr class="inv-box-line">
                       <div class="amount_OVERDUE">Amount Overdue</div>
                       <div class="tot-amt">458552.00 USD</div>
                       </div>
                     </div>
                   </div>
                  </center> -->

</div> <!-- .content -->
    </div><!-- /#right-panel -->
    <style type="text/css">
      .bk-clr{
    background: linear-gradient(40deg,#2096ff,#05ffa3)!important;
    width: auto;
    height: auto;
  }
  .offer-div1{
    background: #ffffff;
    width: 250px;
    height: 300px;
    border-radius: 20px;
    border: 2px solid #fff;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
  }
  .offer-div2{
    background: #ffffff;
    width: 250px;
    height: 300px;
    border-radius: 20px;
    border: 2px solid #fff;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
  }
  .offer-div3{
    background: #ffffff;
    width: 250px;
    height: 300px;
    border-radius: 20px;
    border: 2px solid #fff;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
  }
  .box-inner-1{
    padding: 35px;
    /*background: linear-gradient(to top,#45cafc 0,#303f9f 100%);*/
    background: linear-gradient(40deg,#45cafc,#303f9f)!important;
    height: 230px;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
  }
  .box-inner-2{
    padding: 35px;
    background: linear-gradient(40deg,#ffd86f,#fc6262)!important;
    height: 230px;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
  }
  .box-inner-3{
    padding: 35px;
    background: linear-gradient(40deg,#ff6ec4,#7873f5)!important;
    height: 230px;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
  }
  .bok-now-1{
    color: #0d47a1;
    text-align: center;
    padding-top: 18px;
    font-weight: 700;
  }
  .bok-now-2{
    color: #ff4444;
    text-align: center;
    padding-top: 18px;
    font-weight: 700;
  }
  .bok-now-3{
    color: #9933CC;
    text-align: center;
    padding-top: 18px;
    font-weight: 700;
  }
  .title-txt{
    color: #ffffff;
    text-align: center;
    margin-top: 15px;
    font-weight: 700;
  }
  .ofr-txt-title{
    color: #ffffff;
  }

  /* Carousel Styles */
.carousel-indicators .active {
    background-color: #2980b9;
}

.carousel-inner img {
    width: 100%;
    max-height: 460px
}

.carousel-control {
    width: 0;
}

.carousel-control.left,
.carousel-control.right {
  opacity: 1;
  filter: alpha(opacity=100);
  background-image: none;
  background-repeat: no-repeat;
  text-shadow: none;
}

.carousel-control.left span {
  padding: 15px;
}

.carousel-control.right span {
  padding: 15px;
}

.carousel-control .fa-chevron-left, 
.carousel-control .fa-chevron-right, 
.carousel-control .icon-prev, 
.carousel-control .icon-next {
  position: absolute;
  top: 45%;
  z-index: 5;
  display: inline-block;
}

.carousel-control .fa-chevron-left,
.carousel-control .icon-prev {
  left: 70px;
  font-size: 45px;
}

.carousel-control .fa-chevron-right,
.carousel-control .icon-next {
  right: 70px;
  font-size: 45px;
}

.carousel-control.left span,
.carousel-control.right span {
  background-color: #000;
}

.carousel-control.left span:hover,
.carousel-control.right span:hover {
  opacity: .7;
  filter: alpha(opacity=70);
}
</style>
     <script  src="{{ asset('js/clientsPage.js') }}"></script>
     <!-- <script>
       ///// search client data 
$(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ route('client_search.SearchClientData') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  if($('#search').val()==""){
      $('#page').show();
    }else{
      $('#page').hide();
    }
  fetch_customer_data(query);
 });
});

     </script> -->

        

@endsection

