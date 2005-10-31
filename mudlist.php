<?

require "mudnotes.php";
$user=getUser();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<title>MudNotes</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<h1>MudNotes</h1>
<div class="section">
<h2>Muds</h2>
<?

$muds = array();
$titles = array();

if ($dh = opendir(getUserDir()))
{
	while (($file = readdir($dh)) !== false)
	{
		if ((is_dir(getUserDir().'/'.$file))&&(substr($file,0,1)!='.'))
		{
			$muds[]=$file;
			$titles[$file]="<a href=\"showmud.php?mud=$file\">$file</a>";
		}
  }
  closedir($dh);
}

natcasesort($muds);
reset($muds);
while (list($key, $mud) = each($muds))
{
  echo "<p style=\"text-align: center\">$titles[$mud]</p>\n";
}

?>
</div>
<div class="section">
<h2>Add a new mud</h2>
<form action="addmud.php" method="post">
<table style="margin-left: auto; margin-right: auto">
	<tr><td>Name:</td><td><input type="text" name="mud" value=""/></td></tr>
	<tr><td colspan="2" style="text-align: center"><input type="submit" value="Add"/></td></tr>
</table>
</form>
</div>
<div class="section">
	<p style="text-align: center"><a target="_top" href="logout.php">Logout</a></p>
</div>
</body>
</html>
