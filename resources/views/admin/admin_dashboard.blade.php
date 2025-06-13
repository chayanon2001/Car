@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="bg-dark p-4 rounded shadow-sm text-center text-white">
        <h1 class="mb-3">Admin</h1>
        <p class="lead mb-4">
            Welcome, <span class="text-info">{{ auth()->user()->name }}</span>
        </p>
        <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg px-5">
            จัดการรถ
        </a>
        <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg px-5">
            จัดการ User
        </a>
    </div>
</div>
@endsection
