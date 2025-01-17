<?php 
date_default_timezone_set("Africa/Cairo");
session_start();
if(!isset($_SESSION["adminName"])){
    header("location:login.php");
    exit;
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
                    
                        if(isset($_POST["addMember"])){
                            if(empty($_POST["memberName"])){
                        echo "<div class='alert alert-danger'>الرجاء ملئ الحقول ادناة</div>";
                            }
                                    elseif(strlen($_POST["memberName"])>400){
                        echo "<div class='alert alert-danger'>اسم العضو كبير جدا</div>";
                            }else{
                               
                                   /* اسم الصورة الي محملها */ 
                                    $imageName=$_FILES["memberImage"]["name"];
                                    /*الاسم الموقت للصورة الي محملهات*/
                                    $imageTmpName=$_FILES["memberImage"]["tmp_name"];
                                 //بتولدلي ارقام عشوائية كل ما يتم اضافة صورة جديدة
                                   /*  عمل اسم جديد للصورة الي هيتخزن في القاعدة*/
                                     $memberImage=rand(0,10000)."_". $imageName;
                                    /*تخزين الصورة المتحملة بعد تغير اسمها
                                     في مجلد علي الجهاز بتاعي (السيرفر بتاعي)*/
                                    move_uploaded_file($imageTmpName,"uploads/teamImages/".$memberImage);
                                   
                                    $memberName=filter_var($_POST["memberName"],FILTER_SANITIZE_STRING);
                                    $memberName=htmlspecialchars($memberName);
                            
                                    $memberDate=date("Y-m-d");
                                    $query="insert into team(memberName,memberImage,memberDate) 
                                    values('$memberName','$memberImage','$memberDate')";
                                    @$execin=mysqli_query($con,$query);
                                    if($execin){
                                        echo"<div class='alert alert-success'>تمت اضافة العضو بنجاح</div>";
                                    }else{
                                        echo "<div class='alert alert-danger'>هناك مشكلة في اضافة العضو</div>";
                                    }
                               
                            }
                        }
                        
                        ?>
                        <h4> <i class="far fa-plus-square"></i> اضافة عضو جديد </h4>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST"enctype="multipart/form-data"id="tbs2">
                            <div class="form-group">
                                <label> اسم العضو</label>
                                <input type="text" name="memberName"required class="form-control"autofocus style="direction:rtl">
                            </div>
                        
                            <div class="form-group">
                                <label> صورة العضو</label>
                                <input type="file" class="form-control"name="memberImage"required>
                            </div>
             
                            <button class="btn-custom "name="addMember">اضافة عضو</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
    <?php include_once "include/footer.php"; ?>