@extends('layouts.default')

@section('content')
    <header-component></header-component>
    <div class="container">
        <router-view></router-view>
    </div>
@endsection