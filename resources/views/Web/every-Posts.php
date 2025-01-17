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
                    if(isset($_GET["deletePost"])&& filter_var( $_GET["deletePost"],FILTER_VALIDATE_INT)){
                         $kokolpp=filter_var( $_GET["deletePost"],FILTER_SANITIZE_NUMBER_INT); 
                         $select="select * from post where postId='$kokolpp' ";
                         @$execselecx=mysqli_query($con,$select);
                         if(mysqli_num_rows($execselecx)==0){
                             echo " ";
                         }else{
                       while($row=mysqli_fetch_assoc($execselecx)){
                             $sdrt=$row["postImage"];
                             unlink("uploads/postImages/".$sdrt);
                         
                       }
                                $qudel="delete from post where postId='$kokolpp'";
                                @$execdel = mysqli_query($con,$qudel);
                                if($execdel){
                                echo"<div class='alert alert-success'style='text-align:center'>تم الحذف بنجاح</div>";
                                }else{
                                    echo "<div class='alert alert-danger'style='text-align:center'>هناك مشكلة في الحذف </div>";
                                }
                            }}
                            ?>
                    <h4>  كل المقالات</h4>
                    <table class="table"id="tbs"style="direction:rtl">
                            <tr>
                                <th>رقم المقال</th>
                                <th>عنوان المقال</th>
                                <th>كاتب المقال</th>
                                <th>صورة المقال</th>
                                <th>تاريخ المقال</th>
                                <th>تصنيف المقال</th>
                                <th>تعديل</th>
                                <th>حذف </th>
                            </tr>
                            <?php
                            $select="select * from post order by postId desc";
                            @$execselec=mysqli_query($con,$select);
                            $no=0;
                            while($row=mysqli_fetch_assoc($execselec)){
                                $no++;
                                echo "<tr>";
                                echo "<td>". $no."</td>";
                                echo "<td>".$row["postTitle"]."</td>";
                                echo "<td>".$row["postAuthor"]."</td>";
                                echo "<td> <img src='uploads/postImages/".$row["postImage"]."'alt='image here'style='width:50px;height:50px'></td>";
                                echo "<td>".$row["PostDate"]."</td>";
                                echo "<td>".$row["postCategory"]."</td>";
                                echo "<td><a class ='btn btn-primary'href='edit-Post.php?editPost=". $row["postId"]."'>تعديل</a></td>";
                                echo "<td><a class ='btn btn-danger'href='every-Posts.php?deletePost=". $row["postId"]."'>حذف</a></td>";
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