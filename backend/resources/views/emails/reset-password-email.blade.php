@component('mail::message')
# Hey, {{ $user->name }}

Your FoxedFolio password can be reset by clicking the button below. 
If you did not request a new password, just ignore this email.

@component('mail::button', ['url' =>  url('/#/reset/account?token=' . $user->reset_password_token)])
Reset Password
@endcomponent

Yours Securely,<br>
FoxedFolio Dev. Team
@endcomponent
