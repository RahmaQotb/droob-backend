 
<?php
  include "include/connection.php";
  date_default_timezone_set("Africa/Cairo");
  session_start();
   ?>
       <?php

if(isset($_GET["idPost"])&& !empty($_GET["idPost"])&& filter_var( $_GET["idPost"],FILTER_VALIDATE_INT)){
    $zxsw=filter_var( $_GET["idPost"],FILTER_SANITIZE_NUMBER_INT);  
$qz="select * from post where postId='$zxsw'";
@$execxa=mysqli_query($con,$qz);
if(mysqli_num_rows($execxa)==0){
    echo "<b><center>المنشور غير موجود</center></b>";
        }else{
while($row=mysqli_fetch_assoc($execxa)){  ?>

        <?php 
        $postT=$row["postTitle"];
        $postD=strip_tags(substr($row["postContent"],0,150)."....");
        $postI=$row["postImage"];
        
        ?>
        <?php 
                        }}
                        }else{
                            echo "<div style='font-weight:bold;color:red;font-size:28px;text-align:center'>";
                            echo " <i class='fas fa-exclamation-triangle'></i> ";
                            echo"هناك مشكلة";
                        }
                            ?>
   <?php  
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
      
   
 
  ?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" class="posr-dis" content=" ALCRYPTONZ" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--facebook-->
    <meta property="og:url"      class="post-urls"      content="<?php echo $url; ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         class="tit-li"  content="<?php echo $postT; ?>" />
        <meta property="og:description"  class="posr-dis2"  content="<?php echo $postD; ?>" />
        <meta property="og:image"         content="uploads/postImages/<?php echo $postI; ?>" />               
       <!--twitter-->
       <meta name="twitter:title" content="<?php echo $postT; ?>">
<meta name="twitter:description" content="<?php echo $postD; ?>">
<meta name="twitter:image" content="uploads/postImages/<?php echo $postI; ?>">
<meta name="twitter:card" content="summary_large_image">
        <!--IMPROVE SEO-->
    <meta name="keywords" content="العملات الرقمية ، مدونة الكريبتونز ، مقالات عن العملات الرقمية، العملات ، الرقمية ، alcryptonz ، ">
    <meta name="copyright" content="جميع الحقوق محفوظة لفريق الكريبتونز">
    <meta name="email" content="contactus@alcryptonz.com">
    <link rel="canonical" href="https://www.alcryptonz.com/" >
       <!-- ICON  -->
       <link rel="shortcut icon" type="image/jpeg" href='images/new-big-logo.jpeg' />
    <!-- Font Awesome -->
    <link rel="stylesheet" href='css/all.css' />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
    <!-- bootstrap Styling -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
 

    <!-- Custom Styling -->
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $postT; ?></title>
    
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

                        <?php

                        if(isset($_GET["idPost"])&& !empty($_GET["idPost"])&& filter_var( $_GET["idPost"],FILTER_VALIDATE_INT)){
                            $zxs=filter_var( $_GET["idPost"],FILTER_SANITIZE_NUMBER_INT);  
                        $q="select * from post where postId='$zxs'";
                        @$execx=mysqli_query($con,$q);
                        if(mysqli_num_rows($execx)==0){
                            echo "<b><center>المنشور غير موجود</center></b>";
                                }else{
                        while($row=mysqli_fetch_assoc($execx)){  ?>

                        <div class="post"style="direction:rtl">
                        <div class="post-image">
                      
                         <img class="postimg" src="uploads/postImages/<?php echo $row["postImage"]; ?>" alt="image here">
                         <?php 
                         $ccxsp=$row["postImage"];
                         $ccvq="uploads/postImages/$ccxsp";
                         $_SESSION["postimaged"]=$ccvq;
                         ?>
                        </div>
                        <div class="post-title posttir"style='overflow:hidden !important'>
                        <h2 style='width:100%;  word-wrap: break-word;'  >   <?php 
                                    echo $row["postTitle"];
                                 ?></h2>
                        <?php $_SESSION["pt"]=$row["postTitle"]; ?>
                         <?php $_SESSION["pi"]=$row["postId"]; ?>
                        </div>
                        <div class="share-post"style='direction:ltr !important'>
                          
              <?php              if( isset($_GET["idPost"])&& !empty($_GET["idPost"]) 
              && filter_var( $_GET["idPost"],FILTER_VALIDATE_INT) && filter_var( $url,FILTER_VALIDATE_URL)) { ?>
    
    <ul>
    <?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
       <?php   $text = rawurlencode("https://www.alcryptonz.com/post.php?idPost=".$_SESSION["pi"]."&cp=". $_SESSION["pc"]."");
                ?>
<li><a href="#"class="facebook-btn"target="_blank"><i class="fab fa-facebook-square"></i></a></li>
<li><a href="#"class="whats-btn"target="_blank"><i class="fab fa-whatsapp-square"></i></a></li>   
<li> <a href="#"class="twiter-btn"target="_blank"><i class="fab fa-twitter-square"></i></a></li>
       
        <li><a class="email" href="mailto:?subject=<?php echo $postT; ?>&amp;body=<?php echo $text; ?>" onclick="window.open(this.href, 'windowName', 'width=500, height=400, left=24, top=24, scrollbars, resizable'); return false;" rel="nofollow"><i class="fas fa-envelope-square"></i></a></li>
    </ul>
          <?php    }else{
                           echo "<div style='font-weight:bold;color:red;font-size:28px;text-align:center'>";
                           echo " <i class='fas fa-exclamation-triangle'></i> ";
                           echo"هناك مشكلة";
                           echo "</div>";

          } ?>
                            </div>
                        <div class="post-details"style="overflow:hidden !important;">
                            <p class="post-info">
                            <span> <?php echo $row["postAuthor"]; ?> &nbsp;<i class="fas fa-user"></i></span><br>
                        <span><?php echo $row["PostDate"]; ?>&nbsp; <i class="far fa-calendar-alt"></i></span>
                        <span> <?php echo $row["postCategory"]; ?>  &nbsp; <i class="fas fa-tags"></i> </span>
                            </p><?php  $_SESSION["pd"]=$row["PostDate"]; ?>
                            <?php $_SESSION["pc"]=$row["postCategory"]; ?>
                            <div class="post-content" >
                                
                                <?php
                                $rthg=str_replace("&nbsp;"," ",$row["postContent"]); 
                                    echo $rthg;
                                    $_SESSION["conzo"]=strip_tags(substr($rthg,0,150)."....");
                                 ?>

                            </div>
                           
                        </div>
                    </div>
                        <?php 
                        }}
                        }else{
                            echo "<div style='font-weight:bold;color:red;font-size:28px;text-align:center'>";
                            echo " <i class='fas fa-exclamation-triangle'></i> ";
                            echo"هناك مشكلة";
                            echo "</div>";
                        }
                        ?>
                            <!--منشورات لها علاقة-->


           

                            <div class="related-posts">
                        <h4> مقالات قد تعجبك</h4>
                        <ul>
                        <?php 
                      
                       
                           if( isset($_GET["idPost"])&&
                            !empty($_GET["idPost"])&& filter_var( $_GET["idPost"],FILTER_VALIDATE_INT) ){
                            
                               $z=filter_var( $_GET["idPost"],FILTER_SANITIZE_NUMBER_INT); 
                            $querys="select * from post where postId <> ' $z' order by postId desc";
                            @$execc=mysqli_query($con,$querys);
                            if(mysqli_num_rows($execc)==0){
                        echo "<b><center>لا يوجد منشورات متعلقة بهذا المنشور</center></b>";
                            }else{
                            $nom=0;
                           while($row=mysqli_fetch_assoc($execc)){ 
                               $nom++;
                               ?>

                            <li>
                                <a style="direction:rtl;text-align:right"href="post.php?idPost=<?php echo $row["postId"]; ?>&cp=<?php echo $row["postCategory"]; ?>"target="_blank">
                                    <span><img src="uploads/postImages/<?php echo $row["postImage"]; ?>"alt="image here"style="width:75px; height: 60px;"></span>
                                    <span style="max-height:80px;overflow:hidden"><?php 
                               
                                        echo $row["postTitle"];
                                    
                                    ?></span>
                                </a>
                            </li>
                            <?php 
                            if($nom==5){
                                break;
                                                        }
                        }
                    }}else{
                      
                            echo "<div style='font-weight:bold;color:red;font-size:28px;text-align:center'>";
                            echo " <i class='fas fa-exclamation-triangle'></i> ";
                            echo"هناك مشكلة";
                            echo "</div>";
                        
                    }
                            ?>
                        </ul>
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
       <!-- JQuery and JS for bootstrap -->
       <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--Coin Price Marquee Widget-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/coinMarquee.js"></script>
     <!-- online editor Styling -->
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>
 <!-- slick js-->
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
       <!-- custom js-->
    <script src="js/main.js"></script>
    <script src="js/forshare.js"></script>
</body>

</html>
