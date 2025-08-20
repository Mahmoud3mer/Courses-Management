@extends('layouts.app')

@section('title', '3mer courses')

@section('content')
    <div class="col-12">
        <div class="d-flex justify-content-center align-items-center flex-column" style="margin-bottom: 50px;">
            {{-- <h1>Welcome, {{ Auth::user()->name }}!</h1> --}}
            @auth
                <h1>Welcome, {{ auth()->user()->name }}!</h1>
            @endauth

            <p>أنت مسجل الدخول.</p>
            <form class="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
            </form>
        </div>

        <h1 style="text-align: center">
            مرحبًا بكم في (3mer courses)
        </h1>
        <p style="text-align: center">
            الحل الشامل لجميع احتياجاتك التعليمية.
        </p>
        <img src="{{ asset('learning-education-ideas-insight-intelligence-study-concept.jpg') }}" alt=""
            style="width: 100%; height: auto; border-radius: 10px;">
    </div>
@endsection
