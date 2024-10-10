@extends('layouts.app')
@section('title')
    {{-- {{ __('messages.settings') }} --}}
    @section('title')
    @if ($sectionName === 'general')
        {{ __('General') }}
    @elseif ($sectionName === 'terms-conditions')
        {{ __('Terms-conditions') }}
    @elseif ($sectionName === 'google_analytics')
        {{ __('Google configuration') }}
    @elseif ($sectionName === 'payment_method')
        {{ __('Payment configuration') }}
    @else
        {{ __('messages.settings') }}
    @endif
@endsection

@endsection

@section('content')
    <div class="container-fluid">
        <div class="">
            @include('flash::message')
            @include('layouts.errors')
            {{-- @include('settings.setting_menu') --}}
            @yield('section')
        </div>
    </div>
@endsection
