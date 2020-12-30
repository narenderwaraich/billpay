@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>Setting</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/settings/update" method="post">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit <span style="float: right;"><a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="tax">Admin Email</label>
                                    <input type="text" class="form-control{{ $errors->has('admin_mail') ? ' is-invalid' : '' }}" name="admin_mail" placeholder="Enter Admin Email" value="{{ $data->admin_mail }}">
                                    @if ($errors->has('admin_mail'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('admin_mail') }}</strong>
                                        </span>
                                    @endif
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