@component('mail::message')

# Hi {{ $owner->name }},

{{ $sender->name }} sent a request to completed for <strong>{{ $project->title }}</strong>.

Please click on the below button and accept the request.

@component('mail::button', ['url' => $url])
Go To Contract
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
