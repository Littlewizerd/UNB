@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">สร้างชั้นเรียนใหม่</h1>

    <div class="card" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('classes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">ชื่อชั้นเรียน</label>
                    <input type="text" class="form-control @error('class_name') is-invalid @enderror" 
                           name="class_name" value="{{ old('class_name') }}" required>
                    @error('class_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รหัสชั้นเรียน</label>
                    <input type="text" class="form-control @error('class_code') is-invalid @enderror" 
                           name="class_code" value="{{ old('class_code') }}" required>
                    @error('class_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">ระดับชั้น</label>
                    <input type="text" class="form-control @error('level') is-invalid @enderror" 
                           name="level" value="{{ old('level') }}" placeholder="เช่น ม.1" required>
                    @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">อาจารย์ที่ปรึกษา</label>
                    <select class="form-select @error('advisor_id') is-invalid @enderror" name="advisor_id" required>
                        <option value="">-- เลือก --</option>
                        @foreach($advisors as $advisor)
                            <option value="{{ $advisor->id }}" {{ old('advisor_id') == $advisor->id ? 'selected' : '' }}>
                                {{ $advisor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('advisor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">หมายเหตุ</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">สร้าง</button>
                <a href="{{ route('classes.index') }}" class="btn btn-secondary">ยกเลิก</a>
            </form>
        </div>
    </div>
</div>
@endsection
