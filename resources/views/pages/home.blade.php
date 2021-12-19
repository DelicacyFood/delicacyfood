@extends('layouts.master')
@section('title', 'Blank Page')
@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Blank Page</h1>
    </div>
    <p>{{$totalBayar->value}}</p>
    <div class="section-body"></div>
  </section>
</div>
<!-- End Main Content -->
@endsection