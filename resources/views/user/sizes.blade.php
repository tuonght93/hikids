@foreach ($sizes as $size)
	<option value="{{ $size->size_id }}">{{ $size->size->title }}</option>
@endforeach