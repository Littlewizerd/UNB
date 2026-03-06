@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">แก้ไขชั้นเรียน</h1>

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

            <form action="{{ route('classes.update', $class) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ชื่อชั้นเรียน <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('class_name') is-invalid @enderror" 
                           name="class_name" value="{{ old('class_name', $class->class_name) }}" required>
                    @error('class_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รหัสชั้นเรียน <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('class_code') is-invalid @enderror" 
                           name="class_code" value="{{ old('class_code', $class->class_code) }}" required>
                    @error('class_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">ระดับชั้น <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('level') is-invalid @enderror" 
                           name="level" value="{{ old('level', $class->level) }}" placeholder="เช่น ม.1" required>
                    @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">อาจารย์ที่ปรึกษา <span class="text-danger">*</span></label>
                    <select class="form-select @error('advisor_id') is-invalid @enderror" name="advisor_id" required>
                        <option value="">-- เลือก --</option>
                        @foreach($advisors as $advisor)
                            <option value="{{ $advisor->id }}" {{ old('advisor_id', $class->advisor_id) == $advisor->id ? 'selected' : '' }}>
                                {{ $advisor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('advisor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">หมายเหตุ</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description', $class->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning">บันทึกการแก้ไข</button>
                <a href="{{ route('classes.show', $class) }}" class="btn btn-secondary">ยกเลิก</a>
            </form>
        </div>
    </div>
</div>
@endsection
