<p style="font-weigth:bold;font-family:Montserrat;font-size:14px;">E-mail de recuperación de contraseña:</p>

<p>Si deseas restablecer la contraseña haz click en la url para acceder a tu área de usuario y disfruta de todas las ventajas.</p>

<div style="background-color:#ccc;padding:10px;font-family:Montserrat;font-size:14px;">
	<a style="font-size:14px;" href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
</div>


<div style="background-color:#121424;height:80px;position: fixed; bottom:0;width:100%; margin-top:50px;">
	<img src="{!! asset('/img/'.Config::get('constantes.logo')) !!}" style="max-width:100px;margin 10px;">
</div>