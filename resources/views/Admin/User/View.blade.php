@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>User Details</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data <span style="float: right;"> <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                               <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
<i class="fa fa-refresh"></i> Refresh</button>
<a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" id="sendButton">
                                    <i class="fa fa-envelope"></i> Send Mail
                                </a>
                               <a href="/user/whatsapp/{{$user->id}}" class="btn btn-success btn-sm">
                                    <i class="fa fa-whatsapp"></i> Whatsapp
                                </a> 
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover on-mob-scroll-table-full">
                                <tr>
                                    <td>User ID</td>
                                    <td>{{ $user->id }}</td>
                                  </tr>
                                  <tr>
                                    <td>Company Name</td>
                                    <td>{{ $user->company_name }}</td>
                                  </tr>
                                  <tr>
                                    <td>Name</td>
                                    <td>{{ $user->name }}</td>
                                  </tr>
                                  <tr>
                                    <td>Email</td>
                                    <td>{{ $user->email }}</td>
                                  </tr>
                                  <tr>
                                    <td>Phone</td>
                                    <td>{{ $user->phone_no }}</td>
                                  </tr>
                                  <tr>
                                    <td>Image</td>
                                    <td>{{ $user->avatar }}</td>
                                  </tr>
                                
                                  <tr>
                                    <td>Address</td>
                                    <td>{{ $user->address }}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{ $user->country }}</td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>{{ $user->state }}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{ $user->city }}</td>
                                </tr>
                                <tr>
                                    <td>Zipcode</td>
                                    <td>{{ $user->zipcode }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>@if($user->verified == 1)
                                            <span class="user-active">Verified</span>
                                            @else
                                            <span class="user-deactive">Unverified</span>
                                            @endif
                                          </td>
                                  </tr>
                                  <tr>
                                    <td>Role</td>
                                    <td>{{ $user->role }}</td>
                                  </tr>
                            </table>

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection