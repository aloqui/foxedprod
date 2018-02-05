@component('mail::message')
# One Last Step

We just need you to confirm your email address, to prove that you're human.

<br> Please use the following code to confirm your identity: <br>
## {{ $user->confirmation_token }}

<br> or click the button below.<br>
@component('mail::button', ['url' => url('/#/register/confirm?token=' . $user->confirmation_token)])
Confirm Email
@endcomponent

Yours Securely,<br>
FoxedFolio Dev Team
@endcomponent
