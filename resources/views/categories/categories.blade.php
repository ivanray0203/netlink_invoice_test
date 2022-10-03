@extends('layouts/app')

@section('title', 'Categories')

@push('footer-scripts')
@endpush

@section('body')
<div class="">
    {{-- @include('layouts.admin-layout') --}}
    <div class="p-10">
        <categories></categories>
    </div>
</div>
@endsection