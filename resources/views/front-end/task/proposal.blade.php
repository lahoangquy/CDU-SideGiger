@extends('layouts.app')

@section('content')
    <task-proposal :project-id="{{ json_encode($projectId) }}" />
@stop
