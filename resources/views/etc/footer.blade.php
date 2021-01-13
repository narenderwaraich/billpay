<footer>
	<div class="container-fluid bg-black-color">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="footer-content">
						<h4 class="text-uppercase text-strong">About Our Company</h4>
						<p class="fs-20"><em>"Go Paperless Invoices with Bill Book. All invoices store on server and download in your system."</em><p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="footer-content">
						<h4 class="text-uppercase text-strong">Contact Us</h4>
						<!-- <p><i class="fa fa-map-marker" aria-hidden="true"></i><b>Adress:</b> Responsive Street 7, London, UK</p> -->
						<p><a href="mail:{{config('app.admin_email')}}" class="text-primary-hover"><i class="fa fa-envelope" aria-hidden="true"></i>{{config('app.admin_email')}}</a></p>
						<p><a href="tel:{{config('app.phone')}}" class="text-primary-hover"><i class="fa fa-phone" aria-hidden="true"></i>{{config('app.phone')}}</a></p>
						<p><a href="/whatsapp" target="_blank" class="text-primary-hover"><i class="fa fa-whatsapp" aria-hidden="true"></i>Whatsapp</a></p>
						<p><a href="{{config('app.facebook')}}" target="_blank" class="text-primary-hover"><i class="fa fa-facebook" aria-hidden="true"></i>Facebook</a></p>
						<p><a href="{{config('app.instagram')}}" target="_blank" class="text-primary-hover"><i class="fa fa-instagram" aria-hidden="true"></i>Instagram</a></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="footer-content footer-form-section">
						<h4 class="text-uppercase text-strong">Leave a Message</h4>
						<form action="/contact-us" method="POST" class="footer-form text-white m-t-8">
							{{ csrf_field() }}
						<div class="row">
		                    <div class="col-md-6">
		                      <input name="email" class="required email border-radius" placeholder="Email" title="Your e-mail" type="text" />
		                    </div>
		                    <div class="col-md-6">
		                      <input name="name" class="name border-radius" placeholder="Name" title="Your name" type="text" />
		                    </div>
		                </div>
		                 <textarea name="message" class="required message border-radius" placeholder="Message" rows="3"></textarea>
		                <button class="submit-form button border-radius" type="submit">Send</button> 
		              </form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- bottom footer -->
	<div class="container-fluid bg-red-color">
		<div class="container">
			<div class="bottom-footer">
				<div class="row">
					<div class="col-md-4">
						<small>&copy; Copyright <span id="currentYear"></span>, {{config('app.copy_tag')}}</small>
					</div>
					<div class="col-md-8">
						<ul class="bottom-footer-menu">
					        <li class="bottom-footer-menu-item {{ (request()->is('term-of-services')) ? 'active' : '' }}">
					          <a class="bottom-footer-menu-item-link text-up" href="/term-of-services">Term Of Services</a>
					        </li>
					        <li class="bottom-footer-menu-item {{ (request()->is('privacy-policy')) ? 'active' : '' }}">
					          <a class="bottom-footer-menu-item-link text-up" href="/privacy-policy">Privacy Policy</a>
					        </li>
					    </ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end -->
</footer>
<script>
	var d = new Date(); 
	$('#currentYear').text(d.getFullYear());
</script>