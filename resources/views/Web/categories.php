<?php 
include "include/connection.php";
date_default_timezone_set("Africa/Cairo");
session_start();
if(!isset($_SESSION["adminName"])){
    header("location:login.php");
}


include_once "include/header.php"; ?>
<title>لوحة التحكم</title>
    <!-- Custom Styling -->
    
    <link rel="stylesheet" href="css/dashboard.css">
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
                        if(isset($_POST["addCategory"])){
                            if(empty($_POST["categoryName"])){
                                echo"<div class='alert alert-danger'style='text-align:center'>حقل التصنيف فارغ</div>";
                            }elseif(strlen($_POST["categoryName"])>100){
                                echo"<div class='alert alert-danger'style='text-align:center'>حقل التصنيف كبير جدا</div>";
                            }
                            else{
                                $categoryName=filter_var($_POST["categoryName"],FILTER_SANITIZE_STRING);
                                $categoryName=htmlspecialchars($categoryName);
                                $categoryDate=date("Y-m-d");
                                $insert="insert into category(categoryName,categoryDate) values('$categoryName',' $categoryDate')";
                                @$exec=mysqli_query($con,$insert);
                                if($exec){
                                    echo"<div class='alert alert-success'style='text-align:center'>تمت اضافة التصنيف</div>";
                                }else{
                                    echo "<div class='alert alert-danger'style='text-align:center'>هناك مشكلة في اضافة التصنيف</div>";
                                }
                            }
                        
                        }
                        if(isset($_GET["deleteCategory"] )  && filter_var( $_GET["deleteCategory"],FILTER_VALIDATE_INT)){
                           $kokolp=filter_var( $_GET["deleteCategory"],FILTER_SANITIZE_NUMBER_INT);  
                        $qudel="delete from category where categoryId='$kokolp' ";
                        @$execdel = mysqli_query($con,$qudel);
                        if($execdel){
                        echo"<div class='alert alert-success'style='text-align:center'>تم الحذف بنجاح</div>";
                        }else{
                            echo "<div class='alert alert-danger'style='text-align:center'>هناك مشكلة في الحذف </div>";
                        }
                    }
                        ?>
                    <h4> <i class="far fa-plus-square"></i>  اضافة تصنيف جديد</h4>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                            <div class="form-group">
                                <label>تصنيف جديد</label>
                                <input type="text" name="categoryName" class="form-control">
                            </div>

                            <button class="btn-custom "name="addCategory">اضافة</button>
                        </form>
                    </div>
                    <!--start display category-->
                    <div class="display-cat mt-5">
                        <h4>كل التصنيفات</h4>
                    <table class="table" >
                            <tr>
                                <th>رقم الفئة</th>
                                <th>اسم الفئة</th>
                                <th>تاريخ اضافة الفئة</th>
                                <th>حذف الفئة</th>
                            </tr>
                            <?php
                            $select="select * from category order by categoryId desc";
                            @$execselec=mysqli_query($con,$select);
                            $no=0;
                            while($row=mysqli_fetch_assoc($execselec)){
                                $no++;
                                echo "<tr>";
                                echo "<td>". $no."</td>";
                                echo "<td>".$row["categoryName"]."</td>";
                                echo "<td>".$row["categoryDate"]."</td>";
                                echo "<td><a class ='btn btn-danger'href='categories.php?deleteCategory=". $row["categoryId"]."'>حذف</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <!--end display category-->
                </div>
            </div>
        </div>
    </div>

                
    <!-- end content -->
    <?php include_once "include/footer.php"; ?>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YN940EKWRS"></script>
<script>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2473974671507788"
     crossorigin="anonymous"></script>
     
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YN940EKWRS');
</script>