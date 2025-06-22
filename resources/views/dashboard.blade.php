@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
    <p class="text-gray-700">You're logged in as {{ Auth::user()->role }}!</p>
@endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">
        <p class="text-gray-900">Kamu Login Sebagai {{ Auth::user()->role }}!</p>
    </div>