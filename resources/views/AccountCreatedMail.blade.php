@component('mail::message')
    # Welcome To {{ config('app.name')  }} {{ $user->firstName }}

    Your Account has been successfully created.

    Your password has been set to  <b>{{ $password }}</b> .

<a href="{{$url}}"> {{$url}} </a>

    Thanks,
    {{ config('app.name') }}

@endcomponent
