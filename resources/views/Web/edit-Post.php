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
</head>

<body >
    <!-- start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
            <?php include_once "include/controlPanelSideBar.php"; ?>
                <div class="col-md-10 main-area">
                    <div class="add">
                        <?php
                        /**********************Start when click edit post******************** */
                        if(isset($_POST["edPost"])){
                            if(empty($_POST["postTitle"]) || empty($_POST["postContent"])){
                                echo "<div class='alert alert-danger'>الرجاء ملئ الحقول ادناة</div>";
                                    }
                                            elseif(strlen($_POST["postContent"])>100000){
                                echo "<div class='alert alert-danger'>محتوي المنشور كبير جدا</div>";
                                    }else{
       
                                            $imageName=$_FILES["postImage"]["name"];
                                       
                                            $imageTmpName=$_FILES["postImage"]["tmp_name"];
                              
                                             $postImage=rand(0,10000)."_". $imageName;
                                         
                                            move_uploaded_file($imageTmpName,"uploads/postImages/".$postImage);
                             
                                            $postTitle=addslashes($_POST["postTitle"]) ;
                                               $postCategory=$_POST["postCategory"];
                                                                              $rtyuq="اخبار الكريبتو";
                                            $rtyu="أخبار الكريبتو";
                                            $rtyux="اخبار الكربتو";
                                            $rtyuxx="أخبار الكربتو";
                                            $selectc="select * from partner" ;
                                            @$execselec=mysqli_query($con,$selectc);
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
                      
                                         
                                        
                                            $postContent=mysqli_real_escape_string($con,$_POST["postContent"]);
                                
                                            $z= $_SESSION["adminName"];
                                            $postAuthor=$z;
                                          $xc=$_SESSION["user"];

                            $update = "update post set postTitle='$postTitle',postCategory='$postCategory',postImage='$postImage'
                            ,postContent='$postContent',postAuthor='$postAuthor',knowMe='$knowMe' where postId='$xc'";
                            @$ExecUp = mysqli_query($con,$update);
                            if($ExecUp){
                                echo"<center><div class='alert alert-success'>";
                                echo "تم تعديل المنشور بنجاح    ";
                            
                                echo"</div></center>";
                             
                            }else{
                                echo "<center><div class='alert alert-danger'>هناك مشكلة في تعديل المنشور</div></center>";
                            }
                        }
                           
                        }
                         /**********************End when click edit post******************** */
                        ?>
                        <?php 



             if(isset($_GET["editPost"]) && !empty($_GET["editPost"])
             && filter_var( $_GET["editPost"],FILTER_VALIDATE_INT)){
$_SESSION["user"]=filter_var( $_GET["editPost"],FILTER_SANITIZE_NUMBER_INT);  
                    
                          $ko=filter_var( $_GET["editPost"],FILTER_SANITIZE_NUMBER_INT); 
                          $select="select * from post where postId='$ko' ";
                          @$execselecx=mysqli_query($con,$select);
                          if(mysqli_num_rows($execselecx)==0){
                              echo "<div class='alert alert-danger'style='text-align:center'>هناك مشكلة  ! </div>";
                          }else{
                        while($row=mysqli_fetch_assoc($execselecx)){
                              $sdrt=$row["postImage"];
                              @(unlink("uploads/postImages/".$sdrt));
                          
                        }
    
                                  $qudel="delete postImage from post where postId='$ko'";
                                  @$execdel = mysqli_query($con,$qudel);
                    }
                        $select = "select*from post where postId='$ko'";
                        @$query = mysqli_query($con,$select) or die(mysqli_error($con));
                        if(mysqli_num_rows($query)==0){
                            echo"<center><div class='alert alert-primary'>";
                            echo "  قم بالعودة الي ";
                            echo "<br><a href='every-Posts.php'>جميع المنشورات</a>";
                            echo"</div></center>"; 
                                }else{
                      while( $rowp= mysqli_fetch_array($query)){
?>
<h4> <i class="fas fa-highlighter"></i> تعديل المقال  </h4>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST"enctype="multipart/form-data"id="tbs2"name="myforms">
                            <div class="form-group">
                                <label> عنوان المقال</label>
                                <input type="text" name="postTitle" autofocus class="form-control"  value="<?php echo $rowp["postTitle"]; ?>">
                            </div>
                            <div class="form-group">
                                <label>  التصنيف</label>
                                <select name="postCategory" class="form-control"id="poCa">
                                    <?php 
                                        $qu="select categoryName from category";
                                        @$exec=mysqli_query($con,$qu);
                                        $vals=$rowp["postCategory"];
                                        echo "<option value='$vals'>";
                                        echo $vals;
                                        echo "</option>";
                                while($row=mysqli_fetch_assoc($exec)){
                                    $s=$row["categoryName"];
                                    if($rowp["postCategory"]==$s){
                                        continue;
                                    }
                                    echo "<option value='$s'>";
                                    echo $row["categoryName"];
                                    echo "</option>";
                                    
                                
                                }
                                    ?>
                          
                               </select>
                            </div>
                            <div class="form-group">
                                <label> صورة المقال</label><br><span style="color:red;font-size:15px;">قم بختيار صورة المنشور مرة اخري</span>
                               <input type="file"id="form-img" class="form-control"name="postImage"required>
                            </div>
                            <div class="form-group">
                                <label> نص المقال</label>
                                <textarea col="30" rows="10" class="form-control"name="postContent" id="bodyx" >
                                <?php echo $rowp["postContent"]; ?>
                              </textarea>
                            </div>
                            <button class="btn-custom "name="edPost" id="btn">تعديل المقال</button>
                        </form>
              <?php           
                         } }  }else{
                            echo"<center><div class='alert alert-primary'>";
                            echo "  قم بالعودة الي ";
                            echo "<br><a href='every-Posts.php'>جميع المنشورات</a>";
                            echo"</div></center>"; 
                        } ?>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end content -->
    <?php include_once "include/footer.php"; ?>