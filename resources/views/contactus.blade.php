

@extends('layout.app')

@section('content')
  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">

      <div class="row mb-5">
        <div class="col-12 col-xl-12">
          <div class="card">
            <div class="card-body">

                @if($contactus->isEmpty())
                <div class="add mt-3 mb-3 text-end d-flex justify-content-end">
                    <button class="btn btn-primary" data-bs-target="#addservice" data-bs-toggle="modal"> 
                        <i class="fas fa-add"></i> اضافة معلومات تواصل معنا 
                    </button>
                </div>
                @endif
                

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
                      <th>الأسم</th>
                      <th>رقم الهاتف</th>
                      <th>التحكم</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contactus as $contactus)
                    <tr>
                      
                      <td>{{ $contactus->name }}</td>
                      <td>{{ $contactus->phone }}</td>
                     
                      <td class="d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-warning ms-2" data-bs-target="#editquestions" data-bs-toggle="modal" onclick="editService({{ $contactus->id }})"><i class="fas fa-edit"></i></button>
                        {{-- <form action="{{ route('delete-sub-services', $aboutus->id) }}" method="post">
                          @csrf
                          @method('delete')
                          <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                      </form> --}}
                                          </td>
                    </tr>
                    @empty
                    <td colspan="3">لا يوجد  تواصل معنا</td>

                      
                    @endforelse
                  
                  </tbody>
                </table>
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
              <h5 class="modal-title" id="UserModalLabel"> اضافة</h5>
              <div class="text-start">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="modal-body">
              <form action="{{ route('create-contact-us') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                  <div class="row my-4">
                    <div class="col-md-12">
                      <input required type="text" name="name" class="form-control @error('name')is-invalid @enderror" placeholder="أدخل الاسم">
                      @error('name')
                      <span class="text-danger invalid-feedback">{{ $message }}</span>
                  @enderror
                    </div>
                    
                  </div>
                  <div class="row my-4">
                    <div class="col-md-12">
                        <input type="text" 
                        name="phone" 
                        class="form-control @error('phone') is-invalid @enderror" 
                        placeholder="أدخل الهاتف" 
                        maxlength="11" 
                        pattern="\d{11}" required>
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
              <h5 class="modal-title" id="UserModalLabel"> تعديل</h5>
              <div class="text-start">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="modal-body">
              <form action="{{ route('update-contact-us', ':id') }}" method="POST" id="editServiceForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="container">
                  <div class="row my-4">
                    <div class="col-md-12">
                      <input required type="text" name="name" class="form-control @error('name')is-invalid @enderror" placeholder="أدخل الاسم">
                      @error('name')
                      <span class="text-danger invalid-feedback">{{ $message }}</span>
                  @enderror
                    </div>

                  </div>
                  <div class="row my-4">
                    <div class="col-md-12">
                      <input type="text" 
                      name="phone" 
                      class="form-control @error('phone') is-invalid @enderror" 
                      placeholder="أدخل الهاتف" 
                      maxlength="11" 
                      pattern="\d{11}" required>
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
  @endsection

  @section('scripts')

  <script>


$('#editquestions').on('shown.bs.modal', function () {
    editService(serviceId);
});

function editService(serviceId) {
    console.log('Editing Service ID:', serviceId);

    fetch(`/contact-us/${serviceId}/edit`)
        .then(response => response.json())
        .then(data => {
            const name = document.querySelector('#editServiceForm input[name="name"]');
            const phone = document.querySelector('#editServiceForm input[name="phone"]');
           

            if (name) name.value = data.name;
            if (phone) phone.value = data.phone;
           

            const form = document.querySelector('#editServiceForm');
            if (form) {
                form.action = `/contact-us/${serviceId}`;
            }


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

