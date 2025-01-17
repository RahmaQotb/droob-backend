<?php 
include "include/connection.php"; 
date_default_timezone_set("Africa/Cairo");
session_start();
if(!isset($_SESSION["adminName"])){
    header("location:login.php");
    header("REFRESH:0;URL=login.php");
}

include_once "include/header.php"; 
?>
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
                    <div class="display-cat mt-5">
                        <?php
                    if(isset($_GET["deletePartner"]) && isset($_GET["dPN"])){
                        $ertg=filter_var( $_GET["deletePartner"],FILTER_SANITIZE_NUMBER_INT);
                        $select="select * from partner where partnerId='$ertg' ";
                        @$execselecx=mysqli_query($con,$select);
                        if(mysqli_num_rows($execselecx)==0){
                            echo "<div class='alert alert-danger'style='text-align:center'>هناك مشكلة في الحذف! </div>";
                        }else{
                      while($row=mysqli_fetch_assoc($execselecx)){
                            $sdrt=$row["partnerImage"];
                            unlink("uploads/partnerImages/".$sdrt);
                        
                      }
  
                                $qudel="delete from partner where partnerId='$ertg'";
                                @$execdel = mysqli_query($con,$qudel);
                                if($execdel){
                                echo"<div class='alert alert-success'style='text-align:center'>تم الحذف بنجاح</div>";
                              
                                }else{
                                    echo "<div class='alert alert-danger'style='text-align:center'>هناك مشكلة في الحذف </div>";
                                }
                                $qwe=filter_var($_GET["dPN"],FILTER_SANITIZE_STRING);
                                $qwe=htmlspecialchars($qwe);
                                $qudela="delete from category where categoryName='$qwe'";
                                @$execdelk = mysqli_query($con,$qudela);
                            }}
                            ?>
                    <h4>  كل الشركاء</h4>
                    <table class="table"id="tbs"style="direction:rtl">
                            <tr>
                                <th>رقم الشريك</th>
                                <th>اسم الشريك</th>
                                <th>صورة الشريك</th>
                                <th>تاريخ انضمام الشريك</th>
                                <th>رابط الشريك</th>
                                <th>حذف الشريك</th>
                            </tr>
                            <?php
                            $select="select * from partner order by partnerId desc";
                            $execselec=mysqli_query($con,$select);
                       
                            while($row=mysqli_fetch_assoc($execselec)){
                             
                                echo "<tr>";
                                echo "<td>".$row["partnerId"]."</td>";
                                echo "<td>".$row["partnerName"]."</td>";
                                echo "<td> <img src='uploads/partnerImages/".$row["partnerImage"]."'alt='image here'style='width:50px;height:50px'></td>";
                                echo "<td>".$row["partnerDate"]."</td>";
                                echo "<td>".$row["partnerLink"]."</td>";
                                echo "<td><a class ='btn btn-danger'href='every-partners.php?deletePartner=". $row["partnerId"]."&dPN=".$row["partnerName"]."'>حذف</a></td>";
                                echo "</tr>";
                            }
                       
                            ?>
                        </table>
                 
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
<?php include_once "include/footer.php"; ?>