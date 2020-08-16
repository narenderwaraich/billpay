@extends('layouts.app')
@section('content')
        <div class="card stripe-connect-box">
                        <div class="card-header">
                            <strong class="card-title">Stripe Account</strong><span style="float: right;"><a href="/dashboard"><i class="fa fa-arrow-left"></i> Back</a></span>
                        </div>
                        <div class="card-body" style="text-align: left;">
        
                              
                                @if(!empty($stripe_key))
                                <a href="/disconnect-account"><button type="button" class="btn btn-lg btn-css connect-btn">Disconnect</button></a>
                                @else
                                   <a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id={{env('STRIPE_CLIENT_ID')}}&scope=read_write"><button type="button" class="btn btn-info btn-lg btn-css connect-btn">Connect</button></a>
                                @endif
                           
                            
                    <!-- <form method="post" action="/manage-stripe-account">
                         {{ csrf_field() }}
                        <div class="form-group">
                            <label>Stripe Key</label>

                            @if(!empty($stripe_key))
                            <input type="text" name="stripe_key" value="{{$stripe_key}}" class="form-control" placeholder="Enter Secrate Stripe Key">
    
                            @else

                            <input type="text" name="stripe_key"  class="form-control" placeholder="Enter Secrate Stripe Key">
                                
                            @endif
                        </div>
                        <button type="submit" class="btn btn-info btn-flat" style="width: 100%; border-radius: 20px;">Submit</button>
                    </form> -->
                </div>
        </div>
     
@endsection