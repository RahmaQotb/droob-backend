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
                    
                        if(isset($_POST["addPartner"])){
                            if(empty($_POST["partnerName"])){
                        echo "<div class='alert alert-danger'style='text-align:center'>الرجاء ملئ الحقول ادناة</div>";
                            }
                         elseif(strlen($_POST["partnerName"])>400&&strlen($_POST["partnerLink"])>1000){
                        echo "<div class='alert alert-danger'style='text-align:center'>   نص كبير جدا</div>";
                            } else{
                                if(filter_var( $_POST["partnerLink"],FILTER_VALIDATE_URL)){
                                 
                                   /* اسم الصورة الي محملها */ 
                                    $imageName=$_FILES["partnerImage"]["name"];
                                    /*الاسم الموقت للصورة الي محملهات*/
                                    $imageTmpName=$_FILES["partnerImage"]["tmp_name"];
                                 //بتولدلي ارقام عشوائية كل ما يتم اضافة صورة جديدة
                                   /*  عمل اسم جديد للصورة الي هيتخزن في القاعدة*/
                                     $partnerImage=rand(0,10000)."_". $imageName;
                                    /*تخزين الصورة المتحملة بعد تغير اسمها
                                     في مجلد علي الجهاز بتاعي (السيرفر بتاعي)*/
                                    move_uploaded_file($imageTmpName,"uploads/partnerImages/".$partnerImage);
                                    $partnerName=filter_var($_POST["partnerName"],FILTER_SANITIZE_STRING);
                                    $partnerName=htmlspecialchars($partnerName);
                                  
                                    $partnerLink= $_POST["partnerLink"];
                                    //$postContent=strip_tags( $postContent);
                                    //$postContent=filter_var($postContent,FILTER_SANITIZE_STRING);
                                    $partnerDate=date("Y-m-d h:i:s");
                                    $query="insert into partner(partnerName,partnerImage,partnerDate,partnerLink) 
                                    values('$partnerName','$partnerImage','$partnerDate','$partnerLink')";
                                    @$execin=mysqli_query($con,$query);
                                    if($execin){
                                        echo"<div class='alert alert-success'style='text-align:center'>تمت اضافة الشريك بنجاح</div>";
                                    }else{
                                        echo "<div class='alert alert-danger'style='text-align:center'>هناك خطء في اضافة الشريك</div>";
                                    }
                                    $catName= $partnerName;
                                    $catDate=date("Y-m-d");
                                    $insert="insert into category(categoryName,categoryDate) values('$catName',' $catDate')";
                                    $execx=mysqli_query($con,$insert);
                            }else{
                                echo "<div class='alert alert-danger'style='text-align:center'>رابط غير صالح</div>";
                          
                            }}
                        }
                        
                        ?>
                        <h4> <i class="far fa-plus-square"></i> اضافة شريك جديد </h4>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST"enctype="multipart/form-data"id="tbs2">
                            <div class="form-group">
                                <label> اسم الشريك</label>
                                <input type="text" name="partnerName"required class="form-control"autofocus style="direction:rtl">
                            </div>
                            <div class="form-group">
                                <label> رابط موقع الشريك</label>
                                <input type="text" name="partnerLink" required class="form-control"autofocus>
                            </div>
                        
                            <div class="form-group">
                                <label> صورة الشريك</label>
                                <input type="file" class="form-control"name="partnerImage"required>
                            </div>
             
                            <button class="btn-custom "name="addPartner">اضافة شريك</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
    <?php include_once "include/footer.php"; ?>