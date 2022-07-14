@component('mail::message')
# Hello, {{ $invite->user->name }}

You have been invited to work on project <strong>{{ $invite->project->title }}</strong>

@component('mail::button', ['url' => $url])
View Invitation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
