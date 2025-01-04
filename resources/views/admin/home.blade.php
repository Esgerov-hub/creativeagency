@extends('admin.layouts.app')
@section('admin.title')
    @lang('admin.dashboard')
@endsection
@section('admin.css')
@endsection
@section('admin.content')
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>@lang('admin.dashboard')</h2>
        </div>
        @if ( Session::get('error'))
            <div class="col-12 mt-1">
                <div class="alert alert-danger" role="alert">
                    <div class="alert-body">{{ Session::get('error') }}</div>
                </div>
            </div>
        @endif
        @if (Session::get('success'))
            <div class="col-12 mt-1">
                <div class="alert alert-success" role="alert">
                    <div class="alert-body">{{ Session::get('success') }}</div>
                </div>
            </div>
        @endif
        <div class="row mb-25">
            <div class="col-lg-3 col-6 col-xs-12">
                <div class="dashboard-top-box rounded-bottom panel-bg">
                    <div class="left">
                        <h3>$34,152</h3>
                        <p>Shipping fees are not</p>
                        <a href="#">View net earnings</a>
                    </div>
                    <div class="right">
                        <span class="text-primary">+16.24%</span>
                        <div class="part-icon rounded">
                            <span><i class="fa-light fa-dollar-sign"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6 col-xs-12">
                <div class="dashboard-top-box rounded-bottom panel-bg">
                    <div class="left">
                        <h3>36,894</h3>
                        <p>Orders</p>
                        <a href="#">Excluding orders in transit</a>
                    </div>
                    <div class="right">
                        <span class="text-primary">+16.24%</span>
                        <div class="part-icon rounded">
                            <span><i class="fa-light fa-bag-shopping"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6 col-xs-12">
                <div class="dashboard-top-box rounded-bottom panel-bg">
                    <div class="left">
                        <h3>$34,152</h3>
                        <p>Customers</p>
                        <a href="#">See details</a>
                    </div>
                    <div class="right">
                        <span class="text-primary">+16.24%</span>
                        <div class="part-icon rounded">
                            <span><i class="fa-light fa-user"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6 col-xs-12">
                <div class="dashboard-top-box rounded-bottom panel-bg">
                    <div class="left">
                        <h3>$724,152</h3>
                        <p>My Balance</p>
                        <a href="#">Withdraw</a>
                    </div>
                    <div class="right">
                        <span class="text-primary">+16.24%</span>
                        <div class="part-icon rounded">
                            <span><i class="fa-light fa-credit-card"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin.js')
@endsection
