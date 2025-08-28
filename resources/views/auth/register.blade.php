@extends('layouts.web')

@section('content')
@livewire('get-started', ['plan' => $plan ?? null])
@endsection
