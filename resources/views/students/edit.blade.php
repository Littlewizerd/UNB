@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">แก้ไขข้อมูลนักเรียน</h1>

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

            <form action="{{ route('students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name', $student->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รหัสนักเรียน <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_id') is-invalid @enderror" 
                           name="student_id" value="{{ old('student_id', $student->student_id) }}" required>
                    @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email', $student->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">โทรศัพท์</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           name="phone" value="{{ old('phone', $student->phone) }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">ชั้นเรียน <span class="text-danger">*</span></label>
                    <select class="form-select @error('class_id') is-invalid @enderror" name="class_id" required>
                        <option value="">-- เลือกชั้นเรียน --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }} ({{ $class->class_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-warning">บันทึกการแก้ไข</button>
                <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">ยกเลิก</a>
            </form>
        </div>
    </div>
</div>
@endsection
