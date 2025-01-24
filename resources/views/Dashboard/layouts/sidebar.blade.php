<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">القائمة</li>
        
        <li
        class="sidebar-item  has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-pen-fill"></i>
            <span>الطلاب</span>
        </a>
    

    </li>
        
        <li
            class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-pen-fill"></i>
                <span>المادة</span>
            </a>
            
            <ul class="submenu ">
                
                <li class="submenu-item  ">
                    <a href="{{route("subjects.index")}}" class="submenu-link">كل المواد    </a>
                    
                </li>
                
                <li class="submenu-item  ">
                    <a href="{{route("subjects.create")}}" class="submenu-link">إضافة مادة</a>
                    
                </li>
                
            </ul>
            

        </li>
        <li
            class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="iconly-boldProfile">

                </i>
                <span>الامتحانات</span>
            </a>
            
            <ul class="submenu ">
                
                <li class="submenu-item  ">
                    <a href="{{route("exams.index")}}" class="submenu-link">كل الامتحانات</a>
                    
                </li>
                
                <li class="submenu-item  ">
                    <a href="{{route("exams.create")}}" class="submenu-link">اضافة امتحان</a>
                    
                </li>

                <li class="submenu-item  ">
                    <a href="{{ route('exams.passage') }}" class="submenu-link">اضافة امتحان قطعة نصية</a>
                    
                </li>
                
                
            </ul>
            

        </li>
       
        <li
            class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-chat-dots-fill"></i>
                <span>سؤال و جواب</span>
            </a>
            
            <ul class="submenu ">
                
                <li class="submenu-item  ">
                    <a href="component-accordion.html" class="submenu-link">كل الاسئلة</a>
                    
                </li>
                
                <li class="submenu-item  ">
                    <a href="component-alert.html" class="submenu-link">اضافة سؤال</a>
                    
                </li>
                
            </ul>
            

        </li>
        {{-- <li
            class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-cash"></i>
                <span>العروض الترويجية</span>
            </a>
            
            <ul class="submenu ">
                
                <li class="submenu-item  ">
                    <a href="" class="submenu-link">كل العروض الترويجية</a>
                    
                </li>
                
                <li class="submenu-item  ">
                    <a href="" class="submenu-link">اضافة عرض ترويجي</a>
                    
                </li>
                
            </ul>
            

        </li> --}}
        
        {{-- <li
        class="sidebar-item  has-sub">
        <a href="#" class='sidebar-link'>
            <i class="iconly-boldProfile"></i>
            <span>الفريق</span>
        </a> --}}
        
        <ul class="submenu ">
            
            <li class="submenu-item  ">
                <a href="component-accordion.html" class="submenu-link">كل الفريق</a>
                
            </li>
            
            <li class="submenu-item  ">
                <a href="component-alert.html" class="submenu-link">اضافة عضو</a>
                
            </li>
            
        </ul>
        

    </li>
        <li
            class="sidebar-item  ">
            <a href="index.html" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>عرض الموقع</span>
            </a>
            

        </li>

        <li
            class="sidebar-item  ">
            <a href="" class='sidebar-link'>
                <i class="bi bi-person-badge-fill"></i>
                <span>تغيير كلمة المرور</span>
            </a>
            

        </li>
        <li
            class="sidebar-item  ">
            <a href="" class='sidebar-link'>
                <i class="bi bi-person-badge-fill"></i>
                <span>تسجيل الخروج</span>
            </a>
            

        </li>
        
</div>
</div>
</div>
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    