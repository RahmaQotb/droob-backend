<?php 
date_default_timezone_set("Africa/Cairo");
session_start();
if(!isset($_SESSION["adminName"])){
    header("location:login.php");
}
include "include/connection.php"; 
?>
<?php include_once "include/header.php"; ?>
<title>لوحة التحكم</title>
    <!-- Custom Styling -->
    <link rel="stylesheet" href="css/dashboard.css">
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2473974671507788"
     crossorigin="anonymous"></script>
     
</head>

<body>
    <!-- start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
            <?php include_once "include/controlPanelSideBar.php"; ?>
                <div class="col-md-10 main-area">
                    <div class="add">
                        <?php 
                    
                        if(isset($_POST["addPost"])){
                            if(empty($_POST["postTitle"]) || empty($_POST["postContent"])){
                        echo "<div class='alert alert-danger'>الرجاء ملئ الحقول ادناة</div>";
                            }
                                    elseif(strlen($_POST["postContent"])>100000 || strlen($_POST["postTitle"])>199){
                        echo "<div class='alert alert-danger'>محتوي المنشور/العنوان كبير جدا</div>";
                            }else{

                                   
                                    $imageName=$_FILES["postImage"]["name"];
                               
                                  
                                    $imageTmpName=$_FILES["postImage"]["tmp_name"];
                              
                        
                                     $postImage=rand(0,10000)."_". $imageName;
                               
                                 
                                    move_uploaded_file($imageTmpName,"uploads/postImages/".$postImage);
                        
                                    $postTitle=filter_var($_POST["postTitle"],FILTER_SANITIZE_STRING);
                                    $postTitle=htmlspecialchars($postTitle);
                                       $postCategory=$_POST["postCategory"];
                                    $rtyuq="اخبار الكريبتو";
                                    $rtyu="أخبار الكريبتو";
                                    $rtyux="اخبار الكربتو";
                                    $rtyuxx="أخبار الكربتو";
                                    $selectc="select * from partner" ;
                                    @$execselec=mysqli_query($con,$selectc);
                                    if(mysqli_num_rows($execselec)==0){
                                        $knowMe=0;    
                                    }
                                    while($row=mysqli_fetch_assoc($execselec)){
                                    if($postCategory==$row["partnerName"] ||
                                     $postCategory==$rtyuq ||
                                     $postCategory==$rtyu ||
                                     $postCategory==$rtyux ||
                                     $postCategory==$rtyuxx){
                                    $knowMe=1;
                                    break;
                                     }else{
                                      $knowMe=0;    
                                     }
                                }
              
                                 
                              
                                 
                                   $xyzcv=$_POST["postContent"];
                                    $postContent=mysqli_real_escape_string($con,$xyzcv);
                     
                                    $z= $_SESSION["adminName"];
                                    $postAuthor=$z;
                                    $postDate=date("Y-m-d");
                                    $query="insert into post(postTitle,postCategory,postImage,postContent,PostDate,postAuthor,knowMe) 
                                    values('$postTitle','$postCategory','$postImage','$postContent','$postDate','$postAuthor','$knowMe')";
                                    @$execin=mysqli_query($con,$query);
                                    if($execin){
                                        echo"<div class='alert alert-success'style='text-align:center'>تمت اضافة المنشور بنجاح</div>";
                                    }else{
                                        echo "<div class='alert alert-danger'style='text-align:center'>هناك خطء في اضافة المنشور</div>";
                                    }
                            }
                        }
                        
                        ?>
                        <h4> <i class="far fa-plus-square"></i> اضافة مقال جديد </h4>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST"enctype="multipart/form-data"id="tbs2">
                            <div class="form-group">
                                <label> عنوان المقال</label>
                                <input type="text" name="postTitle" required class="form-control"autofocus>
                            </div>
                            <div class="form-group">
                                <label>  التصنيف</label>
                                <select name="postCategory" class="form-control"id="poCa"required>
                                    <?php 
                                  
                                        $qu="select categoryName from category";
                                        @$exec=mysqli_query($con,$qu);
                                while($row=mysqli_fetch_assoc($exec)){
                                    $s=$row["categoryName"];
                                    echo "<option value='$s'>";
                                    echo $row["categoryName"];
                                    echo "</option>";
                                }
                                        
                                    ?>
                          
                               </select>
                            </div>
                            <div class="form-group">
                                <label> صورة المقال</label>
                                <input type="file" class="form-control"name="postImage"required>
                            </div>
                            <div class="form-group">
                                <label> نص المقال</label>
                                <textarea col="30" rows="10" class="form-control"name="postContent" id="bodyx"required>

                              </textarea>
                            </div>
                            <button class="btn-custom "name="addPost" id="btn">نشر المقال</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
    <?php include_once "include/footer.php"; ?>