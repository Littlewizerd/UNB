@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">แก้ไขข้อมูลครู</h1>

    <div class="card" style="max-width: 600px;">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('teachers.update', $teacher) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name', $teacher->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รหัสครู <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('teacher_id') is-invalid @enderror" 
                           name="teacher_id" value="{{ old('teacher_id', $teacher->teacher_id) }}" required>
                    @error('teacher_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email', $teacher->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">โทรศัพท์</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           name="phone" value="{{ old('phone', $teacher->phone) }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">แผนก/สาขา <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('department') is-invalid @enderror" 
                           name="department" value="{{ old('department', $teacher->department) }}" required>
                    @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-warning">บันทึกการแก้ไข</button>
                <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-secondary">ยกเลิก</a>
            </form>
        </div>
    </div>
</div>
@endsection
