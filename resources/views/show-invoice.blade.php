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
            <div class="card invoice-show-card">
              <div class="card-header">
                <h4 class="card-title">Invoices</h4>
                  <div class="dropdown">
                    <button type="button" id="action-btn"  class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown" disabled="">
                      <i class="now-ui-icons fa fa-gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                     <a class="dropdown-item sendInvoice" href="#" data-toggle="modal" data-target="#myModal" id="sendButton" style="display: none;">SEND EMAIL</a>
                      <a class="dropdown-item sendReminder" href="#" data-toggle="modal" data-target="#sendReminderModel" id="reminderButton" style="display: none;">SEND REMINDER</a>
                       <a class="dropdown-item" id="markSent" href="#">MARK AS SENT</a>
                       <a class="dropdown-item" id="depositPaid" href="#">DEPOSIT PAID</a>
                       <a class="dropdown-item" id="markStripePaid" href="#">PAID</a>
                       <a class="dropdown-item downloadInvoice" href="#" id="downloadButton" style="display: none;">DOWNLOAD INVOICE</a>
                      <a class="dropdown-item copyInvoice" href="#" id="copyButton" style="display: none;">Copy</a>
                      <a class="dropdown-item editInvoice" href="#" id="editButton" style="display: none;">Edit</a>
                      <a class="dropdown-item text-danger delete_all" href="#">Remove</a>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <form action="/invoice/search" method="POST" id="SearchData" role="search" autocomplete="off">
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
                          <a href="/invoice/view">
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
                         <span style="font-weight: 400;font-size: 12px;">(Invoice Number)</span>
                      </th>
                      <th>
                        ISSUE DATE
                      </th>
                      <th>
                        DUE DATE
                      </th>
                      <th>
                        STATUS
                      </th>
                      <th class="text-right">
                        AMOUNT
                      </th>
                    </thead>
                    <tbody>
                    @if(isset($invoices))
                      @foreach ($invoices as $invoice)
                      <tr id="tr_{{$invoice->id}}" class="clickable-row" data-href='/invoice/view/{{$invoice->id}}' style="cursor: pointer;">
                        <td>
                          <input type="checkbox" class="sub_chk" data-id="{{$invoice->id}}" token-data="{{$invoice->invoice_number_token}}" email-id="{{ $invoice->client->email }}"> <a href="/invoice/view/{{$invoice->id}}"> {{ $invoice->client->fname }}  {{ $invoice->client->lname }}<br>
                            <span class="td-inv-no">{{ $invoice->invoice_number}}</span> </a>
                        </td>
                        <td>
                          {{ date('m/d/Y', strtotime($invoice->issue_date)) }}
                        </td>
                        <td>
                          {{ date('m/d/Y', strtotime($invoice->due_date)) }}
                        </td>
                        <td class="status_{{ strtolower($invoice->status)}}">{{ $invoice->status}} <br>
                              @if($invoice->status == "OVERDUE" && $invoice->net_amount != $invoice->due_amount)
                              <span class="td-inv-amount-status">DEPOSIT PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                              @endif
                              @if($invoice->status == "PAID-STRIPE" || $invoice->status == "PAID-BANKWIRE" || $invoice->status == "PAID-OFFLINE")
                             <span class="td-inv-amount-status">PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                             @endif

                             @if($invoice->status == "DEPOSIT_PAID")
                             <span class="td-inv-amount-status">DEPOSIT PAID ON {{ date('m/d/Y', strtotime($invoice->payment_date)) }}</span>
                             @endif
                        </td>
                        <td class="text-right">
                          ${{ $invoice->net_amount}}
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                    @if($invoices){!! $invoices->render() !!}@endif
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
  </div>
    <!-- end content section -->
                              




                                  <!--Send Mail Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <div class="modal-title-text">
                                              Send Invoice
                                            </div>
                                          </div>
                                          <div class="modal-body">
                                            <form  id="MailData" method="post">
                                                {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>To</label>
                                                <input type="text" name="email" readonly value="" id="inv_email" class="form-control model-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Additional Email</label>
                                                <input type="text" name="additional_email" value=""  class="form-control model-input" placeholder="Type email...">
                                            </div>
                                            <input type="hidden" name="" id="invshow">
                                          </div>
                                          <div class="modal-footer">
                                          
                                            <center><button type="submit" id="send-mail-btn" class="btn modal-btn">
                                              <span id="send-btn">Send</span>
                                              <span id="mail-button-sending" style="display:none;">Sending…</span>
                                              </button></center>
                                            
                                            <button type="button" class="close" data-dismiss="modal">&times;</button> 

                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>


                                     <!--Send Reminder Modal -->
                                    <div class="modal fade" id="sendReminderModel" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <div class="modal-title-text">
                                              Invoice Reminder
                                            </div>
                                          </div>
                                          <div class="modal-body">
                                            <!-- <img src="/images/loader.gif" id="loading" style="height: 65px;"> -->
                                            <form  id="ReminderMailData" method="post">
                                                {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>To</label>
                                                <input type="text" name="email" readonly value="" id="get_inv_email" class="form-control model-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Additional Email</label>
                                                <input type="text" name="additional_email" value=""  class="form-control model-input" placeholder="Type email...">
                                            </div>
                                            <input type="hidden" name="" id="invshowID">
                                          </div>
                                          <div class="modal-footer">
                                            
                                            <center><button type="submit" id="send-mail-btn" class="btn modal-btn">
                                              <span id="reminder-send-btn">Send</span>
                                              <span id="reminder-button-sending" style="display:none;">Sending…</span>
                                              </button></center>
                                            
                                            <button type="button" class="close" data-dismiss="modal">&times;</button> 

                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>

<div id="progress" class="dialogContent" style="text-align: left; display: none;">
  <img src="/images/gif/ajax-loader.gif" style="margin: auto;display: block;" />
  <h5 style="margin-top: 10px;">Please wait...</h5>
  <asp:literal id="literalPleaseWait" runat="server" text="Please wait..." />
</div>                    

<script>
  //// action button 
              $(document).ready(function () {

         // select all 
        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);
            $("#action-btn").prop('disabled', false);
            $("#sendButton").hide();
            $("#editButton").hide();
            $("#copyButton").hide();
            //$("#downloadButton").hide();
            $("#downloadButton").show();
            $("#reminderButton").hide();
            $("#action-btn").addClass("add-border-click");  
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
              $("#sendButton").hide();
              $("#editButton").hide();
              $("#copyButton").hide();
              //$("#downloadButton").hide();
              $("#downloadButton").show();
              $("#reminderButton").hide();
            }else{
              $("#sendButton").show();
              $("#editButton").show();
              $("#copyButton").show();
              $("#downloadButton").show();
              $("#reminderButton").show();
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


                var check = confirm("Are you sure you want to delete invoice?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 

                    $.ajax({
                        url: '/invoice/delete',
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
                                toastr.success("Invoice deleted","Success");
                                
                            } else if (data['error']) {
                               toastr.error(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                            setTimeout(function(){
                              location.reload();
                            }, 1000);
                        },
                        error: function (data) {
                            // alert(data.responseText);
                            toastr.error("Invoice can not deleted","Sorry");
                        }
                    });
                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });


        // $('[data-toggle=confirmation]').confirmation({
        //     rootSelector: '[data-toggle=confirmation]',
        //     onConfirm: function (event, element) {
        //         element.trigger('confirm');
        //     }
        // });


        // $(document).on('confirm', function (e) {
        //     var ele = e.target;
        //     e.preventDefault();


        //     $.ajax({
        //         url: ele.href,
        //         type: 'DELETE',
        //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //         success: function (data) {
        //             if (data['success']) {
        //                 $("#" + data['tr']).slideUp("slow");
        //                 alert(data['success']);
        //             } else if (data['error']) {
        //                 alert(data['error']);
        //             } else {
        //                 alert('Whoops Something went wrong!!');
        //             }
        //         },
        //         error: function (data) {
        //             alert(data.responseText);
        //         }
        //     });


        //     return false;
        // });
    });


/// validation select one

                         $(document).ready(function () {
                              $('.editInvoice').on('click', function(e) {
                                var allVals = $(".sub_chk:checked").attr('data-id');
                                if($(".sub_chk:checked").length >1)  
                                    {  
                                        alert("Please select One");  
                                    }  else {  
                                  window.location.href = '/invoice/edit/'+allVals;
                                    }   
                              });
                            });


                         $(document).ready(function () {
                              $('.copyInvoice').on('click', function(e) {
                                var allVals = $(".sub_chk:checked").attr('data-id');
                                if($(".sub_chk:checked").length >1)  
                                    {  
                                        alert("Please select One");  
                                    }  else {  
                                  window.location.href = '/invoice/copy/'+allVals;
                                    }   
                              });
                            });


                      // Download invoice pdf file
                         // $(document).ready(function () {
                         //        $('.downloadInvoice').on('click', function(e) {
                         //        var id = $(".sub_chk:checked").attr('data-id');
                         //        var token = $(".sub_chk:checked").attr('token-data');
                         //        if($(".sub_chk:checked").length >1)  
                         //            {  
                         //                alert("Please select One");  
                         //            }  else {  
                                                                 
                         //          window.location.href = '/invoice/download/PDF/'+id+'/'+token;
                         //        }
                                       
                         //      });
                         //    });


                               // download multi pdf
                    $('.downloadInvoice').on('click', function(e) {
                        var allVals = [];  
                        $(".sub_chk:checked").each(function() {  
                            allVals.push($(this).attr('data-id'));
                        });  
                        if(allVals.length <=0)  
                        {  
                            alert("Please select row.");  
                        }else{
                          if(allVals.length ==1){
                              /// download single invoice pdf file
                                var id = $(".sub_chk:checked").attr('data-id');
                                var token = $(".sub_chk:checked").attr('token-data'); 
                                window.location.href = '/invoice/download/PDF/'+id+'/'+token;
                          }else{
                              //// download multi invoice zip file
                                var join_selected_values = allVals.join(","); 
                                //console.log(join_selected_values);

                                $.ajax({
                                    url: '/invoice/download-mutli/PDF',
                                    dataType: 'json',
                                    method : 'post',
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    data: 'ids='+join_selected_values,
                                    beforeSend: function() {
                                      ShowProgressAnimation();
                                    },
                                    success: function (data) {
                                      if (data['success']) {
                                          var fileName = data['success'];
                                          window.location = '/zip/'+fileName;
                                          $('#progress').dialog('close');
                                          $('.gj-modal').hide();
                                          $(".modal .close").click();
                                          toastr.success("Invoice Zip Created","Success");
                                          setTimeout(function(){
                                            window.location = '/invoice/zip-file-remove/'+fileName;
                                          }, 3000);
                                      }else if (data['error']) {
                                        $('#progress').dialog('close');
                                        $('.gj-modal').hide();
                                        $(".modal .close").click();
                                         toastr.error("Invoice zip not created","Error");
                                      } else {
                                          alert('Whoops Something went wrong!!');
                                      } 
                                    },
                                    error: function (data) {
                                        $('#progress').dialog('close');
                                        $('.gj-modal').hide();
                                        $(".modal .close").click();
                                        toastr.error(data.responseText,"Error");
                                    }
                                });
                            } 
                        }  
                    });



                    function ShowProgressAnimation() {
                      var pleaseWaitDialog = $("#progress").dialog(
                      {
                      resizable: false,
                      height: 'auto',
                      width: 500,
                      modal: true,
                      title: 'INVOICES',
                      closeText: '',
                      bgiframe: true,
                      closeOnEscape: false,
                      open: function(type, data) {
                      $(this).parent().appendTo($("form:first"));
                      $('body').css('overflow', 'auto'); //IE scrollbar fix for long checklist templates
                      }
                      });
                    }




                            // get email id 

                            $(document).ready(function () {
                              $('.sendInvoice').on('click', function(e) {
                                var allVals = $(".sub_chk:checked").attr('data-id');
                                var mail = $(".sub_chk:checked").attr('email-id');
                                  document.getElementById('invshow').value = allVals;
                                  document.getElementById('inv_email').value = mail;
                                       
                              });
                            });

                            /// model send mail
                            $("form#MailData").submit(function(e) {
                              e.preventDefault();    
                              var formData = new FormData(this);
                              var invoice_id = $("#invshow").val();
                              $.ajax({
                                  url: '/invoice/send/'+invoice_id,
                                  type: 'POST',
                                  data: formData,
                                  beforeSend: function() {
                                      $('#send-btn').hide();
                                      $('#mail-button-sending').show();
                                  },
                                  success: function (data) {
                                     if (data['success']) {
                                toastr.success("Mail Sent successfully","Mail");
                                //$('.msgMail').append(data .msg);
                                      $('#loading').hide();
                                      // $('#hidediv').show();
                                      $('#myModal').hide();
                                      $(".modal .close").click();
                                          setTimeout(function(){
                                        location.reload();
                                        }, 6000);
                            } else if (data['error']) {
                                toastr.error("Sorry First Connect to Stripe Account","Mail");
                                $('#myModal').hide();
                                $(".modal .close").click();
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            toastr.error(data.responseText,"error");
                        },
                                  cache: false,
                                  contentType: false,
                                  processData: false
                              });
                          });
                          


                              /// send reminder invoices

                            //// Send reminder invoice button 
                            $(document).ready(function () {
                              $('.sendReminder').on('click', function(e) {
                                var allVals = $(".sub_chk:checked").attr('data-id');
                                var mail = $(".sub_chk:checked").attr('email-id');
                                  document.getElementById('invshowID').value = allVals;
                                  document.getElementById('get_inv_email').value = mail;
                                       
                              });
                            });


                            /// reminder mail send model
                            $("form#ReminderMailData").submit(function(e) {
                              e.preventDefault();    
                              var formData = new FormData(this);
                              var invoice_id = $("#invshowID").val();
                              $.ajax({
                                  url: '/invoice/reminder/send/'+invoice_id,
                                  type: 'POST',
                                  data: formData,
                                  beforeSend: function() {
                                      $('#reminder-send-btn').hide();
                                      $('#reminder-button-sending').show();
                                  },
                                  success: function (data) {
                                     if (data['success']) {
                                      $('#loading').hide();
                                      toastr.success("Reminder Sent successfully","Reminder");
                                      $('#sendReminderModel').hide();
                                      $(".modal .close").click();
                                          setTimeout(function(){
                                        location.reload();
                                      }, 6000);
                                          //$('.msgMail').append(data .msg);
                                          // $('#hidediv').show();
                            } else if (data['error']) {
                                toastr.error("Sorry First Connect to Stripe Account","Reminder");
                                $('#sendReminderModel').hide();
                                $(".modal .close").click();
                                location.reload();
                            } else {
                                toastr.error("Reminder Sent after status OVERDUE","Reminder");
                                $('#sendReminderModel').hide();
                                $(".modal .close").click();
                                location.reload();
                            }
                        },
                        error: function (data) {
                            toastr.error(data.responseText,"error");
                        },
                                  cache: false,
                                  contentType: false,
                                  processData: false
                              });
                          });

                          
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
                      
                      /// mark sent update
                        $(document).ready(function () {
                          $('#markSent').on('click', function(e) {
                              var allVals = [];  
                              var join_selected_values =[];
                                $(".sub_chk:checked").each(function() {  
                                    allVals.push($(this).attr('data-id'));

                                    join_selected_values = allVals.join(","); 

                                         
                                }); 

                                if(allVals.length <=0)  
                                    {  
                                        alert("Please select row.");  
                                    }  else {  

                                 $.ajax({
                                              url: '/invoice/markSent',
                                              dataType: 'json',
                                              method : 'post',
                                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                              data: 'ids='+join_selected_values,
                                              success: function (data) {
                                                  if (data['success']) {
              
                                                      toastr.success("Mail Mark Sent successfully","Mail");
                                                      location.reload();
                                                  } else if (data['error']) {
                                                      toastr.error("Sorry Invoice Mark as not Sent","Mail");
                                                  } else {
                                                      alert('Whoops Something went wrong!!');
                                                  }
                                              },
                                              error: function (data) {
                                                  alert(data.responseText);
                                              }
                                          });
                               }
                          });
                        });


                        $(document).ready(function () {
                          $('#markOfflinePaid').on('click', function(e) {
                              var allVals = [];  
                              var join_selected_values =[];
                                $(".sub_chk:checked").each(function() {  
                                    allVals.push($(this).attr('data-id'));

                                    join_selected_values = allVals.join(","); 

                                         
                                });

                                if(allVals.length <=0)  
                                    {  
                                        alert("Please select row.");  
                                    }  else {  
  

                                 $.ajax({
                                              url: '/invoice/mark-Offline-Paid',
                                              dataType: 'json',
                                              method : 'post',
                                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                              data: 'ids='+join_selected_values,
                                              success: function (data) {
                                                  if (data['success']) {
              
                                                      toastr.success("Mark Offline Paid successfully","Mail");
                                                      location.reload();
                                                  } else if (data['error']) {
                                                    toastr.error("Sorry Invoice Mark as not Offline Paid","Mail");
                                                  } else {
                                                      alert('Whoops Something went wrong!!');
                                                  }
                                              },
                                              error: function (data) {
                                                  alert(data.responseText);
                                              }
                                          });
                               }
                          });
                        });

                        $(document).ready(function () {
                          $('#markbankPaid').on('click', function(e) {
                              var allVals = [];  
                              var join_selected_values =[];
                                $(".sub_chk:checked").each(function() {  
                                    allVals.push($(this).attr('data-id'));

                                    join_selected_values = allVals.join(","); 

                                         
                                });

                                if(allVals.length <=0)  
                                    {  
                                        alert("Please select row.");  
                                    }  else {  
  

                                 $.ajax({
                                              url: '/invoice/mark-paid-bankwire',
                                              dataType: 'json',
                                              method : 'post',
                                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                              data: 'ids='+join_selected_values,
                                              success: function (data) {
                                                  if (data['success']) {
              
                                                      toastr.success("Mark BankWire Paid successfully","Mail");
                                                      location.reload();
                                                  } else if (data['error']) {
                                                    toastr.error("Sorry Invoice Mark as not BankWire Paid","Mail");
                                                  } else {
                                                      alert('Whoops Something went wrong!!');
                                                  }
                                              },
                                              error: function (data) {
                                                  alert(data.responseText);
                                              }
                                          });
                               }
                          });
                        });

                         //// mark invoice Deposit paid
                      $(document).ready(function () {
                          $('#depositPaid').on('click', function(e) {
                              var allVals = [];  
                              var join_selected_values =[];
                                $(".sub_chk:checked").each(function() {  
                                    allVals.push($(this).attr('data-id'));

                                    join_selected_values = allVals.join(","); 

                                         
                                });

                                if(allVals.length <=0)  
                                    {  
                                        alert("Please select row.");  
                                    }  else {  
  

                                 $.ajax({
                                              url: '/invoice/mark-deposit-invoice',
                                              dataType: 'json',
                                              method : 'post',
                                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                              data: 'ids='+join_selected_values,
                                              success: function (data) {
                                                  if (data['success']) {
              
                                                      toastr.success("Mark Deposit Paid successfully","Mail");
                                                      location.reload();
                                                  } else if (data['error']) {
                                                    toastr.error("Sorry Invoice Mark as not Deposit Paid","Mail");
                                                  } else {
                                                      alert('Whoops Something went wrong!!');
                                                  }
                                              },
                                              error: function (data) {
                                                  alert(data.responseText);
                                              }
                                          });
                               }
                          });
                        });

                      //// mark invoice Stripe paid
                      $(document).ready(function () {
                          $('#markStripePaid').on('click', function(e) {
                              var allVals = [];  
                              var join_selected_values =[];
                                $(".sub_chk:checked").each(function() {  
                                    allVals.push($(this).attr('data-id'));

                                    join_selected_values = allVals.join(","); 

                                         
                                });

                                if(allVals.length <=0)  
                                    {  
                                        alert("Please select row.");  
                                    }  else {  
  

                                 $.ajax({
                                              url: '/invoice/mark-stripe-paid',
                                              dataType: 'json',
                                              method : 'post',
                                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                              data: 'ids='+join_selected_values,
                                              success: function (data) {
                                                  if (data['success']) {
              
                                                      toastr.success("Mark Stripe Paid successfully","Mail");
                                                      location.reload();
                                                  } else if (data['error']) {
                                                    toastr.error("Sorry Invoice Mark as not Stripe Paid","Mail");
                                                  } else {
                                                      alert('Whoops Something went wrong!!');
                                                  }
                                              },
                                              error: function (data) {
                                                  alert(data.responseText);
                                              }
                                          });
                               }
                          });
                        });

                      //// mark invoice OverDue
                      $(document).ready(function () {
                          $('#markOverdue').on('click', function(e) {
                              var allVals = [];  
                              var join_selected_values =[];
                                $(".sub_chk:checked").each(function() {  
                                    allVals.push($(this).attr('data-id'));

                                    join_selected_values = allVals.join(","); 

                                         
                                });

                                if(allVals.length <=0)  
                                    {  
                                        alert("Please select row.");  
                                    }  else {  
  

                                 $.ajax({
                                              url: '/invoice/mark-overdue',
                                              dataType: 'json',
                                              method : 'post',
                                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                              data: 'ids='+join_selected_values,
                                              success: function (data) {
                                                  if (data['success']) {
              
                                                      toastr.success("Mark Invoice Overdue successfully","Mail");
                                                      location.reload();
                                                  } else if (data['error']) {
                                                    toastr.error("Sorry Invoice Mark as not Overdue","Mail");
                                                  } else {
                                                      alert('Whoops Something went wrong!!');
                                                  }
                                              },
                                              error: function (data) {
                                                  alert(data.responseText);
                                              }
                                          });
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