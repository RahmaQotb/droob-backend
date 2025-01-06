<nav class="navbar nav-me bg-dark navbar-light navbar-expand-sm two-nav">
        <div class="container">
        <a href="index.php" class="navbar-brand " style="font-weight:bold;font-size:19px;color:white"><img src="images/new-big-logo.jpeg" alt="logo" style="width:49px;height:44px;">&nbsp; ALCRYPTONZ </a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#menu" style="border:0; background-color:black;padding:10px 0 0">
                <i class="fas fa-bars navbar-toggler-icon"style="color:white !important;font-size:27px !important;"></i>

            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                        <a href="index.php" class="nav-link spec2">  HOME</a>
                    </li>
                   <!--partners-->
                   <div class="dropdown">
                        <a class=" dropdown-toggle par-but" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        COLLABS 
</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php 
                        $queaaaa="select * from partner";
                        $execezzaz=mysqli_query($con,$queaaaa);
                        while($row=mysqli_fetch_assoc($execezzaz)){ 
                        ?>
                            <a class="dropdown-item" href="categories-related.php?nameCategory=<?php echo $row["partnerName"]; ?>"> <?php echo $row["partnerName"]; ?></a>
                        
                            <?php } ?>
                        </div>
                        </div>
                    <!--partners-->
             
                    <li class="nav-item">
                        <a href="privcy.php" class="nav-link spec2">  PRIVACY POLICY</a>
                    </li>
                    <li class="nav-item">
                        <a href="QA.php" class="nav-link spec2">  FAQ</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>