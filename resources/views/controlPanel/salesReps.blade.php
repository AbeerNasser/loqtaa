@extends('layouts.dashboard')

@section('title', 'المناديب')
@section('content')

        <div class="section-body">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->hasPermission('delegates_create'))
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#addDeleModal">إضافة مندوب جديد</button><br />
                @else
                <button type="button" class="btn btn-danger btn-block disabled" data-toggle="modal" data-target="#addDeleModal">إضافة مندوب جديد</button><br />
                @endif

                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover js-basic-example dataTable table_custom spacing5 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>إسم المندوب</th>
                                        <th>رقم البطاقة</th>
                                        <th>رقم التليفون</th>
                                        <th>عمليات</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>إسم المندوب</th>
                                        <th>رقم البطاقة</th>
                                        <th>رقم التليفون</th>
                                        <th>عمليات</th>
                                    </tr>
                                </tfoot>
                                <tbody >
                                    @if (count($delegates)==0)
                                        <tr>
                                            <td colspan="5" class="text-center">No salesReps</td>
                                        </tr>
                                    @else
                                        @foreach ($delegates as $index=>$delegate)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$delegate->user['name']}}</td>
                                                <td>{{$delegate->national_id}}</td>
                                                <td>{{$delegate->user['phone']}}</td>
                                                <td>
                                                    @if(auth()->user()->hasPermission('delegates_update'))
                                                    <button type="button" data-id="{{$delegate->id}}" class="btn btn-secondary" data-toggle="modal" data-target="#editDeleModal">تعديل</button>
                                                    @else
                                                    <button type="button" data-id="{{$delegate->id}}" class="btn btn-secondary disabled" data-toggle="modal" data-target="#editDeleModal">تعديل</button>
                                                    @endif

                                                    @if($delegate->temp_disable==0)
                                                    <button type="button" data-id="{{$delegate->id}}" class="btn btn-success" data-toggle="modal" data-target="#disableDeleModal">تعطيل مؤقت</button>
                                                    @else
                                                    <button type="button" data-id="{{$delegate->id}}" class="btn btn-success" data-toggle="modal" data-target="#disableDeleModal">تم التعطيل</button>
                                                    @endif

                                                    @if(auth()->user()->hasPermission('delegates_delete'))
                                                    <button type="button" data-id="{{$delegate->id}}" class="btn btn-success" data-toggle="modal" data-target="#deleteDeleModal">حذف</button>
                                                    @else
                                                    <button type="button" data-id="{{$delegate->id}}" class="btn btn-success disabled" data-toggle="modal" data-target="#deleteDeleModal">حذف</button>
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
    <div class="modal fade" id="deleteDeleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="disableDeleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعطيل مؤقت</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من تعطيل هذا المندوب ؟</p>
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
    <div class="modal fade" id="addDeleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة مندوب جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addForm" action="{{url('Dashboard/salesReps')}}" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">إسم المندوب</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم البطاقة</label>
                            <input type="number" class="form-control @error('national_id') is-invalid @enderror" name="national_id">
                            @error('national_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم التليفون</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone">
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">الرقم السري</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">تأكيد الرقم السري</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation">
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
    <div class="modal fade" id="editDeleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات مندوب</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">إسم المندوب</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم البطاقة</label>
                            <input type="number" class="form-control @error('national_id') is-invalid @enderror" name="national_id">
                            @error('national_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم التليفون</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone">
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">الرقم السري</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">تأكيد الرقم السري</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation">
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

@endsection
