<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>خدمه من هنا</title>
  </head>
  <body>
    <section class="bg-sing" style="height: 100vh;">
        <div class="container-fluid h-100">
            <div class="row justify-content-center align-items-center h-100 order-md-first order-last">
                <div class="col-md-6  d-flex flex-column justify-content-center">
                    <div style="border-radius: 20px; text-align: center;" class="bg-light shadow-lg p-4 bg-singin w-75 mx-auto">
                        <h3 class="text-singin my-4">تسجيل الدخول</h3>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form id="loginForm">
                            <input type="text" id="phone" name="phone" class="w-75 form-control my-3 mx-auto" placeholder="رقم الهاتف" required>
                            <input type="password" id="password" name="password" class="w-75 form-control mx-auto" placeholder="الرقم السري" required>
                            <button type="submit" class="btn btn-singin my-5">تسجيل الدخول</button>
                        </form>
                    </div>
                </div>   
                <div class="col-md-6  d-flex flex-column justify-content-center order-md-last order-first">
                    <div class="text-center my-3">
                                               <img class="img-fluid" src="{{ asset('assets/images/Group1.png') }}" style="width: 60%;" alt="">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();    

        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;

        const formData = new FormData(); 
        formData.append('phone', phone); 
        formData.append('password', password);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        fetch("{{ route('login') }}", {
            method: 'POST',  
            body: formData   
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/';  
            } else {
                alert(data.message || 'حدث خطأ ما');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ يرجى المحاولة مرة أخرى');
        });
    });
  });
</script>

  </body>
</html>
