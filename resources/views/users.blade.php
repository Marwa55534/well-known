
@extends('layout.app')

@section('content')


  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">

      <div class="row mb-5">
        <div class="col-12 col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive text-center">
                <table id="example2" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      
                      <th>اسم العميل</th>
                      <th>رقم الهاتف</th>
                      <th>البريد الاكتروني</th>
                      <th>الصوره</th>

                    </tr>
                  </thead>

                
                  <tbody>
                    @forelse ($users as $user)
                    <tr>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->phone }}</td>
                      <td>{{ $user->email ?? null}}</td>
                      <td>                        <img src="{{ asset($user->image ?? null) }}" alt="user" class="w-50 h-50" loading="lazy">
                      </td>
                     
                
                    </tr>
                    
                    @empty
                    <tr>
                        <td colspan="4">لا يوجد مستخدمين</td>
                    </tr>
                @endforelse
                
                  </tbody>
  



                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      

      
      <div class="modal fade" id="edituser" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="UserModalLabel"> تعديل</h5>
              <div class="text-start">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="modal-body">
              
              <form>
                <div class="container">
                    
                    <div class="row my-4">
                        <div class="col-md-6">
                  
                                <input type="text" class="form-control" id="userName" placeholder="أدخل اسم العميل ">
                        </div>
                        <div class="col-md-6">
                  
                            <input type="email" class="form-control" placeholder="أدخل البريد الاكتروني "  />

                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-6">
                  
                            <input type="tel" class="form-control"  placeholder="أدخل رقم الموبايل ">
                         
                        </div>
                        <div class="col-md-6">
                  
                          <input type="file" class="form-control" accept="image/*" />     
                        </div>
                       
                    </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary w-100">تعديل</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
  <!--end main wrapper-->

  <!--start overlay-->
  <  @endsection

  
  <!--bootstrap js-->
  @section('scripts')
  <script>
  
    const currentPage = window.location.pathname.split("/").pop();
  
   
    const navLinks = document.querySelectorAll('.nav-link');
  
    
    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPage) {
        link.classList.add('active');
      }
    });
  </script>
  
  @endsection


