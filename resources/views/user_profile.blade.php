@extends('layouts.app')
@section('content')  
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
	<div class="content">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Edit Profile</h5>
              </div>
              <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <input type="text" class="form-control" disabled="">
                        <label>Company (disabled)</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input type="text" class="form-control">
                        <label>Username</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="email" class="form-control">
                        <label>Email address</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control">
                        <label>First Name</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control">
                        <label>Last Name</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control">
                        <label>Address</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="text" class="form-control">
                        <label>City</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="text" class="form-control">
                        <label>Country</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="number" class="form-control">
                        <label>Postal Code</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea rows="4" cols="80" class="form-control">Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</textarea>
                        <label>About Me</label>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- end col -->
          <div class="col-lg-4">
          	            <div class="card card-user">
              <div class="image">
                <img src="../assets/img/bg5.jpg" alt="...">
              </div>
              <div class="card-body">
                <div class="author">
                  <a href="#">
                    <img class="avatar border-gray" src="../assets/img/mike.jpg" alt="...">
                    <h5 class="title">Mike Andrew</h5>
                  </a>
                  <p class="description">
                    michael24
                  </p>
                </div>
              </div>
              <hr>
              <div class="button-container">

              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
      </div>
      <!-- end content section -->
@endsection