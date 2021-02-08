@extends('layouts.dashboard')

@section('title', 'الإعلانات')
@section('content')
        <div class="section-body">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->hasPermission('ads_create'))
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#addAdModal">إضافة إعلان جديد</button><br />
                    @else
                    <button type="button" class="btn btn-danger btn-block disabled" data-toggle="modal" data-target="#addAdModal">إضافة إعلان جديد</button><br />
                @endif

                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover js-basic-example dataTable table_custom spacing5 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>صورة الإعلان</th>
                                        <th>نص الإعلان</th>
                                        <th>رابط التحويل</th>
                                        <th>عمليات</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>صورة الإعلان</th>
                                        <th>نص الإعلان</th>
                                        <th>رابط التحويل</th>
                                        <th>عمليات</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (count($ads)==0)
                                        <tr>
                                            <td colspan="5" class="text-center">No Ads</td>
                                        </tr>
                                    @else
                                        @foreach ($ads as $index=>$ad)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>
                                                    <a href="{{$ad->image_path}}" target="_blank"><img src="{{$ad->image_path}}" width="100px" /></a>
                                                </td>
                                                <td>{{$ad->description}}</td>
                                                <td>{{$ad->urlink}}</td>
                                                <td>
                                                    @if(auth()->user()->hasPermission('ads_update'))
                                                    <button type="button" data-id="{{$ad->id}}" class="btn btn-success" data-toggle="modal" data-target="#editAdModal">تعديل</button>
                                                    @else
                                                   <button type="button" data-id="{{$ad->id}}" class="btn btn-success disabled" data-toggle="modal" data-target="#editAdModal">تعديل</button>
                                                    @endif

                                                    @if(auth()->user()->hasPermission('ads_delete'))
                                                    <button type="button" data-id="{{$ad->id}}" class="btn btn-danger" data-toggle="modal" data-target="#deleteAdModal">حذف</button>
                                                    @else
                                                    <button type="button" data-id="{{$ad->id}}" class="btn btn-danger disabled" data-toggle="modal" data-target="#deleteAdModal">حذف</button>
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
    <div class="modal fade" id="deleteAdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف إعلان</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف هذا الإعلان ؟</p>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addAdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة إعلان جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addForm" enctype="multipart/form-data" action="{{url('Dashboard/ads')}}" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">صورة الإعلان</label>
                            <input type="file" class="form-control image @error('image') is-invalid @enderror" name="image" >
                        </div>
                        <div class="form-group">
                            <img src="{{asset('uploads/ads/default.jpeg')}}" width="100px" class="img-thumbnail image-preview">
                        </div>
                        <div class="form-group">
                            <label class="form-label">نص الإعلان</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{old('description')}}">
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">رابط التحويل</label>
                            <input type="url" class="form-control @error('urlink') is-invalid @enderror" name="urlink" value="{{old('urlink')}}">
                            @error('urlink')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
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
    <div class="modal fade" id="editAdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل الإعلان</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" enctype="multipart/form-data" action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">صورة الإعلان</label>
                            <input type="file" class="form-control image @error('image') is-invalid @enderror" name="image" >
                        </div>
                        <div class="form-group">
                            <label class="form-label">نص الإعلان</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{old('description')}}">
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">رابط التحويل</label>
                            <input type="url" class="form-control @error('urlink') is-invalid @enderror" name="urlink" value="{{old('urlink')}}">
                            @error('urlink')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">حفظ البيانات</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="editAdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل الإعلان</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" enctype="multipart/form-data" action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">صورة الإعلان</label>
                            <input type="file" class="form-control image @error('image') is-invalid @enderror" name="image" >
                        </div>
                        <div class="form-group">
                            <img src="{{$ad->image_path}}" width="100px" class="img-thumbnail image-preview">
                        </div>
                        <div class="form-group">
                            <label class="form-label">نص الإعلان</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{$ad->description}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">رابط التحويل</label>
                            <input type="url" class="form-control @error('urlink') is-invalid @enderror" name="urlink" value="{{$ad->urlink}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">حفظ البيانات</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection
