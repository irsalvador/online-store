@extends('layouts.app')

@section('content')
<div class="container">
    @if(auth()->user()->user_type === 'admin')
        {{-- Render the admin view --}}
        <script>window.location = "{{ route('admin.products.index') }}";</script>
    @else
        {{-- Render the customer view --}}
        @include('customer.index')
    @endif
</div>
@endsection
