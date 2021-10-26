@extends('layouts.app')

@section('content')
    <script>
        window.currentUser = @json($currentUser);
        window.goTo = @json($goTo);
    </script>
    <div id="calendar">
        <router-view></router-view>
    </div>
@endsection
