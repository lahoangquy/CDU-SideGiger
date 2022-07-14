@component('mail::message')
# Hello {{ $offer->project->poster->name }},
<p>There was a new proposal on your project: <strong>{{  $offer->project->title }}</strong></p>

@component('mail::button', ['url' => $url])
Click to view proposal
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent