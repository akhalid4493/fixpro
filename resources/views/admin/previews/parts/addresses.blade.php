<div class="form-group">
	<label class="control-label">
		العناوين
		<span class="required">*</span>
	</label>
	<select name="address_id" id="single" class="form-control select2" >
		<option></option>
		@foreach ($addresses as $address)
		<option value="{{$address->id}}">
			{{ $address->addressProvince->governorate->name_ar . ' - ' . $address->address }}
		</option>
		@endforeach
	</select>
</div>
