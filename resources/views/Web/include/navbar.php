<nav class="navbar nav-me bg-dark navbar-light navbar-expand-sm one-nav">
        <div class="container">
        <a href="index.php" class="navbar-brand " style="font-weight:bold;font-size:19px;color:white"><img src="images/new-big-logo.jpeg" alt="logo" style="width:49px;height:44px;">&nbsp; ALCRYPTONZ </a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#menu" style="border:0; background-color:black;padding:10px 0 0">
                <i class="fas fa-bars navbar-toggler-icon"style="color:white !important;font-size:27px !important;"></i>

            </button>
            <div class="collapse navbar-collapse" id="menu"style=" z-index: 566311111111111 !important;">
                <ul class="navbar-nav ml-auto"style=" z-index: 566311111111111;">
                <li class="nav-item"style=" z-index: 566311111111111111 !important;">
                        <a href="index.php" class="nav-link spec2">  HOME</a>
                    </li>
                    <li class="nav-item">
                        <a href="aboutus.php" class="nav-link spec2">  ABOUT US</a>
                    </li>
                    <li class="nav-item">
                        <a href="#se" class="nav-link spec2">  SERVICES</a>
                    </li>
                                   <!--partners-->
                                   <div class="dropdown">
                        <a class=" dropdown-toggle par-but" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        COLLABS 
</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php /*
                        $queaaaa="select * from partner";
                        $execezzaz=mysqli_query($con,$queaaaa);
                        while($row=mysqli_fetch_assoc($execezzaz)){ 
                        */?>
                            <a class="dropdown-item" href="categories-related.php?nameCategory=<?php /*echo $row["partnerName"];*/ ?>"> <?php /* echo $row["partnerName"];*/ ?></a>
                        
                            <?php /* }*/ ?>
                        </div>
                        </div>
                    <!--partners-->
        
                    <li class="nav-item">
                        <a href="#ar" class="nav-link spec2">  ARTICELS</a>
                    </li>
               
                    <li class="nav-item">
                        <a href="#te" class="nav-link spec2">  TEAM</a>
                    </li>
                    <li class="nav-item">
                        <a href="#ser" class="nav-link spec2">  SEARCH</a>
                    </li>
                    <li class="nav-item">
                        <a href="alcrypto-news.php?potype=<?php /* echo "اخبار الكريبتو"; */ ?>" class="nav-link spec2">  ALCRYPTO NEWS</a>
                    </li>
                    <li class="nav-item">
                        <a href="#fo" class="nav-link spec2">  CONTACT US</a>
                    </li>

              
                </ul>

            </div>
        </div>
    </nav>
    <!--<div class="search-bar">
    
    <div class="container">
    <form action="search-result.php"method="POST">
                <input type="search"name="search-post">
            <button type="submit" name="searched">  بحث</button>
        </form>
    </div>
    </div>-->