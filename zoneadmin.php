<?

require "mudnotes.php";

if (!((isset($_GET['mud']))
		&&(is_dir(getMudDir($_GET['mud'])))))
{
	redirect("mudlist.php");
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<title>MudNotes</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<h1 style="width: 90%"><?= $_GET['mud'] ?></h1>
<div class="section">
<h2>Add a new zone</h2>
<p style="text-align: center">A zone holds notes and mazes for an area on the mud.</p>
<form action="addzone.php" target="_top" method="post">
<input type="hidden" name="mud" value="<?= $_GET['mud'] ?>"/>
<table style="margin-left: auto; margin-right: auto">
	<tr><td>Name:</td><td><input type="text" name="zone" value=""/></td></tr>
	<tr><td colspan="2" style="text-align: center"><input type="submit" value="Add"/></td></tr>
</table>
</form>
</div>
<div class="section">
<h2>Add a new link</h2>
<p style="text-align: center">A link displays a zone from a different mud.</p>
<form action="addlink.php" target="_top" method="post">
<input type="hidden" name="mud" value="<?= $_GET['mud'] ?>"/>
<table style="margin-left: auto; margin-right: auto">
	<tr><td>Name:</td><td><input type="text" name="zone" value=""/></td></tr>
	<tr><td>Target Zone:</td><td><input type="text" name="targetzone" value=""/></td></tr>
	<tr><td>Target Mud:</td><td>
		<select name="targetmud">
<?

if ($dh = opendir(getUserDir()))
{
	while (($file = readdir($dh)) !== false)
	{
		if ((is_dir(getUserDir().'/'.$file))&&(substr($file,0,1)!='.'))
		{
			if ($file!=$_GET['mud'])
			{
				echo "<option value=\"".$file."\">".$file."</option>\n";
			}
		}
  }
  closedir($dh);
}

?>
		</select>
	</td></tr>
	<tr><td colspan="2" style="text-align: center"><input type="submit" value="Add"/></td></tr>
</table>
</form>
</div>
</body>
</html>
