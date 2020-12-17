@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Users</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List</h3>
                        </div>

                        <div class="box-body">
                          <div class="btn-group">
                            <a href="/user/create" class="btn btn-success btn-sm">
                                  <i class="fa fa-plus"></i> Add new
                              </a>
                              <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                  <i class="fa fa-refresh"></i> Refresh
                              </button>
                              <a href="/user" id="clearBtn" style="display: none;">
                                  <button type="button" class="btn btn-secondary btn-sm">Clear</button>
                              </a>
                          </div>
                        </div>

                        <div class="box-body">
                          <form action="/user/search" method="GET" id="SearchData" role="search"> 
                              <div class="input-group">
                                <input type="text" name="q" value="{{request('q')}}" id="search" class="form-control" placeholder="Search User by name, email, phone">
                                <div class="input-group-append">
                                  <button class="btn btn-secondary" type="submit" style="width: 80px;">
                                    <i class="fa fa-search"></i>
                                  </button>
                                </div>
                              </div>
                          </form>
                          <div class="col-md-12 col-sm-12 result-status">
                            @if(isset($message))
                                 <p>{{ $message }}</p>
                            @endif
                          </div>


                            <table class="table table-hover on-mob-scroll-table-full">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><input type="checkbox" id="master"> Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>ZipCode</th>
                                    <th>User</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $client)
                                    <tr class="clickable-row" data-href='/client/{{$client->id}}/view' style="cursor: pointer;">
                                        <td>{{ $client->id }}</td>
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$client->id}}" email-id="{{ $client->email }}">
                                          {{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>{{ $client->address }}</td>
                                        <td>{{ $client->city }}</td>
                                        <td>{{ $client->state }}</td>
                                        <td>{{ $client->country }}</td>
                                        <td>{{ $client->zipcode }}</td>
                                        <td>{{ $client->user }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $clients->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection