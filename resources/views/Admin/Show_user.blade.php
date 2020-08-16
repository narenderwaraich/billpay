@extends('layouts.master')
@section('content')
<div class="content mt-3" style="background-color: #fff;">
<div class="col-4 col-sm-5 col-md-4 col-lg-3 col-xl-2" style="padding-top: 15px;">
  <h5>USER</h5>
</div> 
    <div class="search-bar">
        <form action="/user/search" method="GET" id="SearchData" role="search">  
          <div class="col-md-2" style="clear: both;">
            <div class="dropdown btn-move">
              <button type="button" class="btn dropdown-toggle action-btn mobile-view-action-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="action-btn" disabled="disabled">
                ACTIONS <span class="caret"></span>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item action-list editUser" href="#" id="editButton" style="display: none;">EDIT</a>
                <a class="dropdown-item action-list activeUser" href="#" id="activeButton" style="display: none;">ACTIVE</a>
                <a class="dropdown-item action-list deactiveUser" href="#" id="deactiveButton" style="display: none;">SUSPEND</a>
                <a class="dropdown-item action-list delete_all" href="#">DELETE</a>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <input type="text" name="q" value="{{request('q')}}" id="search" class="form-control serach-input" placeholder="Search by Name, Email, Mobile number">
          </div>
          <div class="col-md-2 search-icon-div m-t-15" style="padding-left: 0px;">
              <div class="col-md-3">
                 <button type="submit" class="search-btn" id="searchBtn"><img src="/images/search_btn.png"><span class="search-icon-title">Search</span></button>
              </div>
              <div class="col-md-9">
                 <a href="/user/show"><button type="button" class="clear-btn-icon" id="clear-btn" style="margin-top: -3px;"><img src="/images/delete-invoice-icon.svg" width="34px"> <br><span class="clear-icon-title">Clear</span></button></a>
            </div>         
          </div>
        </form>
    </div> <!-- end row -->
                  <div class="col-xs-6 col-md-12 col-sm-12 result-status">
                    @if(isset($message))
                         <p>{{ $message }}</p>
                    @endif
                    <!-- <span id="record">@if( ! empty( $total_row)) {{ $total_row}} Invoice found match your search @else Invoice not found match Your search @endif</span> --></div>
                  
                  
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-t-35">
                  <div class="table-responsive">
                        <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col" class="table-heading"><input type="checkbox" id="master"> NAME
                                  <th scope="col" class="table-heading">EMAIL</th>
                                  <th scope="col" class="table-heading">MOBILE</th>
                                  <th scope="col" class="table-heading">COMPANY</th>
                                  <th scope="col" class="table-heading hide-data-mobile-view">PLAN</th>
                                  <th scope="col" class="table-heading">PLAN STATUS</th>
                                  <th scope="col" class="table-heading">USER STATUS
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                               @if(isset($users))
                  
                                @foreach ($users as $key => $user)
                                <tr id="tr_{{$user->id}}" class="clickable-row" data-href='/user/{{$user->id}}/edit' style="cursor: pointer;">
                                  
                                  <td scope="row" class="td-inv-name"><input type="checkbox" class="sub_chk" data-id="{{$user->id}}" email-id="{{ $user->email }}"> {{ $user->fname }}  {{ $user->lname }}</td>
                                  <td class="td-inv-name">{{ $user->email}}</td>
                                  <td class="td-inv-name">{{ $user->phone_no }}</td>
                                  <td class="td-inv-name">{{ $user->company_name }}</td>
                                  <td class="td-inv-name">{{$user->plan}}</td>
                                  <td>
                                        @if($user->plan_status == 1)
                                            <span style="color: #138E60;">Active</span>
                                        @endif
                                        @if($user->plan_status == 0)
                                            <span style="color: #f37914;">Inactive</span>
                                        @endif
                                  </td>
                                  <td>
                                    @if($user->is_activated == 1)
                                    <span style="color: #138E60;">Active</span>
                                    @else
                                    <span style="color: #f37914;">Inactive</span>
                                    @endif
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            @if($users){!! $users->render() !!}@endif
                            
                            @endif
                       </div>
                     </div>






    </div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->
<style>
    body{
        background-color: #fff;
    }
    .table thead th,
    .table td {
    padding: 10px 5px;
}
</style>
<script src="{{ asset('js/vendor/jquery-2.1.4.min.js') }}"></script>
<script  src="{{ asset('js/adminPage.js') }}"></script>
@endsection