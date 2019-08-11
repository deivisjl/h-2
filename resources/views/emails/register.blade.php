@component('mail::message')
# Hola {{ $user->name }}

Te damos la más cordial bienvenida a Herbalife. Tus usuario es:
{{ $user->email }} y para obtener tu contraseña deberás pulsar el botón

@component('mail::button', ['url' => route('credenciales', $user->token)])
Habilitar mi cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent