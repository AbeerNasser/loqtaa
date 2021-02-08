@extends('layouts.dashboard')

@section('title', 'الأقسام')
@section('content')

        <div class="section-body">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->hasPermission('categories_create'))
                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#addCatModal">إضافة قسم جديد</button><br />
                    @else
                    <button type="button" class="btn btn-danger btn-block disabled" data-toggle="modal" data-target="#addCatModal">إضافة قسم جديد</button><br />
                @endif

                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover js-basic-example dataTable table_custom spacing5 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>صورة القسم</th>
                                        <th>إسم القسم</th>
                                        <th>عمليات</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>صورة القسم</th>
                                        <th>إسم القسم</th>
                                        <th>عمليات</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (count($categories)==0)
                                        <tr>
                                            <td colspan="4" class="text-center">No Categories</td>
                                        </tr>
                                    @else
                                        @foreach ($categories as $index=>$category)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>
                                                    <a href="{{$category->image_path}}" target="_blank"><img src="{{$category->image_path}}" width="80px" /></a>
                                                </td>
                                                <td>{{$category->name}}</td>
                                                <td>
                                                    @if(auth()->user()->hasPermission('categories_update'))
                                                    <button type="button" data-id="{{$category->id}}" class="btn btn-success" data-toggle="modal" data-target="#editCatModal">تعديل</button>
                                                    @else
                                                    <button type="button" data-id="{{$category->id}}" class="btn btn-success" data-toggle="modal" data-target="#editCatModal">تعديل</button>
                                                    @endif

                                                    @if(auth()->user()->hasPermission('categories_delete'))
                                                    <button type="button" data-id="{{$category->id}}" class="btn btn-danger" data-toggle="modal" data-target="#deleteCatModal">حذف</button>
                                                    @else
                                                    <button type="button" data-id="{{$category->id}}" class="btn btn-danger disabled" data-toggle="modal" data-target="#deleteCatModal">حذف</button>
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
    <div class="modal fade" id="deleteCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف عنصر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف هذا القسم ؟</p>
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
    <div class="modal fade" id="addCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة قسم جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addForm" enctype="multipart/form-data" action="{{url('Dashboard/cats')}}" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">صورة القسم</label>
                            <input type="file" class="form-control image @error('image') is-invalid @enderror" name="image">
                        </div>
                        <div class="form-group">
                            <img src="{{asset('uploads/categories/default.jpg')}}" width="100px" class="img-thumbnail image-preview">
                        </div>
                        <div class="form-group">
                            <label class="form-label">إسم القسم</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
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
    <div class="modal fade" id="editCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" enctype="multipart/form-data" action="" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">صورة القسم</label>
                            <input type="file" class="form-control image" name="image">
                        </div>
                        <div class="form-group">
                            <label class="form-label">إسم القسم</label>
                            <input type="text" class="form-control" name="name">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">تعديل البيانات</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
