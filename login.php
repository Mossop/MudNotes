<?

require "mudnotes.php";

if (isset($_SESSION['user']))
{
	header("Location: ".$path."mudlist.php");
	return;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    
<html>
<head>
<title>MudNotes</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<h1>MudNotes</h1>
<div class="section">
<h2>Log in as an existing user</h2>
<form action="dologin.php" method="post">
<input type="hidden" name="user" value="<?= $_GET['user'] ?>"/>
<table style="margin-left: auto; margin-right: auto">
	<tr><td colspan="2" style="text-align: center">Username: <?= $_GET['user'] ?></td></tr>
	<tr><td>Password:</td><td><input type="password" name="passwd" value=""/></td></tr>
	<tr><td colspan="2" style="text-align: center"><input type="submit" value="Login"/></td></tr>
</table>
</form>
</div>
</body>
</html>
