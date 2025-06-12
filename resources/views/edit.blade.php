@extends('layout.app')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
</head>
<main class="main-wrapper">
    <div class="main-content">
<div class="container">
    <h2>تعديل الخدمة</h2>
    <form action="{{ route('update-sub-services', $subService->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">العنوان</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $subService->title }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" id="description" class="form-control">{{ $subService->description }}</textarea>
        </div>
        <div class="mb-3">
        <input  type="file" name="image" class="form-control @error('image')is-invalid @enderror" accept="image/*">
        @error('image')
        <span class="text-danger invalid-feedback">{{ $message }}</span>
    @enderror
    <img  src="{{ url( $subService->image )}}" alt="Current Image" style="max-width: 100%; margin-top: 10px;">
</div>
        <div class="mb-3">
            <label for="governorate_id" class="form-label">المحافظة</label>
            <select name="governorate_id" id="governorate_id" class="form-select">
                @foreach($governorates as $governorate)
                    <option value="{{ $governorate->id }}" {{ $subService->governorate_id == $governorate->id ? 'selected' : '' }}>
                        {{ $governorate->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="center_governorate_id" class="form-label">المركز</label>
    <select name="center_governorate_id[]" id="center_governorate_id" class="form-select" multiple>
    @foreach($centerGovernorates as $center)
        <option value="{{ $center->id }}"
            {{ in_array($center->id, $subService->subServicesGovernments->pluck('center_governorate_id')->toArray()) ? 'selected' : '' }}>
            {{ $center->name }}
        </option>
    @endforeach
</select>


        </div>

        <div class="row my-4">
            <div class="col-md-6">
              <input required type="text" value="{{ $subService->whatsapp }}" name="whatsapp" class="form-control @error('whatsapp')is-invalid @enderror" placeholder="أدخل الواتس">
              @error('whatsapp')
              <span class="text-danger invalid-feedback">{{ $message }}</span>
          @enderror
            </div>
            <div class="col-md-6">
              <input value="{{ $subService->phone }}" required type="text" name="phone" class="form-control @error('phone')is-invalid @enderror" placeholder="أدخل الهاتف">
              @error('phone')
              <span class="text-danger invalid-feedback">{{ $message }}</span>
          @enderror
            </div>
          </div>

        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
    </form>
</div>

    </div>
</main>
@endsection

  @section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const element = document.getElementById('center_governorate_id');
    const choices = new Choices(element, {
      removeItemButton: true,
      placeholderValue: 'اختر مركز',
      searchPlaceholderValue: 'ابحث...',
      maxItemCount: 10000000000000000000000, // اختياري، تحدد الحد الأقصى للاختيارات
      shouldSort: false
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  @endsection
