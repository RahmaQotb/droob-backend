<footer id="fo" > 
      <!-- email contact form-->
      <?php
  use PHPMailer\PHPMailer\PHPMailer;
     use PHPMailer\PHPMailer\SMTP;
     use PHPMailer\PHPMailer\Exception;
     if(empty($_SESSION["keysx"])){
        $_SESSION["keysx"]=bin2hex(random_bytes(32));
      }
      $csrfsx=hash_hmac("sha256","this is some string : search-result.php",$_SESSION["keysx"]);
  if(isset($_POST["sendEmail"])){
    if(hash_equals($csrfsx,$_POST["csrfsx"])){
        require_once "includes/PHPMailer.php";
        require_once "includes/SMTP.php";
        require_once "includes/Exception.php";
       $em=filter_var($_POST["email"],FILTER_SANITIZE_STRING);
       $em=htmlspecialchars($em);
       $nm=filter_var($_POST["name"],FILTER_SANITIZE_STRING);
       $nm=htmlspecialchars($nm);
       $bo=filter_var($_POST["body"],FILTER_SANITIZE_STRING);
       $bo=htmlspecialchars($bo);
       if(strlen($em)>40 || strlen($nm)>40 || strlen($bo)>999 ){
        echo "<div class='alert alert-primary'style='text-align:center;'>  الرسالة كبيرة   </div>";
       }else{
         $mail = new PHPMailer();
         $mail -> isSMTP();
         $mail -> Host = "smtp.gmail.com";
     $mail -> SMTPAuth = "true";
      
        $mail -> SMTPSecure = "tls";
        $mail -> Port="587";
        $mail -> Username = "Alcryptonzspam@gmail.com";
        $mail -> Password = "Eslam0128*";
        $mail -> Subject ="email From Alcryptonz Contact Form";
        $mail -> setFrom($em,$nm);
         $mail -> isHTML(true);
         $mail -> Body =$bo;
     $mail -> addAddress("Alcryptonzspam@gmail.com");
   
        if($mail ->send()){
            echo "<div class='alert alert-success'style='text-align:center;'> تم ارسال رسالتك بنجاح</div>";
        
        }else{
     echo "<div class='alert alert-danger' style='text-align:center;'> هناك مشكلة في ارسال الرسالة</div>";
        }
    $mail ->smtpClose();
      }
    }else{
        echo "<div style='font-weight:bold;color:red;font-size:28px;text-align:center'>";
        echo " <i class='fas fa-exclamation-triangle'></i> ";
        echo" ERROR";
        echo "</div>";
    }
}
     
?>
    <div class="container">
        <div class="hold">
            <div class="contact-infor">
            <h5>Contact Info</h5>
            <p>Contact us for more Details</p>
            <ul>
                <li><a href="https://twitter.com/Alcryptonz?s=09" target="_blank"><i class="fab fa-twitter-square"></i>&nbsp; @Alcryptonz</a></li>
                <li><a href="https://t.me/AlCryptonz" target="_blank"><i class="fab fa-telegram"></i>&nbsp; @AlCryptonz</a></li>
                <li><a href="https://www.facebook.com/Alcryptonz" target="_blank"><i class="fab fa-facebook-square"></i>&nbsp; Alcryptonz</a></li>
                <?php /*<li><a href="https://wa.me/+20xxxxx" target="_blank"><i class="fab fa-whatsapp-square"></i>&nbsp; WhatsApp: +201001815147</a></li>*/ ?>
                <li><a href="mailto:Marketing@alcryptonz.com" target="_blank"><i class="fas fa-envelope"></i>&nbsp;Marketing@alcryptonz.com</a></li>
            </ul>
            </div>
            <div class="form-part">
               <h5>Contact form</h5>
               <form action="<?php $_SERVER["PHP_SELF"];?>"method="POST">
                <input type="text"placeholder="Name*"name="name"required>
                <input type="text"placeholder="Email*"required name="email">
                <input type="hidden"  name="csrfsx"value="<?php echo $csrfsx; ?>">
                <textarea rows="5" cols="10" placeholder="Message*"required name="body"style="color:white !important;"></textarea>
  <button name="sendEmail">Send</button>
               </form>
            </div>
        </div>
    </div>

    </footer>
    <section class="under">
    <p>
    &copy; <?php echo date("Y");?> جميع الحقوق محفوظة لفريق الكريبتونز
</p>
    <p> تم التطوير بواسطة <a href="https://wa.me/+201122795610">أحمد سامح</a></p>
    </section>