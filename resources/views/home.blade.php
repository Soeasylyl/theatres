@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex gap-4">
            <div>
                @include('admin.menu')
            </div>

            <div class="row justify-content-center w-100">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
