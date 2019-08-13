<div class="tab-pane" id="tech_gallery">
	@foreach ($preview->techGallery as $img)
	<div class="col-md-4">
		<div class="cbp-item identity logos">
			<a href="{{ url($img->image) }}" class="cbp-caption cbp-lightbox" target="_blank">
				<div class="cbp-caption-defaultWrap">
					<img src="{{ url($img->image) }}" alt="">
				</div>
			</a>
		</div>
	</div>
	@endforeach
</div>
