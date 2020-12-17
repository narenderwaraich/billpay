@extends('layouts.homeApp')
@section('content')

          <!-- Error Message  -->
              @if(count($errors)>0)
                
              @foreach($errors ->all() as $error)

              <div class="alert alert-danger">
              {{$error}}
              </div>
              @endforeach
              @endif

              <!-- Success Message -->
              @if(session('success'))
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                  <span class="badge badge-pill badge-success">Success</span> {{session('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                 @endif

<div class="content mt-3">
            <div class="animated fadeIn">

              <center>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card" style="width: 600px; height: auto; text-align: left; margin-top: 70px;">
                        <div class="card-header">
                            <strong class="card-title">Account Verify</strong>
                        </div>
                        <div class="card-body">
                          <h4>Congratulations! your account is verify, <a href="/login" style="color: #33b5e5;">login now</a></h4>
                    	</div> <!-- .card -->

                  		</div><!--/.col-->
              		</div>
      			</div>
  			</center>
	</div>
</div>
@endsection