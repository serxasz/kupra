<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {
    
    echo'<h4>Naujausi receptai:</h4><br>
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">';
    $active = true;
    $sql = "SELECT * FROM recipes ORDER BY id ASC LIMIT 50";
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
        if ($active) {
            echo'<div class="item active">';
            $active = false;
        } else {
            echo'<div class="item">';
        }
        $file = glob("uploads/recipes/".$row['id']."/*.{jpg,jpeg,png,gif}",GLOB_BRACE);
        if (!empty($file)) {
        foreach ($file as $i) {
            if ($i == "uploads/recipes/".$row['id']."/1.jpg" or $i == "uploads/recipes/".$row['id']."/1.jpeg" or $i == "uploads/recipes/".$row['id']."/1.png" or $i == "uploads/recipes/".$row['id']."/1.gif") {
                        $image = '<img src="'.$i.'" style="height:400px; width:400px;" alt="photo">';
                    }
                }
        } else {
            $image = '<img src="images/no-photo.jpg" alt="photo" style="height:400px; width:400px;">';
        }
		echo'<a href="visi_receptai.php?view='.$row['id'].'">'.$image.'</a>';
        echo'<a href="visi_receptai.php?view='.$row['id'].'"><b>'.$row['name'].'</b></a>';
        echo'</div>';
	}
    
    echo'</div>
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>';
    
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>