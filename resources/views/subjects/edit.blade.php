@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">แก้ไขข้อมูลวิชา</h1>

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

            <form action="{{ route('subjects.update', $subject) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ชื่อวิชา <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name', $subject->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รหัสวิชา <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('subject_code') is-invalid @enderror" 
                           name="subject_code" value="{{ old('subject_code', $subject->subject_code) }}" required>
                    @error('subject_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">หน่วยกิต</label>
                    <input type="number" class="form-control @error('credits') is-invalid @enderror" 
                           name="credits" value="{{ old('credits', $subject->credits) }}" min="1" max="4">
                    @error('credits') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">ผู้สอน <span class="text-danger">*</span></label>
                    <select class="form-select @error('teacher_id') is-invalid @enderror" name="teacher_id" required>
                        <option value="">-- เลือกผู้สอน --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รายละเอียด</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              name="description" rows="3">{{ old('description', $subject->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-warning">บันทึกการแก้ไข</button>
                <a href="{{ route('subjects.show', $subject) }}" class="btn btn-secondary">ยกเลิก</a>
            </form>
        </div>
    </div>
</div>
@endsection
