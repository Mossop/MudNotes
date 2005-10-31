<?

require "mudnotes.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    
<html>
<head>
<title>MudNotes</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<h1>MudNotes</h1>
<div class="section">
<h2>Log in as an existing user</h2>
<?

$names = array();
$titles = array();

if ($dh = opendir($datadir))
{
	while (($file = readdir($dh)) !== false)
	{
		if ((is_dir($datadir.'/'.$file))&&(substr($file,0,1)!='.'))
		{
			$names[]=$file;
			$titles[$file]="<a href=\"login.php?user=$file\">$file</a>";
		}
  }
  closedir($dh);
}

natcasesort($names);
reset($names);
while (list($key, $name) = each($names))
{
  echo "<p style=\"text-align: center\">$titles[$name]</p>\n";
}

?>
</div>
<div class="section">
<h2>Create a new user</h2>
<form action="createuser.php" method="post">
	<table style="margin-left: auto; margin-right: auto">
		<tr><td>User:</td><td><input type="text" value="" name="user"/></td></tr>
		<tr><td>Password:</td><td><input type="password" value="" name="passwd"/></td></tr>
		<tr><td>Re-enter password:</td><td><input type="password" value="" name="passwd2"/></td></tr>
		<tr><td colspan="2" style="text-align: center"><input type="submit" value="Create User"/></td></tr>
	</table>
</form>
</div>
</body>
</html>
