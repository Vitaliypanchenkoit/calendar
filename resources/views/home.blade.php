@extends('layouts.app')

@section('content')
    <div id="calendar">
        <router-view :currentYear={{ $year }} :currentMonth={{ $month }}></router-view>
    </div>
@endsection
