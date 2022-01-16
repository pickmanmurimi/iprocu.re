@component('mail::message')
    # Welcome To {{ config('app.name')  }} {{ $user->firstName }}

    Your Account has been successfully created.

    Your password has been set to  {{ $password }} .

    Thanks,
    {{ config('app.name') }}

@endcomponent
