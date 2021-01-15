@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>User</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/user/update/{{ $user->id }}" method="post" enctype="multipart/form-data" autocomplete="">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit <span style="float: right;"> <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>
                            <div class="box-body">
                              <div class="form-group">
                                    <label for="title">Company Name</label>
                                        <input type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" placeholder="Enter Company Name" value="{{ $user->company_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="title">Name</label>
                                    <div class="row">
                                      <div class="col-6">
                                        <input type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" placeholder="Enter First Name" value="{{ $user->fname }}">
                                      </div>
                                      <div class="col-6">
                                        <input type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" placeholder="Enter Last Name" value="{{ $user->lname }}">
                                      </div>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label for="title">Email</label>
                                     <div class="row">
                                      <div class="col-6"><input type="text" class="form-control" name="" value="{{ $user->email}}" readonly></div>
                                      <div class="col-6"><input type="email "class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Change Email" value="">
                                        @if ($errors->has('email'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('email') }}</strong>
                                          </span>
                                          @endif
                                      </div>
                                    </div>
                              
                                
                                 </div>
                                  <div class="form-group">
                                    <label for="title">Password</label>
                                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Enter Password">
                                  </div>
                                  @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                                  <div class="form-group">
                                    <label for="title">Phone</label>
                                    <input type="text" class="form-control {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{ $user->phone_no }}" placeholder="Enter Phone">
                                    @if ($errors->has('phone_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_no') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                 <div class="form-group">
                                    <label for="title">Role</label>
                                      <select class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"  name="role">
                                        <option value="admin" disabled @if ($user->role == "admin") {{ 'selected' }} @endif>Admin</option>
                                        <option value="administrator" @if ($user->role == "administrator") {{ 'selected' }} @endif>Administrator</option>
                                        <option value="user" @if ($user->role == "user") {{ 'selected' }} @endif>User</option>
                                        <option value="editor" @if ($user->role == "editor") {{ 'selected' }} @endif>Editor</option>
                                        <option value="author" @if ($user->role == "author") {{ 'selected' }} @endif>Author</option>
                                        <option value="astrologer" @if ($user->role == "astrologer") {{ 'selected' }} @endif>Astrologer</option>
                                      </select>
                                 </div>

                                 
                            </div>

                            <div class="box-footer">
                              <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </div>
                        </div>
                    </form>
                  </div>
              </div>
        </section>
</section>
@endsection