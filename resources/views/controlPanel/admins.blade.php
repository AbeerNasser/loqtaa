@extends('layouts.dashboard')

@section('title', 'المشرفين')
@section('content')

        <div class="section-body">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->hasPermission('users_create'))
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#addUserModal">إضافة مستخدم جديد</button><br />
                @else
                <button type="button" class="btn btn-danger btn-block disabled">إضافة مستخدم جديد</button><br />
                @endif

                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="table-responsive mb-4">
                            <table class="table table-hover js-basic-example dataTable table_custom spacing5 text-center">
                                <thead>
                                    <tr>
                                        <th>إسم المستخدم</th>
                                        <th>رقم الهاتف</th>
                                        <th>الرتبة</th>
                                        <th>عمليات</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>إسم المستخدم</th>
                                        <th>رقم الهاتف</th>
                                        <th>الرتبة</th>
                                        <th>عمليات</th>
                                    </tr>
                                </tfoot>
                                <tbody >
                                    @if (count($usersRol)==0)
                                        <tr>
                                            <td colspan="5" class="text-center">No Admins</td>
                                        </tr>
                                    @else
                                        @foreach ($usersRol as $role)
                                         @foreach ($role['users'] as $index=>$us)
                                            <tr>
                                                <td>{{$us->name}}</td>
                                                <td>{{$us->phone}}</td>
                                                <td>{{$role->display_name}}</td>
                                                <td>
                                                    @if(auth()->user()->hasPermission('users_update'))
                                                    <button type="button" data-id="{{$us->id}}" class="btn btn-secondary" data-toggle="modal" data-target="#editUserModal">تعديل</button>
                                                    @else
                                                    <button type="button" class="btn btn-secondary disabled">تعديل</button><br />
                                                    @endif

                                                    @if(auth()->user()->hasPermission('users_delete'))
                                                    <button type="button" data-id="{{$us->id}}" class="btn btn-danger" data-toggle="modal" data-target="#deleteUserModal">حذف</button>
                                                    @else
                                                    <button type="button" class="btn btn-danger disabled">حذف</button><br />
                                                    @endif
                                                </td>
                                            </tr>
                                         @endforeach
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
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

    <!-- Add Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة مستخدم جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addForm" action="{{url('Dashboard/admins')}}" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">إسم المستخدم</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
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
                            <label class="form-label">الرتبة</label>
                            <select class="form-control" name="role">
                                <option>اختر رتبة ...</option>
                                <option value="admin">مدير عام</option>
                                <option value="auditor">مراجع حسابات</option>
                                <option value="support">دعم فني</option>
                            </select>
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
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات مستخدم سابق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">إسم المستخدم</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
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
