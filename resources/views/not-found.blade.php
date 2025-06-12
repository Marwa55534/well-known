<!doctype html>
<html lang="ar" data-bs-theme="light_mode" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>خدمه من هنا</title>
    <!--favicon-->
    <link rel="icon" href="assets/images/logo1.png" type="image/png">
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet">
    <script src="assets/js/pace.min.js"></script>

    <!--plugins-->
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/metisMenu.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/mm-vertical.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/simplebar/css/simplebar.css">
    <!--bootstrap css-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="sass/main.css" rel="stylesheet">
    <link href="sass/dark-theme.css" rel="stylesheet">
    <link href="sass/blue-theme.css" rel="stylesheet">
    <link href="sass/semi-dark.css" rel="stylesheet">
    <link href="sass/bordered-theme.css" rel="stylesheet">
    <link href="sass/responsive.css" rel="stylesheet">
    <link href="sass/select.css" rel="stylesheet">

</head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,600,700');
    @import url('https://fonts.googleapis.com/css?family=Catamaran:400,800');

    .error-container {
        text-align: center;
        font-size: 180px;
        font-family: 'Catamaran', sans-serif;
        font-weight: 800;
        margin: 20px 15px;
    }

    .error-container>span {
        display: inline-block;
        line-height: 0.7;
        position: relative;
        color: #30B0C7;
    }

    .error-container>span>span {
        display: inline-block;
        position: relative;
    }

    .error-container>span:nth-of-type(1) {
        perspective: 1000px;
        perspective-origin: 500% 50%;
        color: #30B0C7;
    }

    .error-container>span:nth-of-type(1)>span {
        transform-origin: 50% 100% 0px;
        transform: rotateX(0);
        animation: easyoutelastic 8s infinite;
    }

    .error-container>span:nth-of-type(3) {
        perspective: none;
        perspective-origin: 50% 50%;
        color: #30B0C7;
    }

    .error-container>span:nth-of-type(3)>span {
        transform-origin: 100% 100% 0px;
        transform: rotate(0deg);
        animation: rotatedrop 8s infinite;
    }

    @keyframes easyoutelastic {
        0% {
            transform: rotateX(0);
        }

        9% {
            transform: rotateX(210deg);
        }

        13% {
            transform: rotateX(150deg);
        }

        16% {
            transform: rotateX(200deg);
        }

        18% {
            transform: rotateX(170deg);
        }

        20% {
            transform: rotateX(180deg);
        }

        60% {
            transform: rotateX(180deg);
        }

        80% {
            transform: rotateX(0);
        }

        100% {
            transform: rotateX(0);
        }
    }

    @keyframes rotatedrop {
        0% {
            transform: rotate(0);
        }

        10% {
            transform: rotate(30deg);
        }

        15% {
            transform: rotate(90deg);
        }

        70% {
            transform: rotate(90deg);
        }

        80% {
            transform: rotate(0);
        }

        100% {
            transform: rotateX(0);
        }
    }





    /* demo stuff */
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        background-color: #f4f4f4;
    }

    html,
    button,
    input,
    select,
    textarea {
        font-family: 'Montserrat', Helvetica, sans-serif;
        color: #025e6e;
    }

    h1 {
        text-align: center;
        margin: 30px 15px;
    }

    .zoom-area {
        max-width: 490px;
        margin: 30px auto 30px;
        font-size: 19px;
        text-align: center;
    }

    .link-container {
        text-align: center;
    }

    a.more-link {
        text-transform: uppercase;
        font-size: 13px;
        background-color: #30B0C7;
        padding: 10px 15px;
        border-radius: 0;
        color: #fff;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
        line-height: 1.5;
        text-decoration: none;
        margin-top: 50px;
        letter-spacing: 1px;
    }
</style>

<body>


    




    <!--start main wrapper-->
    <main >
        <div class="main-content">

            <h1>هذه الصفحة غير موجودة</h1>
            <section class="error-container">
                <span><span>4</span></span>
                <span>0</span>
                <span><span>4</span></span>
            </section>
            <div class="link-container">
                <a target="_blank" href={{ route('home') }} class="more-link">الصفحة الرئيسية</a>
            </div>

        </div>
    </main>
    <!--end main wrapper-->

    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->


    <!--bootstrap js-->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>

        const currentPage = window.location.pathname.split("/").pop();


        const navLinks = document.querySelectorAll('.nav-link');


        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });
    </script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <!--plugins-->
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/plugins/metismenu/metisMenu.min.js"></script>
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/js/select.js"></script>

    <script src="assets/js/main.js"></script>


</body>

</html>