<option value="">Chọn Quận / Huyện</option>
@foreach ($districts as $district)
	<option value="{{ $district->id }}">{{ $district->name }}</option>
@endforeach