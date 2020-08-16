@extends('layouts.master')
@section('content')
    
      <div class="admin-user-show">
        <div class="user-profile-pic">
          <img src="/images/avatar/{{$user->avatar}}" class="user-pro-img">
        </div>
        <br>
        <div class="user-info">
          <span class="user-info-data">Name</span>
          <span class="user-info-value">{{$user->fname}} {{$user->lname}}</span>
        </div>
        <div class="user-info">
          <span class="user-info-data">Email</span>
          <span class="user-info-value">{{$user->email}}</span>
        </div>
        <div class="user-info">
          <span class="user-info-data">Mobile</span>
          <span class="user-info-value">{{$user->phone_no}}</span>
        </div>
        <div class="user-info">
          <span class="user-info-data">Company Name</span>
          <span class="user-info-value">{{$user->company_name}}</span>
        </div>
        <div class="user-info">
          <span class="user-info-data">Country</span>
          <span class="user-info-value">{{$user->country}}</span>
        </div>
        <div class="user-info">
          <span class="user-info-data">State</span>
          <span class="user-info-value">{{$user->state}}</span>
        </div>
        <div class="user-info">
          <span class="user-info-data">City</span>
          <span class="user-info-value">{{$user->city}}</span>
        </div>
        <div class="user-info">
          <span class="user-info-data">Zipcode</span>
          <span class="user-info-value">{{$user->zipcode}}</span>
        </div>
        <div class="user-info">
          <span class="user-info-data">Address</span>
          <span class="user-info-value">{{$user->address}}</span>
        </div>
      </div>

@endsection