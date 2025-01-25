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
                    if(isset($_GET["deleteMember"])){
                        $zsdr=filter_var( $_GET["deleteMember"],FILTER_SANITIZE_NUMBER_INT); 
                        $selectx="select * from team where memberId='$zsdr' ";
                        @$execselecx=mysqli_query($con,$selectx);
                        if(mysqli_num_rows($execselecx)==0){
                            echo "<div class='alert alert-danger'style='text-align:center'>هناك مشكلة في الحذف! </div>";
                        }else{
                      while($row=mysqli_fetch_assoc($execselecx)){
                            $sdrt=$row["memberImage"];
                            unlink("uploads/teamImages/".$sdrt);
                        
                      }
                                $qudel="delete from team where memberId='$zsdr'";
                                @$execdel = mysqli_query($con,$qudel);
                                if($execdel){
                                echo"<div class='alert alert-success'>تم الحذف بنجاح</div>";
                                }else{
                                    echo "<div class='alert alert-danger'>هناك مشكلة في الحذف </div>";
                                }
                            }}
                            ?>
                    <h4>  كل الشركاء</h4>
                    <table class="table"id="tbs"style="direction:rtl">
                            <tr>
                                <th>رقم العضو</th>
                                <th>اسم العضو</th>
                                <th>صورة العضو</th>
                                <th>تاريخ انضمام العضو</th>
                                <th>حذف العضو</th>
                            </tr>
                            <?php
                            $select="select * from team ";
                            $execselec=mysqli_query($con,$select);
                       
                            while($row=mysqli_fetch_assoc($execselec)){
                             
                                echo "<tr>";
                                echo "<td>".$row["memberId"]."</td>";
                                echo "<td>".$row["memberName"]."</td>";
                                echo "<td> <img src='uploads/teamImages/".$row["memberImage"]."'alt='image here'style='width:50px;height:50px'></td>";
                                echo "<td>".$row["memberDate"]."</td>";
 
                                echo "<td><a class ='btn btn-danger'href='every-members.php?deleteMember=". $row["memberId"]."'>حذف</a></td>";
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