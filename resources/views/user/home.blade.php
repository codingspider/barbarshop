@extends('user.layouts.app')
@section('title', 'Home')
@section('content')
@if(\Auth::guard('user')->user()?->user_type == 'user')
<div class="container py-4" style="max-width: 900px; min-width: 800px" id="content-body">
    <!-- Barber Cards -->
    
</div>
@endif

@endsection

@push('extra_css')
  <style>
    body {
      background-color: #fff;
      font-family: Arial, sans-serif;
    }
    .barber-card img {
      width: 100%;
      border-radius: 12px;
    }
    .barber-card {
      text-align: center;
    }
    .status-badge {
      display: inline-block;
      padding: 4px 10px;
      background: #e5e5e5;
      border-radius: 6px;
      font-size: 12px;
      margin-top: 5px;
    }
    .order-btn {
      border: 1px solid grey;
      padding: 12px;
      border-radius: 8px;
      font-size: 20px;
      font-weight: bold;
      width: 100%;
      text-align: center;
      cursor: pointer;
      background: none;
    }
  </style>
@endpush