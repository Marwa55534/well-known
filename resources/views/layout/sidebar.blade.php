
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div class="logo-icon">
        <img src="assets/images/Group 2.png" width="100%" alt="">
      </div>
      <!-- <div class="logo-name flex-grow-1 text-center fw-bold">
        <h2 class="mb-0"><span style="color: #4880FF;">Sama</span> Bus</h2>
      </div> -->
      <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav">
      <!--navigation-->
      <ul class="metismenu" id="sidenav">
        <li>
          <a href={{ route('home') }} class="nav-link" >
            <div class="parent-icon"><i class="fa-solid fa-users"></i>
            </div>
            <div class="menu-title">الرئيسية</div>
          </a>
        </li>
        <li>
          <a href={{ route('users') }} class="nav-link" >
            <div class="parent-icon"><i class="fa-solid fa-users"></i>
            </div>
            <div class="menu-title">المستخدمين</div>
          </a>
        </li>


        <li>
          <a href={{ route('services') }} class="nav-link" >
            <div class="parent-icon"><i class="fa-solid fa-person-walking-luggage"></i>
            </div>
            <div class="menu-title">الخدمات</div>
          </a>
        </li>
       
        
        <li>
          <a href={{ route('sub-services') }} class="nav-link" >
            <div class="parent-icon"><i class="fa-solid fa-table"></i>
            </div>
            <div class="menu-title">صاحب الخدمه</div>
          </a>
        </li>
        <li>
          <a href={{ route('questions') }} class="nav-link" >
            <div class="parent-icon"><i class="fa-solid fa-table"></i>
            </div>
            <div class="menu-title">الاسئله الشائعه</div>
          </a>
        </li>
        <li>
          <a href={{ route('governorates') }} class="nav-link" >
            <div class="parent-icon"><i class="fa-solid fa-location"></i>
            </div>
            <div class="menu-title">المحافظات  </div>

          </a>
        </li>
        <li>
          <a href={{ route('center-governate') }} class="nav-link" >
            <div class="parent-icon"><i class="fa-solid fa-location"></i>
            </div>
            <div class="menu-title">المراكز  </div>

          </a>
        </li>
        <li>
          <a href={{ route('contact-us') }} class="nav-link" >
            <div class="parent-icon">
            </div>
            <div class="menu-title">تواصل معنا</div>

          </a>
        </li>
        <li>
          <a href={{ route('about-us') }} class="nav-link" >
            <div class="parent-icon">
            </div>
            <div class="menu-title">معلومات عنا</div>

          </a>
        </li>

        <li>
            <div class="parent-icon">
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2">
                  <i class="material-icons-outlined">power_settings_new</i>تسجيل خروج
              </button>
          </form>

        </li>
    
      </ul>
      <div id="footer-section" style="padding-top: 300px;" class="text-center">
        <p class="mb-1 p-0">جميع الحقوق محفوظة © 2025 خدمة من هنا</p>
        <p>تم تطويره بواسطة <a href="https://brmja.tech/" target="_blank">برمجة تك</a></p>
      </div>
      
      <!--end navigation-->
    </div>
  </aside>
