
@extends('layout.app')

@section('content')


  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">

      <div class="row mb-5">
        <div class="col-12 col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="add mt-3 mb-3 text-end d-flex justify-content-end">
                <button class="btn btn-primary" data-bs-target="#addservice" data-bs-toggle="modal"> <i class="fas fa-add"></i>  اضافة خدمة</button>
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
                      
                      <th>اسم الخدمة</th>
                      <th>تفاصيل</th>
                      <th>الصوره</th>

                      <th>التحكم</th>

                    </tr>
                  </thead>
                  <tbody>
                    @forelse($services as $service)
                      
                   
                    <tr>
                      <td>{{ $service->name }}</td>
                      <td>{{ $service->description }}</td>
                      <td class="overflow-auto">@foreach ($service->images as $image)
                      <img src="{{ $image->image_url }}" width="100px" alt="">
                  @endforeach</td>
                  
                      <td class="d-flex justify-content-center align-items-center">  
                        <button type="button" class="btn btn-warning ms-2" data-bs-target="#editquestions" data-bs-toggle="modal" onclick="editService({{ $service->id }})"><i class="fas fa-edit"></i></button>

                        <form action="{{ route('delete-service', $service->id) }}" method="post" class="m-0">
                          @csrf
                            <input type="hidden" name="_method" value="delete">
                  <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>

                    </td>
                    </tr>
                    @empty
                    <td colspan="6">لا يوجد خدمات</td>
                      
                    @endforelse
                   
                    
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      

      <div class="modal fade" id="addservice" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="UserModalLabel"> اضافة</h5>
              <div class="text-start">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="modal-body">
              <form action="{{ route('creat-services') }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="container">
                  <!-- Row for service name and file upload -->
                  <div class="row my-4">
                    <div class="col-md-6">
                      <input type="text" class="form-control @error('name')is-invalid @enderror" placeholder="أدخل اسم الخدمة" name="name" id="name" required>
                      @error('name')
                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <input type="file" class="form-control @error('images')is-invalid @enderror" accept="image/*" multiple name="images[]" required>
                      @error('images')
                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
            
                  <!-- Row for details input -->
                  <div class="row my-4">
                    <div class="col-md-12">
                      <input type="text" required class="form-control @error('description')is-invalid @enderror" placeholder="أدخل التفاصيل" name="description" id="description">
                      @error('description')
                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
            
                  <!-- Row for governorates and centers -->
                  {{-- <div class="row my-4">
                    <div class="col-md-6">
                      <select id="governorates" name="governorate_id" data-placeholder="اختر محافظة"
                      data-select-all="false" data-max="1">
                      @forelse($governorates as $governorate)
                      <option value={{ $governorate->id }}>{{ $governorate->name }}</option>
                      @empty
                      <option disabled>لا توجد محافظات</option>
                      @endforelse
                  </select>
                    </div>
            
                    <div class="col-md-6">
                      <select id="centers" name="center_governorate_id" data-placeholder="اختر مركز"
                      data-select-all="false" data-max="1">
                      @forelse($governorates as $governorate)
                      @foreach($governorate->centerGovernorates as $centerGovernorate)
                          <option value="{{ $centerGovernorate->id }}">{{ $centerGovernorate->name }}</option>
                      @endforeach
                  @empty
                      <option disabled>لا توجد مراكز</option>
                  @endforelse
                  
                 </select>
                    </div>
                  </div> --}}
                </div>
            
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary w-100">اضافة</button>
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
     
      <div class="modal fade" id="editquestions" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="UserModalLabel"> تعديل</h5>
              <div class="text-start">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="modal-body">

              <form action="{{ route('update-services', ':id') }}" method="POST" id="editServiceForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                            <div class="container">
                  <!-- Row for service name and file upload -->
                  <div class="row my-4">
                    <div class="col-md-6">
                      <input type="text" class="form-control @error('name')is-invalid @enderror" placeholder="أدخل اسم الخدمة" name="name" required>
                      @error('name')
            <span class="text-danger invalid-feedback">{{ $message }}</span>
        @enderror
                    </div>
                    <div class="col-md-6">
                      <input type="file" class="form-control @error('images')is-invalid @enderror" accept="image/*" multiple name="images[]" required>
                      @error('images')
                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                      @enderror
                                        </div>
                  </div>
            
                  <!-- Row for details input -->
                  <div class="row my-4">
                    <div class="col-md-12">
                      <input required type="text" class="form-control @error('description')is-invalid @enderror" placeholder="أدخل التفاصيل" name="description" id="description">
                      @error('description')
                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                      @enderror
                                        </div>
                  </div>
            
                  <!-- Row for governorate and center -->
                 
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
  <!--end main wrapper-->

  <!--start overlay-->
  @section('scripts')

<!-- Your Modal HTML Code Here -->

<script>
  function editService(serviceId) {
    fetch(`/services/${serviceId}/edit`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('#editServiceForm input[name="name"]').value = data.name;
            document.querySelector('#editServiceForm input[name="description"]').value = data.description;
            
            
            document.querySelector('#editServiceForm').action = `/services/${serviceId}`;
        })
        .catch(error => {
            console.error('Error fetching service data:', error);
        });
}

 
const currentPage = window.location.pathname.split("/").pop();
  
   
  const navLinks = document.querySelectorAll('.nav-link');

  
  navLinks.forEach(link => {
    if (link.getAttribute('href') === currentPage) {
      link.classList.add('active');
    }
  });
</script>

  @endsection
