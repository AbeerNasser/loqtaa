@php
    $flag = 0;
    if(isset($store))
        $flag=1;
@endphp

@extends('layouts.dashboard')

@if(!$flag)
    @section('title', 'إضافة متجر جديد')
@else
    @section('title', 'تعديل بيانات المتجر')
@endif
@section('content')
        <div class="section-body">
            <div class="container-fluid">
                <div class="row">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-12 col-lg-12">
                        <form class="card" method="POST" enctype="multipart/form-data"action="{{$flag? url('Dashboard/stores/'.$store->id):url('Dashboard/stores')}}">
                            @if($flag)
                                @method('put')
                            @endif
                            @csrf
                            <div class="card-body">
                                @if(!$flag)
                                <h3>إضافة متجر جديد</h3>
                                @else
                                <h3>تعديل بيانات المتجر</h3>
                                @endif
                                <hr /><br />
                                <div class="row">

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">إسم المتجر</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$flag? $store->user['name']: old('name') }}">
                                            @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">القسم</label>
                                            <select class="form-control custom-select" name="category_id">
                                                @foreach($cats as $cat)
                                                <option value="{{$cat->id}}" >{{$cat->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">صورة المتجر</label>
                                            <input type="file" class="form-control image" name="image">
                                        </div>
                                        <div class="form-group">
                                            <img src="{{$flag? asset('uploads/stores/'.$store->user['image']):asset('uploads/stores/default.jpg')}}" width="100px" class="img-thumbnail image-preview">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">عنوان المتجر</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$flag? $store->user['address']: old('address') }}">
                                            @error('address')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">رقم التليفون</label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$flag? $store->user['phone']: old('phone') }}">
                                            @error('phone')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">الرقم السري</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" >
                                            @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">تأكيد الرقم السري</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation">
                                            @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">وصف المتجر</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5">
                                                {{$flag? $store->description:old('description')  }}
                                            </textarea>
                                            @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label class="form-label">ملاحظات إضافية</label>
                                            <textarea rows="5" class="form-control " name="notes">
                                                {{$flag? $store->notes: old('notes')  }}
                                            </textarea>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
