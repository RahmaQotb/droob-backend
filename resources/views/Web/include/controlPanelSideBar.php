<div class="col-md-2 side-area">
<h4><i class="far fa-chart-bar"></i> لوحة التحكم</h4>
<div style="height:195px;width:100%;border-radius: 5px;"> 
<img src="images/new-big-logo.jpeg" alt="image here"style="height:195px;width:100%;border-radius: 5px;">
</div>
                    <h4 class="nams"> <i class="fas fa-user-circle"></i> <?php 
                
                    echo $_SESSION["adminName"];
                    ?></h4>
                  
                    <ul>
                        <li class="log">
                            <a href="categories.php">
                            <button>
                                <span><i class="far fa-caret-square-down"></i></span>
                                <span>التصنيفات</span>
                                </button>
                            </a>
                        </li>
                        <!--start articles-->
                        <li data-toggle="collapse" data-target="#menu"class="log">
                            <a href="#">
                            <button>
                                <span><i class="far fa-newspaper"></i></span>
                                <span>المقالات</span>
                                </button>
                            </a>
                        </li>
                        <ul class="collapse" id="menu">
                            <li class="log">
                                <a href="new-post.php">
                                <button>
                                    <span><i class="far fa-edit"></i></span>
                                    <span>مقال جديد</span>
                                    </button>
                                </a>
                            </li>
                            <li class="log">
                                <a href="every-Posts.php">
                                <button>
                                    <span><i class="fas fa-th"></i></span>
                                    <span>كل المقالات </span>
                                    </button>
                                </a>
                            </li class="log">

                        </ul>
                        <!--end articles-->
                            <!--start partners-->
                            <li data-toggle="collapse" data-target="#menu2"class="log">
                            <a href="#">
                            <button>
                                <span><i class="far fa-handshake"></i></span>
                                <span>الشركاء</span>
                                </button>
                            </a>
                        </li>
                        <ul class="collapse" id="menu2">
                            <li class="log">
                                <a href="new-partner.php">
                                <button>
                                    <span><i class="fas fa-plus"></i></span>
                                    <span>شريك جديد</span>
                                    </button>
                                </a>
                            </li>
                            <li class="log">
                                <a href="every-partners.php">
                                <button>
                                    <span><i class="fas fa-hands-helping"></i></span>
                                    <span>كل الشركاء </span>
                                    </button>
                                </a>
                            </li class="log">

                        </ul>
                        <!--end partners-->
                         <!--start team-->
                         <li data-toggle="collapse" data-target="#menu3"class="log">
                            <a href="#">
                            <button>
                                <span><i class="fas fa-user-friends"></i></span>
                                <span>الفريق</span>
                                </button>
                            </a>
                        </li>
                        <ul class="collapse" id="menu3">
                            <li class="log">
                                <a href="new-member.php">
                                <button>
                                    <span><i class="fas fa-user-plus"></i></span>
                                    <span>عضو جديد</span>
                                    </button>
                                </a>
                            </li>
                            <li class="log">
                                <a href="every-members.php">
                                <button>
                                    <span><i class="fas fa-users"></i></span>
                                    <span>كل الاعضاء </span>
                                    </button>
                                </a>
                            </li class="log">

                        </ul>
                        <!--end team-->
                                      <!--start Q&A-->
                                      <li data-toggle="collapse" data-target="#menu4"class="log">
                            <a href="#">
                            <button>
                                <span><i class="fas fa-user-friends"></i></span>
                                <span>سؤال و جواب</span>
                                </button>
                            </a>
                        </li>
                        <ul class="collapse" id="menu4">
                            <li class="log">
                                <a href="new-qa.php">
                                <button>
                                    <span><i class="fas fa-user-plus"></i></span>
                                    <span>سؤال جديد</span>
                                    </button>
                                </a>
                            </li>
                            <li class="log">
                                <a href="every-qa.php">
                                <button>
                                    <span><i class="fas fa-users"></i></span>
                                    <span>كل الاسئلة </span>
                                    </button>
                                </a>
                            </li class="log">

                        </ul>
                        <!--end Q&A-->
                        <li class="log">
                            
                            <a href="index.php"target="_blank">
                            <button>
                                <span><i class="far fa-eye"></i></span>
                                <span>عرض الموقع</span>
                                </button>
                            </a>
                            
                        </li>
               
                            <li class="log">
                            <a href="index.php">
                        <form action="login.php"method="POST">
                        
                            <button type="submit" name="logout"> 
                                   <span><i class="fas fa-sign-out-alt"></i></span>
                                    <span> تسجيل الخروج</span>
                            </button>
                            
                        </form>
                            </a>
                            </li>
                    </ul>
                </div>