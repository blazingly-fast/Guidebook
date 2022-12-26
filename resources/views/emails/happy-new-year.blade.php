@component('mail::message')
# Happy New Year {{ $user->first_name }} {{$user->last_name}}!

We wish you a happy and prosperous new year.

@component('mail::button', ['url' => url('/')])
Go to our website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
