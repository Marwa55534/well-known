```blade
@extends('layout.app')
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
</head>
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="add mt-3 mb-3 text-end d-flex justify-content-end">
                            <button class="btn btn-primary" data-bs-target="#addservice" data-bs-toggle="modal"> <i class="fas fa-add"></i> اضافة صاحب الخدمة</button>
                        </div>
                        <div class="table-responsive text-center">
                            @if(session('delete'))
                            <div class="alert alert-success">
                                {{ session('delete') }}
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الوصف</th>
                                        <th>الصوره</th>
                                        <th>المحافظة</th>
                                        <th>المركز</th>
                                        <th>الخدمة</th>
                                        <th>واتس</th>
                                        <th>الفون</th>
                                        <th>التحكم</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subservices as $subservice)
                                    <tr>
                                        <td>{{ $subservice->title }}</td>
                                        <td>{{ $subservice->description }}</td>
                                        <td><img src="{{ asset($subservice->image) }}" width="100px" alt="صورة"></td>
                                        <td>{{ $subservice->governorate->name ?? null }}</td>
                                        <td>{{ $subservice->centerGovernorate->name ?? null }}</td>
                                        <td>{{ $subservice->service->name ?? null }}</td>
                                        <td>{{ $subservice->whatsapp }}</td>
                                        <td>{{ $subservice->phone }}</td>
                                        <td class="d-flex justify-content-center align-items-center">
                                         <button type="button" class="btn btn-warning ms-2" onclick="window.location.href='/sub-services/{{ $subservice->id }}/edit'">
                          <i class="fas fa-edit"></i>
                      </button>
                                            <form action="{{ route('delete-sub-services', $subservice->id) }}" method="post" class="m-0">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="9">لا يوجد اصحاب خدمات</td>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $subservices->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Service Modal -->
        <div class="modal fade" id="addservice" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="UserModalLabel">اضافة</h5>
                        <div class="text-start">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('create-sub-services') }}" method="POST" enctype="multipart/form-data" id="addServiceForm">
                            @csrf
                            <div class="container">
                                <div class="row my-4">
                                    <div class="col-md-6">
                                        <input required type="text" name="title" class="form-control @error('title')is-invalid @enderror" placeholder="أدخل الاسم">
                                        @error('title')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input required type="file" name="image" id="imageInput" class="form-control @error('image')is-invalid @enderror" accept="image/*">
                                        @error('image')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <img id="imagePreviewAdd" src="" alt="Image Preview" style="max-width: 100%; margin-top: 10px; display: none;">
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-6">
                                        <input required type="text" name="description" class="form-control @error('description')is-invalid @enderror" placeholder="أدخل الوصف">
                                        @error('description')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <select id="service_id" name="service_id" class="form-select" data-placeholder="اختر الخدمة" data-select-all="false" data-max="1">
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-6">
                                        <select id="governorate_id" name="governorate_id" class="form-select" data-placeholder="اختر محافظة" data-select-all="false" data-max="1">
                                            @forelse($governorates as $governorate)
                                            <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                            @empty
                                            <option disabled>لا يوجد محافظات</option>
                                            @endforelse
                                        </select>
                                        @error('governorate_id')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <select id="center_governorate_id" name="center_governorate_id[]" multiple class="form-select">
                                            @forelse($centerGovernorates as $centerGovernorate)
                                            <option value="{{ $centerGovernorate->id }}">{{ $centerGovernorate->name }}</option>
                                            @empty
                                            <option disabled>لا يوجد مراكز</option>
                                            @endforelse
                                        </select>
                                        @error('center_governorate_id')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-6">
                                        <input required type="text" name="whatsapp" class="form-control @error('whatsapp')is-invalid @enderror" placeholder="أدخل الواتس">
                                        @error('whatsapp')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input required type="text" name="phone" class="form-control @error('phone')is-invalid @enderror" placeholder="أدخل الهاتف">
                                        @error('phone')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">اضافة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Service Modal -->
        <div class="modal fade" id="editquestions" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">تعديل</h5>
                        <div class="text-start">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update-sub-services', ':id') }}" method="POST" id="editServiceForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="container">
                                <div class="row my-4">
                                    <div class="col-md-6">
                                        <input required type="text" name="title" class="form-control @error('title')is-invalid @enderror" placeholder="أدخل الاسم">
                                        @error('title')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="image" id="imageInputEdit" class="form-control @error('image')is-invalid @enderror" accept="image/*">
                                        @error('image')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <img id="imagePreview" src="" alt="Current Image" style="max-width: 100%; margin-top: 10px; display: none;">
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-6">
                                        <input required type="text" name="description" class="form-control @error('description')is-invalid @enderror" placeholder="أدخل الوصف">
                                        @error('description')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <select id="service_id_edit" name="service_id" class="form-select" data-placeholder="اختر الخدمة" data-select-all="false" data-max="1">
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-6">
                                        <select id="governorate_id_edit" name="governorate_id" class="form-select" data-placeholder="اختر محافظة">
                                            @forelse($governorates as $governorate)
                                            <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                            @empty
                                            <option disabled>لا يوجد محافظات</option>
                                            @endforelse
                                        </select>
                                        @error('governorate_id')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <select id="center_governorate_id_edit" name="center_governorate_id[]" multiple class="form-select">
                                            @forelse($centerGovernorates as $center)
                                            <option value="{{ $center->id }}">{{ $center->name }}</option>
                                            @empty
                                            <option disabled>لا يوجد مراكز</option>
                                            @endforelse
                                        </select>
                                        @error('center_governorate_id')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-6">
                                        <input required type="text" name="whatsapp" class="form-control @error('whatsapp')is-invalid @enderror" placeholder="أدخل الواتس">
                                        @error('whatsapp')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input required type="text" name="phone" class="form-control @error('phone')is-invalid @enderror" placeholder="أدخل الهاتف">
                                        @error('phone')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">تعديل</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Choices.js for service_id and governorate_id in add modal
    const serviceChoices = new Choices('#service_id', {
        removeItemButton: true,
        placeholderValue: 'اختر الخدمة',
        searchPlaceholderValue: 'ابحث...',
        maxItemCount: 1,
        shouldSort: false
    });

    const governorateChoices = new Choices('#governorate_id', {
        removeItemButton: true,
        placeholderValue: 'اختر محافظة',
        searchPlaceholderValue: 'ابحث...',
        maxItemCount: 1,
        shouldSort: false
    });

    // Initialize Choices.js for center_governorate_id in add modal
    const centerChoices = new Choices('#center_governorate_id', {
        removeItemButton: true,
        placeholderValue: 'اختر مركز',
        searchPlaceholderValue: 'ابحث...',
        maxItemCount: -1,
        shouldSort: false
    });

    // Initialize Choices.js for service_id and governorate_id in edit modal
    const serviceChoicesEdit = new Choices('#service_id_edit', {
        removeItemButton: true,
        placeholderValue: 'اختر الخدمة',
        searchPlaceholderValue: 'ابحث...',
        maxItemCount: 1,
        shouldSort: false
    });

    const governorateChoicesEdit = new Choices('#governorate_id_edit', {
        removeItemButton: true,
        placeholderValue: 'اختر محافظة',
        searchPlaceholderValue: 'ابحث...',
        maxItemCount: 1,
        shouldSort: false
    });

    // Initialize Choices.js for center_governorate_id in edit modal
    const centerChoicesEdit = new Choices('#center_governorate_id_edit', {
        removeItemButton: true,
        placeholderValue: 'اختر مركز',
        searchPlaceholderValue: 'ابحث...',
        maxItemCount: -1,
        shouldSort: false
    });

    // Function to load centers based on governorate_id
    function loadCenters(governorateId, selectElementId, isEdit = false, callback = null) {
        console.log('Loading centers for governorate:', governorateId);
        $.ajax({
            url: '/api/governorates/' + governorateId + '/centers',
            method: 'GET',
            success: function(data) {
                console.log('Centers received:', data);
                let options = '';
                if (data && data.length > 0) {
                    data.forEach(function(center) {
                        options += `<option value="${center.id}">${center.name}</option>`;
                    });
                } else {
                    options = `<option disabled>لا يوجد مراكز</option>`;
                }
                $('#' + selectElementId).html(options);
                // Reinitialize Choices.js
                const choicesInstance = isEdit ? centerChoicesEdit : centerChoices;
                choicesInstance.clearStore();
                choicesInstance.setChoices(
                    data.map(center => ({ value: center.id.toString(), label: center.name })),
                    'value',
                    'label',
                    true
                );
                if (callback) callback();
            },
            error: function(xhr) {
                console.error('Error loading centers:', xhr.responseText);
                $('#' + selectElementId).html('<option disabled>حدث خطأ في جلب المراكز</option>');
                const choicesInstance = isEdit ? centerChoicesEdit : centerChoices;
                choicesInstance.clearStore();
                choicesInstance.setChoices([{ value: '', label: 'حدث خطأ في جلب المراكز', disabled: true }], 'value', 'label', true);
            }
        });
    }

    // Load centers for add modal on page load
    const firstGovernorateId = $('#governorate_id').val();
    if (firstGovernorateId) {
        loadCenters(firstGovernorateId, 'center_governorate_id');
    }

    // Load centers for add modal on governorate change
    $('#governorate_id').on('change', function() {
        const governorateId = $(this).val();
        if (governorateId) {
            loadCenters(governorateId, 'center_governorate_id');
        } else {
            $('#center_governorate_id').html('<option disabled>اختر محافظة أولاً</option>');
            centerChoices.clearStore();
            centerChoices.setChoices([{ value: '', label: 'اختر محافظة أولاً', disabled: true }], 'value', 'label', true);
        }
    });

    // Load centers for edit modal on governorate change
    $('#governorate_id_edit').on('change', function() {
        const governorateId = $(this).val();
        if (governorateId) {
            loadCenters(governorateId, 'center_governorate_id_edit', true);
        } else {
            $('#center_governorate_id_edit').html('<option disabled>اختر محافظة أولاً</option>');
            centerChoicesEdit.clearStore();
            centerChoicesEdit.setChoices([{ value: '', label: 'اختر محافظة أولاً', disabled: true }], 'value', 'label', true);
        }
    });

    // Image preview for add modal
    $('#imageInput').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            console.log('Image selected:', file.name);
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreviewAdd').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreviewAdd').hide();
        }
    });

    // Image preview for edit modal
    $('#imageInputEdit').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            console.log('Image selected for edit:', file.name);
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });

    // Debug form submission
    $('#addServiceForm, #editServiceForm').on('submit', function(e) {
        const formData = new FormData(this);
        const formDataObj = {};
        formData.forEach((value, key) => {
            if (key === 'center_governorate_id[]') {
                if (!formDataObj[key]) formDataObj[key] = [];
                formDataObj[key].push(value);
            } else if (key === 'image') {
                formDataObj[key] = value ? value.name : 'No file selected';
            } else {
                formDataObj[key] = value;
            }
        });
        console.log('Form Data:', formDataObj);
        // Optional: Prevent submission if no centers are selected
        if (!formDataObj['center_governorate_id[]'] || formDataObj['center_governorate_id[]'].length === 0) {
            e.preventDefault();
            alert('يرجى اختيار مركز واحد على الأقل');
        }
        // Optional: Prevent submission if no image is selected (for add form)
        if (this.id === 'addServiceForm' && !formDataObj['image']) {
            e.preventDefault();
            alert('يرجى اختيار صورة');
        }
    });

    // Edit service function
    window.editService = function(serviceId) {
        console.log('Editing Service ID:', serviceId);
        fetch(`/sub-services/${serviceId}/edit`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const form = document.querySelector('#editServiceForm');
                if (form) {
                    form.action = `/sub-services/${serviceId}`;
                }
                const titleInput = document.querySelector('#editServiceForm input[name="title"]');
                const descriptionInput = document.querySelector('#editServiceForm input[name="description"]');
                const whatsappInput = document.querySelector('#editServiceForm input[name="whatsapp"]');
                const phoneInput = document.querySelector('#editServiceForm input[name="phone"]');
                const serviceIdSelect = document.querySelector('#service_id_edit');
                const governorateIdSelect = document.querySelector('#governorate_id_edit');
                const imagePreview = document.querySelector('#imagePreview');

                if (titleInput) titleInput.value = data.title || '';
                if (descriptionInput) descriptionInput.value = data.description || '';
                if (whatsappInput) whatsappInput.value = data.whatsapp || '';
                if (phoneInput) phoneInput.value = data.phone || '';
                if (serviceIdSelect) {
                    serviceChoicesEdit.setChoiceByValue(data.service_id ? data.service_id.toString() : '');
                }
                if (governorateIdSelect) {
                    governorateChoicesEdit.setChoiceByValue(data.governorate_id ? data.governorate_id.toString() : '');
                }
                if (imagePreview && data.image) {
                    imagePreview.src = `/${data.image}`;
                    imagePreview.style.display = 'block';
                } else {
                    imagePreview.style.display = 'none';
                }

                // Load centers for the selected governorate and set selected centers
                if (data.governorate_id) {
                    loadCenters(data.governorate_id, 'center_governorate_id_edit', true, function() {
                        if (data.center_governorate_id) {
                            const centerIds = Array.isArray(data.center_governorate_id) 
                                ? data.center_governorate_id.map(id => id.toString())
                                : [data.center_governorate_id.toString()];
                            centerChoicesEdit.setChoiceByValue(centerIds);
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching service data:', error);
                alert('حدث خطأ أثناء جلب بيانات الخدمة');
            });

        $('#editquestions').modal('show');
    };

    // Set active nav link
    const currentPage = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });
});
</script>
@endsection
```