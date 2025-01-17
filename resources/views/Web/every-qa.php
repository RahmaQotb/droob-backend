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
                    if(isset($_GET["deleteqa"])){
                        $zsdrsa=filter_var( $_GET["deleteqa"],FILTER_SANITIZE_NUMBER_INT); 
                        
                                $qudelx="delete from qa where qaId='$zsdrsa'";
                                @$execdelx = mysqli_query($con,$qudelx);
                                if($execdelx){
                                echo"<div class='alert alert-success'>تم الحذف بنجاح</div>";
                                }else{
                                    echo "<div class='alert alert-danger'>هناك مشكلة في الحذف </div>";
                                }
                            }
                            ?>
                    <h4>  كل الاسئلة</h4>
                    <table class="table"id="tbs"style="direction:rtl">
                            <tr>
                                <th>رقم السؤال</th>
                                <th> السؤال</th>
                                <th>الجواب </th>
                                <th>حذف السؤال</th>
                            </tr>
                            <?php
                            $selectc="select * from qa order by qaId desc";
                            $execselecx=mysqli_query($con,$selectc);
                            $no=0;
                            while($row=mysqli_fetch_assoc($execselecx)){
                                $no++;
                                echo "<tr>";
                                echo "<td>". $no."</td>";
                                echo "<td>".$row["qaAsk"]."</td>";
                                echo "<td>".$row["qaAnswer"]."</td>";
 
                                echo "<td><a class ='btn btn-danger'href='every-qa.php?deleteqa=". $row["qaId"]."'>حذف</a></td>";
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