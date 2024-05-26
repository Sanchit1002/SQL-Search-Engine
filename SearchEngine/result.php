<html>
<head><link rel="stylesheet" href="result.css"></head>
<body>
<form action="" method="GET">

    <div class="split part1">
        <!--this part is for symbol part-->
        <div class="symbol">
        <a href="http://localhost/projects/search.html"><img id="text" src="symbol.png" alt="Symbol" height=120px> </a>
            </div>   
                <!--this part is for search field part-->
                <div class="searchfield">
                    <div class="box">
                        <div class="split_search_field text_field">
                            <input  type="text" id="search" name="search_text" placeholder="Search here" >
                        </div>
                        <div class="split_search_field icon_field"><button  id="search_bt" name="search_bt"><img id="search_ico" src="search_icon.png" height=100%></button></div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <div class="split part2">
        <table border="3">
        <tr>
        <?php
            include("connection.php");
            if(isset($_GET['search_bt'])){
                $search = $_GET['search_text'];
                if($search==""){
                    echo "<br>nothing to search";
                    exit();
                }
                $query ="SELECT * FROM add_website WHERE website_keywords LIKE '%$search%' OR website_title LIKE '%$search%'" ;
                $data = mysqli_query($conn,$query);
                if(mysqli_num_rows($data)<1){
                    echo "<br>no result found";
                    exit();
                }
            }

        ?>
        </tr>
        </table>
    </div>
</form>
<div class="split part2" style= "height:80%; overflow-y: scroll;">
<div class="result">   
<table  width="" class="table" style="margin:50px; margin-top:30px;">
   
    <?php
        $query1 ="SELECT * FROM WHERE website_keywords LIKE '%$search%'";
        $data1 = mysqli_query($conn,$query);
        $ro = mysqli_fetch_array($data);
        if(mysqli_fetch_array($data)){
        while($row1 = mysqli_fetch_array($data)){
            echo "
                <tr><td><font size='5' color='#1558d6'><b><a href=$row1[1] style='color:#1558d6;'>$row1[0]</a></b></font>";
                echo "<br><font size='4' color='#006400'><a href=$row1[1] style='color:#006400;'>$row1[1]</a></font>";
                echo "<br><font size='4'><a href=$row1[1] style='color:black;'>$row1[3]</a></font><br><br>";
            "</td></tr>";
        }}
        else{
            echo "failed";
        }
   ?>
  
</table> </div>
</body>
</html>
