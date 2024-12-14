
<?php
  include "include/connection.php";
  date_default_timezone_set("Africa/Cairo");
  session_start();
   if(empty($_SESSION["keysss"])){
    $_SESSION["keysss"]=bin2hex(random_bytes(32));
  }
  $csrfsss=hash_hmac("sha256","this is some string : search-result.php",$_SESSION["keysss"]);
  include "include/header.php";
   ?>


 <title>Q&A
</title>
    <!-- Custom Styling -->
    <link rel="stylesheet" href="css/style.css">
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2473974671507788"
     crossorigin="anonymous"></script>
     
</head>

<body id="top-page">
    <!-- start navbar -->
    <?php include "include/anotherNavBar.php"; ?>
    <!-- end navbar -->
    <!--start Arrow to top Page -->
<a href="#top-page" style="position:fixed;right:15px;bottom:15px;font-size:32px; color:black;z-index:68544;background-color:white;padding:0 5px;border-radius:5px;" ><i class="fas fa-chevron-circle-up" style="border:1px solid white;"></i></a>
<!--End Arrow to top Page -->
        <!-- start content -->
        <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                   <h2 class="header-title"> Q&A</h2>
                   <div class="post">
                                         <!--start form search-->
                 <div class="form-qa">
                    <form action ="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST"style='text-align:center !important;'>
                         <input type="hidden"  name="csrfsss"value="<?php echo $csrfsss; ?>">
                    <button  name="goSearch"><i class="fas fa-search "></i></button>
                        <input type="text" placeholder="بحث عن سؤال" name="searched"required>
                       
               
                    </form>
                </div>
                   <!--End form search-->
                   <!--start result search-->
                   <?php

  
                        if(isset($_POST["goSearch"])){
                     
                            if(hash_equals($csrfsss,$_POST["csrfsss"])){
                                echo "<h3 class='header-title'> نتائج البحث</h3>";
                                $rtyu=filter_var($_POST["searched"],FILTER_SANITIZE_STRING);
                                $rtyu=htmlspecialchars($rtyu);
                         
                                if(strlen($rtyu)>190){
        echo "<b><center>الذي بحثت عنة كبير جدا</center></b>";
    }else{
    
                                $searchWord="%".$rtyu."%";
                            $qpsz="select * from qa where qaAsk like '$searchWord' order by qaId desc";
                            @$execuationsxx=mysqli_query($con,$qpsz);
                            if(mysqli_num_rows($execuationsxx)==0){
                                echo "<b style='padding:10px;'><center>لا يوجد أي سؤال متعلق بالذي تبحث عنة</center></b>";
                                    }else{
                            while($row=mysqli_fetch_assoc($execuationsxx)){  ?>
                                                   <!--qustion-->
                           <div class="quasion"style="overflow:hidden !important">
                            <div class="ask"style="overflow:scroll !important;direction: rtl !important">
                              <?php  echo  str_replace("&nbsp;"," ",$row["qaAsk"]); ?>  <i class="fas fa-question-circle "></i>
                            </div>
                            <div class="answer"style="overflow:scroll !important;direction: rtl !important">
                            <?php  echo str_replace("&nbsp;"," ",$row["qaAnswer"]) ; ?>
                                </div>
                           </div>
     <?php  } } }
                            }else{
                                echo "<div style='font-weight:bold;color:red;font-size:28px;text-align:center'>";
                                echo " <i class='fas fa-exclamation-triangle'></i> ";
                                echo" ERROR";
                                echo "</div>";
                            }
}?>
                        <!--end search result-->


<h3 class="header-title">جميع الاسئلة</h3>
<?php
   $querys="select * from qa ";
                            @$execcx=mysqli_query($con,$querys);
                            if(mysqli_num_rows($execcx)==0){
                                echo "<b><center>لا يوجد اسئلة </center></b>";
                                    }
             
                           while($row=mysqli_fetch_assoc($execcx)){ 
                           
                               ?>
                       <!--qustion-->
              <div class="quasion"style="overflow:hidden !important">
                            <div class="ask"style="overflow:scroll !important;direction: rtl !important">
                              <?php  echo  str_replace("&nbsp;"," ",$row["qaAsk"]); ?>  <i class="fas fa-question-circle "></i>
                            </div>
                            <div class="answer"style="overflow:scroll !important;direction: rtl !important">
                            <?php  echo str_replace("&nbsp;"," ",$row["qaAnswer"]) ; ?>
                                </div>
                           </div>
 <?php  } ?>
             
                
                   </div>
                        </div>
                    
                <div class="col-md-4">
                     <!-- start social  -->
                     <?php include_once "include/social.php"; ?>
                    <!-- end social  -->
                                       <!-- start latest Partners posts -->
                                       <?php include_once "include/lateast-Partners-Posts.php"; ?>
                    <!-- end latest Partners posts -->
                <!-- start latest posts -->
                       <?php include_once "include/lateastPosts.php"; ?>
                    <!-- end latest posts -->
                                                                        <!-- start latest alcrypto posts -->
                                                                        <?php include_once "include/newsAl.php"; ?>
                    <!-- end latest alcrypto posts -->
                     <!-- start  categoreis -->
                <?php include_once "include/catPart.php"; ?>
                 <!-- end categoreis -->
                         <!-- start contr  -->
                         <?php include_once "include/contr.php"; ?>
                    <!-- end contr  -->
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->
        <!-- start footer -->
        <?php include_once "include/underfooter.php"; ?>
    <!-- end footer -->
    <?php include_once "include/footer.php"; ?>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YN940EKWRS"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YN940EKWRS');
</script>
