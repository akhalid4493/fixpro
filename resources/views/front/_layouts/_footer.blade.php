<footer>
	<div class="container">
		<div class="footer-data-wrapper">
			<form action="#" class="subscribe-form">
				<h2>Subscirbe  Our Newslatter!!</h2>
				<div class="input-wrapper">
					<div class="row">
						<div class="col-md-5 col-md-6 col-xs-12">
							<input type="text" placeholder="Full Name*">
						</div>
						<div class="col-md-5 col-md-6 col-xs-12">
							<input type="email" placeholder="Email Address*">
						</div>
						<div class="col-md-2 col-xs-12">
							<div class="theme-button">
								<span></span>
								<input type="submit" value="SIGN UP">
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="bottom-footer">
				<div class="row">
					<div class="col-lg-6 col-md-7 col-xs-12 text-right pull-right">
						<ul class="social-icon">
							<li>
								<a href=" {{ url(settings('facebook')) }}" class="tran3s">
									<i class="fa fa-facebook" aria-hidden="true"></i>
								</a>
							</li>
							<li>
								<a href=" {{ url(settings('twitter')) }}" class="tran3s">
									<i class="fa fa-twitter" aria-hidden="true"></i>
								</a>
							</li>
							<li>
								<a href=" {{ url(settings('instagram')) }}" class="tran3s">
									<i class="fa fa-instagram" aria-hidden="true"></i>
								</a>
							</li>
							<li>
								<a href=" {{ url(settings('linkedin')) }}" class="tran3s">
									<i class="fa fa-linkedin" aria-hidden="true"></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="col-lg-6 col-md-5 col-xs-12 footer-logo">
						<div class="logo"><a href="#.">
							<img src="{{ url(settings('logo')) }}" alt="Logo" style="width:72px;">
						</a></div>
						<p>{{ settings('footer_en') }}</p>
					</div>
					</div> <!-- /.row -->
					</div> <!-- /.bottom-footer -->
				</div>
				</div> <!-- /.container -->
			</footer>