@component('mail::message')
@if ($status === 'declined')
# Hello {{ $invite->project->poster->name }},
<p>Your invitation for project, <strong>{{ $invite->project->title }}</strong> has been declined.</p>
@else
# Congratulation to {{ $invite->project->poster->name }},
<p>Your invitation for project, <strong>{{ $invite->project->title }}</strong> has been accepted.</p>
<p>Please click on below link to view your contract.</p>
@component('mail::button', ['url' => $url])
View your contract
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
