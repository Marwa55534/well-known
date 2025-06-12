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
                    <button class="btn btn-primary ms-2" data-bs-target="#addservice" data-bs-toggle="modal"> <i class="fas fa-add"></i> اضافة محافظة</button>
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
                      
                      <th>المحافظة</th>
                      <th>التحكم</th>

                    </tr>
                  </thead>
                  <tbody>
                    @forelse($governorates as $governorate)
                      
                   
                    <tr>
                    

                      <td>{{ $governorate->name }}</td> 
                     
                      
                      <td class="d-flex justify-content-center align-items-center">  
                        <button type="button" class="btn btn-warning ms-2" data-bs-target="#addservic" data-bs-toggle="modal" onclick="editGovernorate({{ $governorate->id }})"><i class="fas fa-edit"></i></button>
                     
                        <form action="{{ route('delete-governate', $governorate->id) }}" method="post" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger" onclick="deleteGovernorate({{ $governorate->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                        
                      </form>
                                        </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="2">لا يوجد محافظات</td>
                  </tr>
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
              
              <form action="{{ route('create-governate') }}" method="POST">
                @csrf
                                <div class="container">
                    <div class="row my-4">
                        <div class="col-md-12">
                  
                          <input required type="text" class="form-control @error('name')is-invalid @enderror" name="name"  placeholder="أدخل المحافظة ">
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
      <div class="modal fade" id="addservic" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="UserModalLabel"> تعديل</h5>
              <div class="text-start">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="modal-body">
              
              <form action="{{ route('update-governorate', ':id') }}" method="POST" id="editServiceForm">

                @csrf
                @method('PUT')
                                <div class="container">
                    <div class="row my-4">
                        <div class="col-md-12">
                  
                                <input required type="text" name="name" class="form-control @error('name')is-invalid @enderror"  placeholder="أدخل المحافظة ">
                                @error('name')
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
  <!--end main wrapper-->

  <!--start overlay-->
  <div class="overlay btn-toggle"></div>
  <!--end overlay-->




  @endsection

  @section('scripts')
  <script>
    function deleteGovernorate(id) {
    if (confirm('هل أنت متأكد من حذف هذه المحافظة؟')) {
      fetch(`/governorate/${id}`, {
    method: 'DELETE',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})

        .then(response => {
          window.location.href = '/governorates';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء محاولة الحذف');
        });
    }
}

function editGovernorate(GovernorateId) {
    console.log('Editing Governorate ID:', GovernorateId);

    fetch(`/governorate/${GovernorateId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
    document.querySelector('#editServiceForm input[name="name"]').value = data.name;
    const form = document.querySelector('#editServiceForm');
    form.action = `/governorate/${data.id}`; 
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
