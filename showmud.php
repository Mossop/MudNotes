<?

require "mudnotes.php";

if (!((isset($_GET['mud']))
		&&(is_dir(getMudDir($_GET['mud'])))))
{
	redirect("mudlist.php");
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">

<html>
<head>
<title>MudNotes - <?= $_GET['mud'] ?></title>
</head>
<frameset cols="250,*">
	<frame name="side" src="zones.php?mud=<?= $_GET['mud'] ?>"/>
<?

if (isset($_GET['zone']))
{
?>	<frame name="main" src="editzone?mud=<?=$_GET['mud'] ?>&amp;zone=<?= $_GET['zone'] ?>"/><?
}
else
{
?>	<frame name="main" src="zoneadmin.php?mud=<?=$_GET['mud'] ?>"/><? } ?>
	<noframes>
		<p>This application requires a browser from the current decade. Please upgrade.</p>
	</noframes>
</frameset>
</html>
