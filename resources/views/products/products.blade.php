@extends('layouts/app')

@section('title', 'Products')

@push('footer-scripts')
@endpush

@section('body')
<div class="">
    {{-- @include('layouts.admin-layout') --}}
    <div class="pt-12">
        <products></products>
    </div>
</div>
@endsection