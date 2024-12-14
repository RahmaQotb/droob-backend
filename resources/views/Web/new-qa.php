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
                    
                        if(isset($_POST["addQa"])){
                            if(empty($_POST["qaAsk"]) || empty($_POST["qaAnswer"])){
                        echo "<div class='alert alert-danger'>الرجاء ملئ الحقول ادناة</div>";
                            }
                                    elseif(strlen($_POST["qaAsk"])>100000 ||strlen($_POST["qaAnswer"])>100000 ){
                        echo "<div class='alert alert-danger'> المحتوي كبير جدا</div>";
                            }else{

                                $qaAsk=filter_var($_POST["qaAsk"],FILTER_SANITIZE_STRING);
                                $qaAsk=htmlspecialchars($qaAsk);
                              

                                    $qaAnswer=mysqli_real_escape_string($con,$_POST["qaAnswer"]);
                           
                                    $queryf="insert into qa(qaAsk,qaAnswer) 
                                    values('$qaAsk','$qaAnswer')";
                                    @$execina=mysqli_query($con,$queryf);
                                    if($execina){
                                        echo"<div class='alert alert-success'>تمت اضافة السؤال بنجاح</div>";
                                    }else{
                                        echo "<div class='alert alert-danger'>هناك مشكلة في اضافة السؤال</div>";
                                    }
                            }
                        }
                        
                        ?>
                        <h4> <i class="far fa-plus-square"></i> اضافة سؤال و جواب </h4>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                            <div class="form-group">
                                <label> السؤال</label>
                                <input type="text" name="qaAsk" required class="form-control"autofocus>
                            </div>
                   
                       
                            <div class="form-group">
                                <label>  الجواب</label>
                                <textarea col="30" rows="10" required class="form-control"name="qaAnswer">

                              </textarea>
                            </div>
                            <button class="btn-custom "name="addQa" id="btn">نشر السؤال</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
    <?php include_once "include/footer.php"; ?>