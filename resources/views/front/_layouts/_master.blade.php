<!DOCTYPE html>
<html lang="en">
	
	@include('front._layouts._head')

	<body>
		<div class="main-page-wrapper home-page-two">

			@yield('content')

			@include('front._layouts._footer')
	
			<button class="scroll-top tran3s color-one-bg">
				<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
			</button>
			
			@include('front._layouts._jquery')

		</div>
	</body>
</html>