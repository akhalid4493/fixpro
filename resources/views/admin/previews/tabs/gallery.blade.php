<div class="tab-pane" id="gallery">
	<div id="js-grid-juicy-projects" class="cbp">
		@foreach ($preview->gallery as $img)
		<div class="cbp-item graphic">
			<div class="cbp-caption">
				<div class="cbp-caption-defaultWrap">
					<img src="{{ url($img->image) }}" alt="">
				</div>
				<div class="cbp-caption-activeWrap">
					<div class="cbp-l-caption-alignCenter">
						<div class="cbp-l-caption-body">
							<a href="{{ url($img->image) }}" class="cbp-lightbox cbp-l-caption-buttonRight btn red uppercase btn red uppercase">view</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>