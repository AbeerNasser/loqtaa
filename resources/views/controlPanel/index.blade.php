@extends('layouts.dashboard')

@section('title', 'الصفحة الرئيسية')
@section('content')
        <div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="mb-4">
                            <h2>رئيسية لوحة تحكم النظام</h2>
                            <small>الصفحة الرئيسية للوحة تحكم نظام تطبيق لقطة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card">
                            <div class="card-body ribbon">
                                <div class="ribbon-box green counter">{{$stors}}</div>
                                <a
                                    @if(auth()->user()->hasPermission('stores_read'))
                                        href="{{url('Dashboard/stores')}}"
                                    @else
                                        href=""
                                    @endif
                                     class="my_sort_cut text-muted">
                                    <i class="icon-rocket"></i>
                                    <span>المتاجر</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card">
                            <div class="card-body ribbon">
                                <div class="ribbon-box green counter">{{$delegates}}</div>
                                    <a
                                        @if(auth()->user()->hasPermission('delegates_read'))
                                        href="{{url('Dashboard/salesReps')}}"
                                        @else
                                            href=""
                                        @endif
                                        class="my_sort_cut text-muted">
                                        <i class="icon-users"></i>
                                        <span>المناديب</span>
                                    </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card">
                            <div class="card-body ribbon">
                                <div class="ribbon-box green counter">{{$categories}}</div>
                                <a
                                    @if(auth()->user()->hasPermission('categories_read'))
                                        href="{{url('Dashboard/cats')}}"
                                    @else
                                        href=""
                                    @endif
                                 class="my_sort_cut text-muted">
                                    <i class="fa fa-cube"></i>
                                    <span>الأقسام</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card">
                            <div class="card-body ribbon">
                                <div class="ribbon-box green counter">{{$ads}}</div>
                                <a
                                    @if(auth()->user()->hasPermission('ads_read'))
                                        href="{{url('Dashboard/ads')}}"
                                    @else
                                        href=""
                                    @endif
                                 class="my_sort_cut text-muted">
                                    <i class="fa fa-gift"></i>
                                    <span>الإعلانات</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2">
                        <div class="card">
                            <div class="card-body ribbon">
                                <div class="ribbon-box green counter">{{$users}}</div>
                                <a
                                    @if(auth()->user()->hasPermission('ads_read'))
                                        href="{{url('Dashboard/admins')}}"
                                    @else
                                        href=""
                                    @endif
                                    class="my_sort_cut text-muted">
                                    <i class="icon-user"></i>
                                    <span>المشرفين</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection
