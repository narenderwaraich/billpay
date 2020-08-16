@extends('layouts.master')
@section('content')

<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">Mail</strong><span style="float: right;"><a href="/admin"><i class="fa fa-arrow-left"></i> Back</a></span>
					</div>
					<div class="card-body">
						<!-- Credit Card -->
						<div id="pay-invoice">
							<div class="card-body">
								<div class="card-title">
									<h3 class="text-center">Admin Mail</h3>
								</div>
								<hr>
								<form action="/admin-mail" method="post">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<label>Email</label>
												@if(isset($mail))
												<input type="email" class="form-control" name="value" placeholder="Enter Email" value="{{$mail->value}}" required>
												@else
												<input type="email" class="form-control" name="value" placeholder="Enter Email" required>
												@endif
											</div>
										</div>
									</div>
									<button id="saveForm" type="submit" class="btn btn-sm btn-info" style="width: 100px;">
										@if(isset($mail))
										<span>Update</span>
										@else
										<span>Submit</span>
										@endif
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function refreshPage(){
		window.location.reload();
	}
</script>
@endsection