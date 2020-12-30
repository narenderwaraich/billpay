@extends('layouts.app')
@section('content')  
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
    <div class="content">
		<section class="chat-plan-section">
			    <div class="container">
		    		<div class="row chat-plan-list">
		    			@foreach ($plans as $plan)
		    			<div class="col-md-4" style="margin-top: 30px;">
		    				<div class="plan-box @if($plan->id==6) top-plan animation-css @endif">
		    					<div class="plan-name"><span>Name</span> <span>{{ $plan->name }}</span></div>
		    					<div class="plan-day"><span>Day</span>  <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $plan->access_day }} day</span> </div>
		    					<div class="plan-message"><span>Invoices</span> <span><i class="fa fa-file" aria-hidden="true"></i> {{ $plan->invoices }}</span> </div>
		    					<div class="plan-amount"><span>Amount</span> <span><i class="fa fa-inr" aria-hidden="true"></i> {{ $plan->amount }}</span> </div>
		    					<a href="/buy-plan/{{ $plan->id }}" class="btn btn-style btn-top">Buy</a>
		    				</div>
		    			</div>
		    			@endforeach
		    		</div>
			    </div>
		</section>
	</div>
      <!-- end content section -->
<style type="text/css">
	.footer {
    margin-top: 0px;
	}
	.top-plan{
		background: #000;
		border: 5px solid #ce2350 !important;
	}
	@keyframes blink { 
   50% { border-color: #00C851;
   background-color:  transparent;} 
}
.animation-css{ 
    animation: blink .5s step-end infinite alternate;
}
</style>
@endsection