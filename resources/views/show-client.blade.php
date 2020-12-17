@extends('layouts.app')
@section('content')  
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
  <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card client-show-card">
              <div class="card-header">
                <h4 class="card-title">Clients</h4>
                  <div class="dropdown">
                    <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                      <i class="now-ui-icons fa fa-gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item editClient" href="#" id="editButton" style="display: none;">Edit</a>
                      <a class="dropdown-item text-danger dropdown-item delete_all" href="#">Remove</a>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                 <form action="/client/search" method="POST" id="SearchData" role="search" autocomplete="off">
                    {{ csrf_field() }}
                <div class="row">
                  <div class="col-md-2">
                    <input type="hidden" name="start" id="reqStartDate">
                    <input type="hidden" name="end" id="reqEndDate">
                      <div class="form-group">
                        <input type="text" id="datepicker"  class="form-control datePick" width="150" />
                        <label style="z-index: 2;">FROM</label>
                      </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" id="datepicker2" width="150" class="form-control datePick" />
                      <label style="z-index: 2;">TO</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                      <div class="input-group">
                        <input type="text" name="q" value="{{request('q')}}" id="search" class="form-control serach-input" placeholder="Search by client name">
                        <div class="input-group-append">
                          <button class="btn btn-secondary search-btn-css" type="submit">
                            <i class="fa fa-search"></i>
                          </button>
                          <a href="/client/view">
                            <button class="btn btn-warning clear-btn-css" id="clear-btn" type="button">
                              <i class="fa fa-undo"></i>
                            </button>
                          </a>
                        </div>
                      </div>
                  </div>
                </div>
                </form>
                <div class="row">
                  <div class="col-md-12">
                     @if(isset($message))
                         <p>{{ $message }}</p>
                     @endif
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        <input type="checkbox" id="master">
                        CLIENT<br>
                         <span style="font-weight: 400;font-size: 12px;">(Name / email)</span>
                      </th>
                      <th>
                        MOBILE
                      </th>
                      <th>
                        ADDRESS
                      </th>
                      <th>
                        STATE
                      </th>
                      <th>
                        CITY
                      </th>
                      <th>
                        CREATE DATE
                      </th>
                      <th class="text-right">
                        INVOICES
                      </th>
                    </thead>
                    <tbody>
                    @if(isset($clients))
                          @foreach ($clients as $key => $client)
                      <tr id="tr_{{$client->id}}" class="clickable-row" data-href='/client/update/{{$client->id}}' style="cursor: pointer;">
                        <td><input type="checkbox" class="sub_chk" data-id="{{$client->id}}">  {{ $client->fname}}  {{ $client->lname}}<br>
                         <span class="td-inv-no">{{ $client->email}}</span>
                        </td>
                        <td>
                          {{ $client->phone }}
                        </td>
                        <td>
                          {{ $client->address }}
                        </td>
                        <td>
                          {{ $client->state }}
                        </td>
                        <td>
                          {{ $client->city }}
                        </td>
                        <td>
                          {{ $client->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-right">
                          {{ $client->totalInvoices }}
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                    @if($clients){!! $clients->render() !!}@endif
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
  </div>
    <!-- end content section -->
<script>
  var nowDate = new Date();
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            // minDate: today,
             //value: nowDate.getMonth()+1+"/"+nowDate.getDate()+"/"+nowDate.getFullYear(),
            value: "{{request('start')}}",
            format: 'mm/dd/yyyy',
            change: function (e) {
          $("#reqStartDate").val(e.target.value);
        }
        });

    var nowDate = new Date(); 
    nowDate.setDate(nowDate.getDate() + 7);
    // var mm = nowDate.getMonth();
    // var y = nowDate.getFullYear();

    // var FormattedDate = dd + '/' + mm + '/' + y;
    
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4',
            maxDate: today,
             //value: nowDate.getMonth()+1+"/"+nowDate.getDate()+"/"+nowDate.getFullYear(),
            value: "{{request('end')}}",
            format: 'mm/dd/yyyy',
             change: function (e) {
            $("#reqEndDate").val(e.target.value);
          }
        });

            /// action button 
    $(document).ready(function () {

          // select all 
        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {  
            $(".sub_chk").prop('checked', true);
            $("#action-btn").prop('disabled', false);
            $("#sendButton").hide();
            $("#editButton").hide();
            $("#action-btn").addClass("add-border-click");
            //onclick="document.getElementById('taxValueFlat').disabled = false";  
         } else {  
            $(".sub_chk").prop('checked',false);
            $("#action-btn").prop('disabled', true);
            $("#action-btn").removeClass("add-border-click");  
         }  
        });


          // action button 

        $(document).on('click','.sub_chk', function(e) {
          if($(".sub_chk:checked").length ==0){
            $("#action-btn").prop('disabled', true);
            $("#action-btn").removeClass("add-border-click");  
          }else{
            $("#action-btn").prop('disabled', false);
            $("#action-btn").addClass("add-border-click");
          }
        });

        /// Show Mail send or edit button

          $('.sub_chk').on('click', function(e) {
         
            if($(".sub_chk:checked").length >1){
              $("#editButton").hide();
            }else{
              $("#editButton").show();
            }
            
        });


          // delete all 
        $('.delete_all').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  


                var check = confirm("Are you sure you want to delete client?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 
                    console.log(join_selected_values);


                    /// Delete all data

                    $.ajax({
                        url: '/delete-client',
                        type: 'DELETE',
                        dataType: 'json',
                        method : 'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                toastr.success("Client deleted","Success");
                                location.reload();
                            } else if (data['error']) {
                                toastr.error("Clients can not Deleted","Sorry");
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                          toastr.error(data.responseText,"error");
                            //alert(data.responseText);
                        }
                    });


                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });
     });


                                   //// edit loction page
 

      $(document).ready(function () {
        $('.editClient').on('click', function(e) {
        var allVals = $(".sub_chk:checked").attr('data-id');
        if($(".sub_chk:checked").length >1)  
            {  
                alert("Please select One");  
            }  else {  
                                         
          window.location.href = '/client/update/'+allVals;
        }
               
      });
    });

       /// hide search button
if($('#search').val()!=""){
  $('#clear-btn').show();
}
if($('#reqStartDate').val()!=""){
  $('#clear-btn').show();
}

/// on checkboox click only
jQuery(document).ready(function($) {
  $(".clickable-row").click(function(e) {
    if(e.target.tagName != 'INPUT'){
      window.location = $(this).data("href");
    }
  });
});
</script>
@endsection 