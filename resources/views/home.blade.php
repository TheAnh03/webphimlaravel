@extends('layouts.app')

@section('content')
<div class="container"> 
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Xin chào {{ auth()->user()->name }}!</p></p>
</div>
@endsection
