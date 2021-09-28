@extends('layouts.app')

@section('content')
    <script>
        window.currentUser = @json($currentUser);
    </script>
    <div id="calendar">
        <router-view></router-view>
    </div>
@endsection
