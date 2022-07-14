@component('mail::message')
@if ($status === 'declined')
# Hello {{ $offer->user->name }},
<p>An application that you submitted for, <strong>{{ $offer->project->title }}</strong> has been declined or expired.</p>
@else
# Congratulation to {{ $offer->user->name }},
<p>An application that you submitted for, <strong>{{ $offer->project->title }}</strong> has been approved by owner.</p>
<p>Please click on below link to view your contract.</p>
@component('mail::button', ['url' => $url])
View your contract
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
