@extends('layouts.dashboard')

@section('title', 'عروض المتجر')
@section('content')

        <div class="section-body">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->hasPermission('offers_create'))
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#addOfferModal">إضافة عرض جديد</button><br />
                @else
                <button type="button" class="btn btn-danger btn-block disabled" data-toggle="modal" data-target="#addOfferModal">إضافة عرض جديد</button><br />
                @endif

                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover js-basic-example dataTable table_custom spacing5">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>صورة العرض</th>
                                        <th>وصف العرض</th>
                                        <th>سعر العرض</th>
                                        <th>عمليات</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>صورة العرض</th>
                                        <th>وصف العرض</th>
                                        <th>سعر العرض</th>
                                        <th>عمليات</th>
                                    </tr>
                                </tfoot>

                                <tbody class="text-center">
                                    @if (count($offers)==0)
                                        <tr>
                                            <td colspan="5" class="text-center">No Offers</td>
                                        </tr>
                                    @else
                                        @foreach ($offers as $index=>$offer)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>
                                                    <a href="{{$offer->image_path}}" target="_blank"><img src="{{$offer->image_path}}" width="100px" /></a>
                                                </td>
                                                <td>{{$offer->product}}</td>
                                                <td>{{$offer->price}}</td>
                                                <td>
                                                    @if(auth()->user()->hasPermission('stores_update'))
                                                    <button type="button" data-id="{{$offer->id}}" class="btn btn-secondary" data-toggle="modal" data-target="#editOfferModal">تعديل</button>
                                                    @else
                                                    <button type="button" data-id="{{$offer->id}}" class="btn btn-secondary disabled" data-toggle="modal" data-target="#editOfferModal">تعديل</button>
                                                    @endif

                                                    @if($offer->status==0)
                                                        <button type="button" data-id="{{$offer->id}}" class="btn btn-success" data-toggle="modal" data-target="#disableOfferModal">تعطيل مؤقت</button>
                                                    @else
                                                        <button type="button" data-id="{{$offer->id}}" class="btn btn-success" data-toggle="modal" data-target="#disableOfferModal">تم التعطيل</button>
                                                    @endif

                                                    @if(auth()->user()->hasPermission('offers_delete'))
                                                    <button type="button" data-id="{{$offer->id}}" class="btn btn-success" data-toggle="modal" data-target="#deleteOfferModal">حذف</button>
                                                    @else
                                                    <button type="button" data-id="{{$offer->id}}" class="btn btn-success disabled" data-toggle="modal" data-target="#deleteOfferModal">حذف</button>
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
    <div class="modal fade" id="deleteOfferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف عنصر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف هذا العرض ؟</p>
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
    <div class="modal fade" id="disableOfferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعطيل مؤقت</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من تعطيل هذا العرض ؟</p>
                </div>
                <div class="modal-footer">
                    <form id="activeForm" action="" method="post">
                        @csrf
                        @method('get')
                        <button type="submit" class="btn btn-danger">تأكيد</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addOfferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة عرض جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addForm" enctype="multipart/form-data" action="{{url('Dashboard/storeOffers')}}" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">صورة العرض</label>
                            <input type="file" class="form-control image" name="image" >
                        </div>
                        <div class="form-group">
                            <img src="{{asset('uploads/offers/default.png')}}" width="100px" class="img-thumbnail image-preview">
                        </div>
                        <div class="form-group">
                            <label class="form-label">وصف العرض</label>
                            <textarea class="form-control" name="product" rows="5"></textarea>
                            @error('product')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">سعر العرض</label>
                            <input type="number" class="form-control" name="price">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="store_id" value="{{$store}}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">حفظ البيانات</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editOfferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل العرض</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" enctype="multipart/form-data" action="" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">صورة العرض</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-group">
                            <label class="form-label">وصف العرض</label>
                            <textarea class="form-control" name="product" rows="5"></textarea>
                            @error('product')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">سعر العرض</label>
                            <input type="number" class="form-control" name="price">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="store_id" value="{{$store}}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">حفظ البيانات</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
