<?php
  include "include/connection.php";
  date_default_timezone_set("Africa/Cairo");
  
session_start();

?>
         <?php 
                                if(isset($_POST["logout"])){
                                    session_unset();
                                    session_destroy();
                                    header("location:login.php");
                                }
                                ?>
                        
    <?php 
                   if(empty($_SESSION["keys"])){
                    $_SESSION["keys"]=bin2hex(random_bytes(32));
                  }
                  $csrfs=hash_hmac("sha256","this is some string : search-result.php",$_SESSION["keys"]);
               
        if(isset($_POST["addAdmin"])){
            if(hash_equals($csrfs,$_POST["csrfs"])){
                if(empty($_POST["adminEmail"])||empty($_POST["adminPassword"])){
                    echo "<div class='alert alert-danger'>الرجاء ملئ الحقول ادناة</div>";
                }
                elseif(strlen($_POST["adminEmail"])>50||strlen($_POST["adminPassword"])>50 ){
                    echo "<div class='alert alert-danger'> المحتوي كبير جدا</div>";
                        }else{
                            if(filter_var($_POST["adminEmail"],FILTER_VALIDATE_EMAIL)){
                   $adminEmail= $_POST["adminEmail"];
                   $adminPassword= $_POST["adminPassword"];
                   $query="select * from admin where adminEmail='$adminEmail' and adminPassword='$adminPassword'";
                   @$exex=mysqli_query($con,$query);
                   $row=mysqli_fetch_assoc($exex);
                   if(mysqli_num_rows($exex)>0){
                    
                    $frhj=filter_var($row["adminName"],FILTER_SANITIZE_STRING);
                    $_SESSION["adminName"]=htmlspecialchars($frhj);
                    echo "<div class='alert alert-success' style='text-align:center'><br> تم تسجيل الدخول بنجاح  اذهب الي <br>  <a href='categories.php' style=' text-decoration: underline;
                    font-weight: bold;'>لوحة التحكم</a> </div>";
      
                  header("location:categories.php");       
                   }else{
                    echo "<div class='alert alert-danger'><center>بيانات غير صحيحة </center></div>"; 
                   }
                }else{
                    echo "<div class='alert alert-danger'><center>  بريد الكتروني غير صالح </center></div>"; 
                }
                }
            }else{
                echo "<div style='font-weight:bold;color:red;font-size:28px;text-align:center'>";
                echo " <i class='fas fa-exclamation-triangle'></i> ";
                echo" ERROR";
                echo "</div>";
            }

            }
        ?>
<?Php 
  include "include/header.php";
   ?>
     

 <title>ALCRYPTONS</title>
    <!-- Custom Styling -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2473974671507788"
     crossorigin="anonymous"></script>
     
</head>

<body>
    <!-- start navbar -->
    <?php include "include/anotherNavBar.php"; ?>
    <!-- end navbar -->
    <div class="login">

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>"method="POST">
            <h5> <i class="fas fa-tasks"></i> &nbsp; لوحة التحكم  </h5>
            <input type="hidden"  name="csrfs"value="<?php echo $csrfs; ?>">
            <div class="form-group"style="text-align: right !important;">
                  <label for="name" > البريد الالكتروني</label>
                  <input type="email"name="adminEmail" class="form-control"id="email"required>
            </div>
            <div class="form-group"style="text-align: right !important;">
                <label for="pass" >كلمة السر</label>
                <input type="password"name="adminPassword" class="form-control"id="pass"required>
            </div>
            <button type="submit" name="addAdmin"> تسجيل الدخول</button>
        </form>
    </div>

    <!-- end footer -->
    <?php include "include/footer.php"; ?>