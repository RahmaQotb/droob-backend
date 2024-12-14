<div class="categories">
                        <h4> كلمات دلالية </h4>
                        <ul style="direction:rtl">
                            <?php 

                            $query="select * from category order by categoryId desc ";
                            $execc=mysqli_query($con,$query); 
                            if(mysqli_num_rows($execc)==0){
                                echo "<b><center>لا يوجد تصنيفات</center></b>";
                                    }
                            $n=0;
                           while($row=mysqli_fetch_assoc($execc)){ 
                               $n++;
                               ?>
                         <a  style="direction:rtl" href="categories-related.php?nameCategory=<?php echo $row["categoryName"]; ?>">
                             <li style="direction:rtl">
                             <span><?php echo $row["categoryName"]; ?></span>
                                    <span><i class="fas fa-chevron-right"></i> </span>
                                 
                                
                            </li>
                           </a>
                         <?php 
                     
                        }
                            ?>
             
                        </ul>

                    </div>