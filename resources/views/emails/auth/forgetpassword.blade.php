<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ $title }}</h2>

		<div>
			{!! $intro !!}.<br/> <br />
			{!! link_to($link, $link) !!}<br/> <br />
			{!! $expire !!}.
			<br/><br/>
			<h4>Thư được gửi từ: Omanage.techup.vn</h4>
		</div>
	</body>
</html>