<?php session_start(); ?>
<div class="header">

</div>
<!-- list of links to be formatted by style.css as navigation bar -->
<ul>
		<li class="account"><a href="http://localhost/Projects/beer/user/user_welcome.php">
		<?php echo $_SESSION['username'];?> </a></li>
		<li class="favbeers"><a href="http://localhost/Projects/beer/user/my_beers.php">My Beers</a></li>
		<li class="favbars"><a href="http://localhost/Projects/beer/user/my_bars.php">My Bars</a></li>
		<li class="allbeers"><a href="http://localhost/Projects/beer/user/user_beer.php">Beers</a></li>
		<li class="allbars"><a href="http://localhost/Projects/beer/user/user_bars.php">Bars</a></li>
		<li><a href="http://localhost/Projects/beer/contact.php">Search</a></li>
</ul><hr>