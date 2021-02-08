<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="author" content="Sedra Technology">

        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon"/>
        <title> @yield('title') </title>

        <!-- Bootstrap Core and vandor -->
        <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" />

        <!-- Plugins css -->
        <link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/c3.min.css')}}"/>
        <link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jvectormap-2.0.3.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css')}}">

        <style>
            td.details-control {
            background: url('../assets/images/details_open.png') no-repeat center center;
            cursor: pointer;
            }
            tr.shown td.details-control {
                background: url('../assets/images/details_close.png') no-repeat center center;
            }
        </style>
        <!-- Core css -->
        <link rel="stylesheet" href="{{asset('assets/css/main.css')}}"/>
        <link rel="stylesheet" href="{{asset('assets/css/theme1.css')}}" id="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
    </head>

    <body class="font-opensans iconcolor rtl">

        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
            </div>
        </div>

        <!-- Start main html -->
        <div id="main_content">

            <!-- Small icon top menu -->
            <div id="header_top" class="header_top">
                <div class="container">
                    <div class="hleft">
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="nav-link user_btn"><img class="avatar" src="{{asset('assets/images/user.png')}}" alt=""/></a>
                            <a href="{{url('home')}}" class="nav-link icon"><i class="fa fa-home"></i></a>
                            <a
                                @if(auth()->user()->hasPermission('users_read'))
                                    href="{{url('Dashboard/admins')}}"
                                @else
                                    href=""
                                @endif
                                class="nav-link icon app_inbox"><i class="fa fa-users"></i>
                            </a>
                            <a
                                @if(auth()->user()->hasPermission('ads_read'))
                                    href="{{url('Dashboard/ads')}}"
                                @else
                                    href=""
                                @endif
                              class="nav-link icon xs-hide"><i class="fa fa-gift"></i>
                            </a>
                            <a
                                @if(auth()->user()->hasPermission('stores_read'))
                                    href="{{url('Dashboard/stores')}}"
                                @else href="" @endif
                                class="nav-link icon app_file xs-hide"><i class="fa fa-university"></i>
                            </a>
                        </div>
                    </div>
                    <div class="hright">
                        <div class="dropdown">
                            <a href="reports.html" class="nav-link icon settingbar"><i class="fa fa-file"></i></a>
                            <a href="javascript:void(0)" class="nav-link icon menu_toggle"><i class="fa fa-navicon"></i></a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- start User detail -->
            <div class="user_div">
                <h5 class="brand-name mb-4">{{ Auth::user()->name }}<a href="javascript:void(0)" class="user_btn"><i class="icon-close"></i></a></h5>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">بيانات المستخدم</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{ Auth::user()->phone }}</li>
                        <li class="list-group-item">{{ Auth::user()->roles[0]['display_name'] }}</li>
                    </ul>
                </div>
            </div>

            <!-- start Main menu -->
            <div id="left-sidebar" class="sidebar">
                <div class="d-flex justify-content-between brand_name">
                    <h5 class="brand-name">تطبيق لقطة</h5>
                    <div class="theme_btn">
                        <a class="theme1" data-toggle="tooltip" title="التصميم الأحمر" href="#" onclick="setStyleSheet('{{asset('assets/css/theme1.css')}}', 0);"></a>
                        <a class="theme2" data-toggle="tooltip" title="التصميم الأخضر" href="#" onclick="setStyleSheet('{{asset('assets/css/theme2.css')}}', 0);"></a>
                        <a class="theme3" data-toggle="tooltip" title="التصميم الأزرق" href="#" onclick="setStyleSheet('{{asset('assets/css/theme3.css')}}', 0);"></a>
                        <a class="theme4" data-toggle="tooltip" title="التصميم الرمادي" href="#" onclick="setStyleSheet('{{asset('assets/css/theme4.css')}}', 0);"></a>
                    </div>
                </div>
                <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="fe fe-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="بحث ...">
                </div>
                <ul class="nav nav-tabs b-none">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#all-tab"> الروابط </a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting-tab">المظهر </a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="all-tab">
                        <nav class="sidebar-nav">
                            <ul class="metismenu ci-effect-1">

                                <li class="g_heading">رئيسية النظام</li>
                                <li class="active">
                                    <a href="{{url('home')}}"><i class="fa fa-home"></i><span data-hover="الصفحة الرئيسية">الصفحة الرئيسية</span></a>
                                </li>

                                <li class="g_heading">أساسيات النظام</li>
                                <li>
                                    <a
                                        @if(auth()->user()->hasPermission('stores_read'))
                                            href="{{url('Dashboard/stores')}}"
                                        @else href="" @endif
                                    ><i class="fa fa-university"></i><span data-hover="المتاجر">المتاجر</span></a>
                                </li>

                                <li>
                                    <a
                                        @if(auth()->user()->hasPermission('delegates_read'))
                                            href="{{url('Dashboard/salesReps')}}"
                                        @else
                                            href=""
                                        @endif ><i class="fa fa-male"></i><span data-hover="المناديب">المناديب</span>
                                    </a>
                                </li>

                                <li>
                                    <a
                                        @if(auth()->user()->hasPermission('categories_read'))
                                            href="{{url('Dashboard/cats')}}"
                                        @else
                                            href=""
                                        @endif >
                                        <i class="fa fa-cube"></i><span data-hover="الأقسام">الأقسام</span>
                                    </a>
                                </li>

                                <li>
                                    <a
                                        @if(auth()->user()->hasPermission('users_read'))
                                            href="{{url('Dashboard/admins')}}"
                                        @else
                                            href=""
                                        @endif ><i class="fa fa-users"></i><span data-hover="المشرفين">المشرفين</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        @if(auth()->user()->hasPermission('users_read'))
                                            href="{{url('Dashboard/users')}}"
                                        @else
                                            href=""
                                        @endif ><i class="fa fa-users"></i><span data-hover="العملاء">العملاء</span>
                                    </a>
                                </li>

                                <li>
                                    <a
                                        @if(auth()->user()->hasPermission('ads_read'))
                                            href="{{url('Dashboard/ads')}}"
                                        @else
                                            href=""
                                        @endif ><i class="fa fa-gift"></i><span data-hover="الإعلانات">الإعلانات</span>
                                    </a>
                                </li>

                                <li class="g_heading">الإدارة والتقارير</li>
                                <li>
                                    <a href="{{url('Dashboard/support')}}"><i class="fa fa-support"></i><span data-hover="الدعم الفني">الدعم الفني</span></a>
                                </li>
                                <li>
                                <a href="{{url('Dashboard/reports')}}"><i class="fa fa-file"></i><span data-hover="التقارير">التقارير</span></a>
                                </li>
                                <li>
                                <a href="{{url('Dashboard/settings')}}"><i class="fa fa-cogs"></i><span data-hover="الإعدادات">الإعدادات</span></a>
                                </li>

                            </ul>
                        </nav>
                    </div>

                    <div class="tab-pane fade" id="setting-tab">
                        <div class="mb-4 mt-3">
                            <h6 class="font-14 font-weight-bold text-muted">نوع الخط</h6>
                            <div class="custom-controls-stacked font_setting">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="font" value="font-opensans" checked="">
                                    <span class="custom-control-label">الخط الرئيسي</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="font" value="font-poppins">
                                    <span class="custom-control-label">خط بوبينس</span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="font-14 font-weight-bold text-muted">أيقونة القائمة المنسدلة</h6>
                            <div class="custom-controls-stacked arrow_option">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="marrow" value="arrow-a" checked="">
                                    <span class="custom-control-label">1</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="marrow" value="arrow-b">
                                    <span class="custom-control-label">2</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="marrow" value="arrow-c">
                                    <span class="custom-control-label">3</span>
                                </label>
                            </div>
                            <h6 class="font-14 font-weight-bold mt-4 text-muted">أيقونة القائمة الفرعية</h6>
                            <div class="custom-controls-stacked list_option">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="listicon" value="list-a" checked="">
                                    <span class="custom-control-label">1</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="listicon" value="list-b">
                                    <span class="custom-control-label">2</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="listicon" value="list-c">
                                    <span class="custom-control-label">3</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <h6 class="font-14 font-weight-bold mt-4 text-muted">إعدادات المظهر الرئيسية</h6>
                            <ul class="setting-list list-unstyled mt-1 setting_switch">
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">الوضع الليلي</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-darkmode">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">تثبيت الجزء العلوي</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-fixnavbar">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">تعتيم الجزء العلوي</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-pageheader">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">تعتيم القائمة الجانبية الفرعية</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-min_sidebar">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">تعتيم القائمة الجانبية الأساسية</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-sidebar">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">تلويين الأيقونات</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-iconcolor" checked="">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">تدريج الألوان</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-gradient">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">ظل للأزرار</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-boxshadow">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-switch">
                                        <span class="custom-switch-description">التنسيق العربي</span>
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-rtl" checked="">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- start main body part-->
            <div class="page">

                <!-- start body header -->
                <div id="page_top" class="section-body">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="left">
                                <h1 class="page-title"> تطبيق لقطة</h1>
                            </div>
                            <div class="right">
                                <div class="notification d-flex">
                                    <button type="button" class="btn btn-facebook"><i class="fa fa-info-circle mr-2"></i>الدعم الفني</button>

                                    <a type="button" class="btn btn-facebook" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power-off mr-2"></i>تسجيل الخروج
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @yield('content')


                <!-- Start page footer -->
                <div class="section-body">
                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    جميع الحقوق محفوظة © 2021 تطبيق لقطة, تطوير  <a href="https://sedrait.com" target="_blank">شركة سِدره للبرمجيات</a>.
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>


        <!-- jQuery and bootstrtap js -->
        <script src="{{asset('assets/bundles/lib.vendor.bundle.js')}}"></script>

        <!-- start plugin js file  -->
        <script src="{{asset('assets/bundles/apexcharts.bundle.js')}}"></script>
        <script src="{{asset('assets/bundles/counterup.bundle.js')}}"></script>
        <script src="{{asset('assets/bundles/knobjs.bundle.js')}}"></script>
        <script src="{{asset('assets/bundles/c3.bundle.js')}}"></script>
        <script src="{{asset('assets/bundles/flot.bundle.js')}}"></script>
        <script src="{{asset('assets/bundles/jvectormap1.bundle.js')}}"></script>
        <script src="{{asset('assets/bundles/dataTables.bundle.js')}}"></script>
        <script src="{{asset('assets/bundles/selectize.bundle.js')}}"></script>

        <!-- Start core js and page js -->
        <script src="{{asset('assets/js/core.js')}}"></script>
        <script src="{{asset('assets/js/page/index.js')}}"></script>
        <script src="{{asset('assets/js/table/datatable.js')}}"></script>
        <script src="{{asset('assets/js/vendors/selectize.js')}}"></script>


        <script>
            //stores
            $('#deleteStoreModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#deleteForm').attr("action", "{{url('Dashboard/stores')}}" + "/" + id);
            });
            $('#disableStoreModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#editForm').attr("action", "{{url('Dashboard/activeStore')}}" + "/" + id);
            });

            //storeOffers
            $('#deleteOfferModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#deleteForm').attr("action", "{{url('Dashboard/storeOffers')}}" + "/" + id);
            });
            $('#disableOfferModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#activeForm').attr("action", "{{url('Dashboard/activeOffer')}}" + "/" + id);
            });
            $('#editOfferModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                console.log(id);
                $('#editForm').attr("action","{{url('Dashboard/storeOffers') }}" + "/" + id);
            });

            //delegates
            $('#deleteDeleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#deleteForm').attr("action", "{{url('Dashboard/salesReps')}}" + "/" + id);
            });
            $('#disableDeleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#activeForm').attr("action", "{{url('Dashboard/activeDelegate')}}" + "/" + id);
            });
            $('#editDeleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                console.log(id);
                $('#editForm').attr("action","{{url('Dashboard/salesReps') }}" + "/" + id);
            });
            // categories
            $('#deleteCatModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#deleteForm').attr("action", "{{url('Dashboard/cats')}}" + "/" + id);
            });
            $('#editCatModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                console.log(id);
                $('#editForm').attr("action","{{url('Dashboard/cats') }}" + "/" + id);
            });

            //ads
            $('#deleteAdModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#deleteForm').attr("action", "{{url('Dashboard/ads')}}" + "/" + id);
            });
            $('#editAdModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#editForm').attr("action", "{{url('Dashboard/ads')}}" + "/" + id);
            });

            //users
            $('#deleteUserModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#deleteForm').attr("action", "{{url('Dashboard/users')}}" + "/" + id);
            });
            $('#editUserModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $('#editForm').attr("action", "{{url('Dashboard/users')}}" + "/" + id);
            });

            //image preview
            $(".image").change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.image-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }
            });
        </script>
    </body>
</html>
