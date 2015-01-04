<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {
    
    echo' <h4>Geriausiai įvertinti receptai:</h4><br>
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="https://lh5.ggpht.com/ddv92tewQBxVzMJlWdaq8msObi6E00h0FOxuaMmnTQxmWek9HtDjBJx1ZfP6l6vYfCAO=w300" alt="patiekalas">
    </div>
    <div class="item">
      <img src="https://sveikagyvensena.files.wordpress.com/2009/11/makaronai3.jpg" alt="makaronai">
    </div>
  </div>

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