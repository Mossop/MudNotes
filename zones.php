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
<h1 style="width: 90%"><a target="_top" href="showmud.php?mud=<?= $_GET['mud'] ?>"><?= $_GET['mud'] ?></a></h1>
<div class="list" style="width: 80%">
<h2>Zones</h2>
<?

$zones = array();
$titles = array();

if ($dh = opendir(getMudDir($_GET['mud'])))
{
	while (($file = readdir($dh)) !== false)
	{
		if ((is_dir(getMudDir($_GET['mud']).'/'.$file))&&($file!=".")&&($file!=".."))
		{
			$zones[]=$file;
			$titles[$file]="<a target=\"main\" href=\"showzone.php?zone=$file&amp;mud=".$_GET['mud']."\">$file</a>";
		}
		else if ((is_file(getMudDir($_GET['mud']).'/'.$file))&&($file!='passwd'))
		{
			$zones[]=$file;
			$titles[$file]="<a target=\"main\" href=\"showzone.php?zone=$file&amp;mud=".$_GET['mud']."\">$file</a> [link]";
		}
  }
  closedir($dh);
}

natcasesort($zones);
reset($zones);
while (list($key, $file) = each($zones))
{
	echo "<p style=\"text-align: center\">$titles[$file]</p>\n";
}

?>
</div>
<div class="section">
	<p style="text-align: center"><a target="_top" href="mudlist.php">Muds</a></p>
	<p style="text-align: center"><a target="_top" href="logout.php">Logout</a></p>
</div>
</body>
</html>
