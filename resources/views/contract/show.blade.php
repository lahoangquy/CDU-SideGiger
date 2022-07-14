@extends('layouts.app')

@section('content')
   <contract-show :contract-id="{{ $contractId }}" /> 
@endsection