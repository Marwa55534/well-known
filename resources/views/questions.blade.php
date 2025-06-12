
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
                    <button class="btn btn-primary" data-bs-target="#addservice" data-bs-toggle="modal"> <i class="fas fa-add"></i>  اضافة سؤال و اجابة</button>
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
                      
                      <th>السؤال</th>
                      <th>الاجابة</th>
                      <th>التحكم</th>

                    </tr>
                  </thead>
                  <tbody>
                    @forelse($questions as $question)
                    <tr>
                      <td>{{ $question->question }}</td>
                      <td>{{ $question->answer }}</td>
                     
                      <td class="d-flex justify-content-center align-items-center">  
                        <button type="button" class="btn btn-warning ms-2" data-bs-target="#editquestions" data-bs-toggle="modal" onclick="editService({{ $question->id }})"><i class="fas fa-edit"></i></button>
                  <form action="{{ route('delete-questions', $question->id) }}" method="post" class="m-0">
                    @csrf
                    @method('delete') <!-- Cleaner syntax for delete method -->
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>
                                   </td>
                    </tr>
                    @empty
                    <td colspan="3">لا يوجد أسئلة</td>

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
              
              <form action="{{ route('create-questions') }}" method="POST">
                @csrf 
                <div class="container">
                    <div class="row my-4">
                        <div class="col-md-12">
                            <input required type="text" name="question" class="form-control @error('question')is-invalid @enderror" placeholder="أدخل السؤال" required>
                            @error('question')
                            <span class="text-danger invalid-feedback">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-12">
                            <input required type="text" name="answer" class="form-control @error('answer')is-invalid @enderror" placeholder="أدخل الاجابة" required>
                            @error('answer')
                            <span class="text-danger invalid-feedback">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="row my-4">
                       

                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary w-100">اضافة</button>
                        </div>

                    </div>
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
              
              <form action="{{ route('update-questions', ':id') }}" method="POST" id="editServiceForm">

                @csrf
                @method('PUT')

                <div class="container">
                  <div class="row my-4">
                      <div class="col-md-12">
                
                              <input required type="text" class="form-control @error('question')is-invalid @enderror"  placeholder="أدخل السؤال " name="question">

                              @error('question')
                              <span class="text-danger invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                    
                  </div>
                  <div class="row my-4">
                      <div class="col-md-12">
                
                        <input required type="text" class="form-control @error('answer')is-invalid @enderror"  placeholder="أدخل الاجابة " name="answer">
                        @error('answer')
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
  @section('scripts')

  <script>

function editService(serviceId) {
    console.log('Editing Service ID:', serviceId);

    fetch(`/questions/${serviceId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            document.querySelector('#editServiceForm input[name="question"]').value = data.question;
            document.querySelector('#editServiceForm input[name="answer"]').value = data.answer;

            document.querySelector('#editServiceForm').action = `/questions/${serviceId}`;
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
