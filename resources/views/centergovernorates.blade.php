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
                    <button class="btn btn-primary" data-bs-target="#add" data-bs-toggle="modal"> <i class="fas fa-add"></i>اضافة مركز</button>
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
                      
                     
                      <th>المركز</th>
                      <th>المحافظة</th>

                      <th>التحكم</th>

                    </tr>
                  </thead>
                  <tbody>
                    @forelse($centergovernorates as $centergovernorate)
                    <tr>
                      
                        <td>{{ $centergovernorate->name }}</td>
                        <td>{{ $centergovernorate->governorate->name }}</td>

                       
                        <td class="d-flex justify-content-center align-items-center">  
                            <button type="button" class="btn btn-warning ms-2" data-bs-target="#addservic" data-bs-toggle="modal" onclick="editCenterGovernorate({{ $centergovernorate->id }})"><i class="fas fa-edit"></i></button>
  
                          <form action="{{ route('delete-center-governate', $centergovernorate->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="deleteCeterGovernate({{ $centergovernorate->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                          
                        </form>
                                          </td>
                      </tr>
                    @empty
                      <td colspan="3">لا يوجد مراكز</td>
                        
                    @endforelse
                    
                   
                   
                    
                    
                  </tbody>
                </table>
              </div>
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
              
                <form action="{{ route('update-center-governate', ':id') }}" method="POST" id="editServiceForm">

                    @csrf
                    @method('PUT')               
                     <div class="container">
                    <div class="row my-4">
                     
                        <div class="col-md-6">
                  
                                <input required type="text" name="name" class="form-control @error('name')is-invalid @enderror"  placeholder="أدخل المركز ">
                        </div>
                        <div class="col-md-6">
                  
                        <select id="governorates" name="governorate_id" class="form-select" data-placeholder="اختر محافظة"
                      data-select-all="false" data-max="1">
                      @forelse($governorates as $governorate)
                      <option value={{ $governorate->id }}>{{ $governorate->name }}</option>
                      @empty
                      <option disabled>لا توجد محافظات</option>
                      @endforelse
                  </select>
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
      <div class="modal fade" id="add" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="UserModalLabel"> اضافة</h5>
              <div class="text-start">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="modal-body">
              
                <form action="{{ route('create-center-governate') }}" method="POST">
                    @csrf

                <div class="container">
                    <div class="row my-4">
                        <div class="col-md-6">
                  
                                <input required type="text" class="form-control @error('name')is-invalid @enderror"  placeholder="أدخل المركز " name="name">
                        </div>

                        <div class="col-md-6">
                  
                          <select id="governorate_id" name="governorate_id" class="form-select" data-placeholder="اختر محافظة"
                          data-select-all="false" data-max="1">
                          
                          @foreach($governorates as $governorate)
                      <option value={{ $governorate->id }}>{{ $governorate->name }}</option>
                            
                          @endforeach
                     
                      </select>
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
     


    </div>
  </main>
  <!--end main wrapper-->

  <!--start overlay-->
  <div class="overlay btn-toggle"></div>
  <!--end overlay-->

  @endsection

  
  <!--bootstrap js-->
  @section('scripts')
  <script>
     function deleteCeterGovernate(id) {
    if (confirm('هل أنت متأكد من حذف هذا المركز؟')) {
      fetch(`/center-governate/${id}`, {
    method: 'DELETE',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})

        .then(response => {
          window.location.href = '/center-governate';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء محاولة الحذف');
        });
    }
}


function editCenterGovernorate(centergovernorate) {
    console.log('Editing Governorate ID:', centergovernorate);

    fetch(`/center-governate/${centergovernorate}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
    document.querySelector('#editServiceForm input[name="name"]').value = data.name;
    const form = document.querySelector('#editServiceForm');
    form.action = `/center-governate/${data.id}`; 
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
 