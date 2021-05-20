@extends('Layout')
@section('title','Home Page')
@section('header')
    @parent
@endsection
@section('content')
    <img src='{{asset("Images\bank.svg")}}' alt="Bank Image" class="imgHome">
    <h2 class="txt1 txt2">WELCOME TO</h2>
    <h2 class="txt1">VS Basic Banking System</h2>
    <div style="height: 40vh"></div>
@endsection
@section('footer')
    @parent
@endsection