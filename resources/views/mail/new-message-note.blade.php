@component('mail::message')

# Hi {{ $student->name }},
<p>There is a new message on project: {{ $message->project->title }}</p>

@component('mail::panel')
{{ $message->comment }}
@endcomponent

<p>Please click on below button to see the message.</p>

@component('mail::button', ['url' => route('dashboard.show.contract', $message->project->contract->id) . '#messages-files'])
Click to view your contract
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent