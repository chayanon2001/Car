@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="bg-dark p-4 rounded shadow-sm text-center text-white">
        <h1 class="mb-3">User</h1>
        <p class="lead mb-4">
            Welcome, <span class="text-info">{{ auth()->user()->name }}</span>
        </p>
    </div>
</div>
@endsection
