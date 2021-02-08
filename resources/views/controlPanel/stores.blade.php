@extends('layouts.dashboard')

@section('title', 'المتاجر')
@section('content')
        <div class="section-body">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->hasPermission('stores_create'))
                <a href="stores/create" class="btn btn-danger btn-block">إضافة متجر جديد</a><br />
                @else
                <a href="stores/create" class="btn btn-danger btn-block disabled">إضافة متجر جديد</a><br />
                @endif

                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover js-basic-example dataTable table_custom spacing5 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>صورة المتجر</th>
                                        <th>إسم المتجر</th>
                                        <th>وصف المتجر</th>
                                        <th>عنوان المتجر</th>
                                        <th>رقم التليفون</th>
                                        <th>عمليات</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>صورة المتجر</th>
                                        <th>إسم المتجر</th>
                                        <th>وصف المتجر</th>
                                        <th>عنوان المتجر</th>
                                        <th>رقم التليفون</th>
                                        <th>عمليات</th>
                                    </tr>
                                </tfoot>
                                <tbody >
                                    @if (count($stores)==0)
                                        <tr>
                                            <td colspan="7" class="text-center">No Stores</td>
                                        </tr>
                                    @else
                                        @foreach ($stores as $index=>$store)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>
                                                    <a href="{{asset('uploads/stores/'.$store->user['image'])}}" target="_blank"><img src="{{asset('uploads/stores/'.$store->user['image'])}}" width="100px" /></a>
                                                </td>
                                                <td>{{$store->user['name']}}</td>
                                                <td>{{$store->description}}</td>
                                                <td>{{$store->user['address']}}</td>
                                                <td>{{$store->user['phone']}}</td>
                                                <td>
                                                    @if(auth()->user()->hasPermission('stores_update'))
                                                        <a href="{{url('Dashboard/stores/'.$store->id.'/edit')}}" class="btn btn-secondary">تعديل</a>
                                                    @else
                                                        <a href="{{url('Dashboard/stores/'.$store->id.'/edit')}}" class="btn btn-secondary disabled">تعديل</a>
                                                    @endif

                                                    <a href="{{url('Dashboard/storOffers/'.$store->id)}}" class="btn btn-secondary"><i class="fa fa-gift"></i> العروض </a>
                                                    @if($store->temp_disable==0)
                                                    <button type="button" data-id="{{$store->id}}" class="btn btn-success" data-toggle="modal" data-target="#disableStoreModal">تعطيل مؤقت</button>
                                                    @else
                                                    <button type="button" data-id="{{$store->id}}" class="btn btn-success" data-toggle="modal" data-target="#disableStoreModal">تم التعطيل</button>
                                                    @endif

                                                    @if(auth()->user()->hasPermission('stores_delete'))
                                                    <button type="button" data-id="{{$store->id}}" class="btn btn-success" data-toggle="modal" data-target="#deleteStoreModal">حذف</button>
                                                    @else
                                                    <button type="button" data-id="{{$store->id}}" class="btn btn-success disabled" data-toggle="modal" data-target="#deleteStoreModal">حذف</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteStoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف عنصر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف هذا العنصر ؟</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Disable Modal -->
    <div class="modal fade" id="disableStoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعطيل مؤقت</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من تعطيل هذا المتجر ؟</p>
            </div>
            <div class="modal-footer">
                <form id="editForm" action="" method="post">
                    @csrf
                    @method('get')
                    <button type="submit" class="btn btn-danger">تأكيد</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
            </div>
        </div>
        </div>
    </div>

@endsection
