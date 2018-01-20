@component('mail::message')
# One Last Step

We just need you to confirm your email address, to prove that you're human.

@component('mail::button', ['url' => 'localhost:8080/#/register/confirm?token=' . $user->confirmation_token])
Confirm Email
@endcomponent

Thanks,<br>
FoxedFolio Dev Team
@endcomponent
