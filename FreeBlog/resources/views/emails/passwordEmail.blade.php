<p>
	<b>Querido {{ $user->name }}</b>
</p>
<p>Aquí esta la contraseña de tu cuenta</p>
<p><b>{{ $passwordTemp }}</b></p>
<br>
<br>
{{ env('APP_NAME') }}
<br>
<a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a>