<?

require "mudnotes.php";

if (!((isset($_GET['mud']))
		&&(isset($_GET['zone']))
		&&(is_file(getZoneNotes($_GET['mud'],$_GET['zone'])))))
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
<h1><?= $_GET['mud'] ?> - <?= $_GET['zone'] ?></h1>
<div class="section" style="width: 80%">
<form action="doeditzone.php" method="post">
<input type="hidden" name="mud" value="<?= $_GET['mud'] ?>"/>
<input type="hidden" name="zone" value="<?= $_GET['zone'] ?>"/>
<table style="margin-left: auto; margin-right: auto">
	<tr><td><textarea name="text" wrap="virtual" rows="25" cols="80"><?
	
$fh=fopen(getZoneNotes($_GET['mud'],$_GET['zone']),"r");
while ($line=fgets($fh))
{
	echo $line;
}
fclose($fh);

?></textarea></td></tr>
	<tr><td style="text-align: center"><input type="submit" value="Save Changes"/></td></tr>
</table>
</form>
</div>
<div class="section" style="width: 70%">
	<p>Enter notes in plain text.</p>
	<p>Links to other zones/mazes can be achieved with double square braces, e.g.:</p>
	<ul>
		<li>[[zone]] links to a different zone.</li>
		<li>[[mud/zone]] links to a zone on a different mud.</li>
		<li>[[zone:maze]] linkes to a maze in a different zone.</li>
		<li>[[:maze]]</li>
		<li>[[mud/zone:maze]]</li>
	</ul>
	<p>The link text can also be seen under the heading when viewing zones or mazes.</p>
	<p>Maze routes can be constructed with double chevrons, e.g.:</p>
	<ul>
		<li>&lt;&lt;:maze&gt;&gt; displays the default path through a maze.</li>
		<li>&lt;&lt;zone:maze&gt;&gt; displays the default path through a maze from another zone.</li>
		<li>&lt;&lt;:maze(1,5)&gt;&gt; displays the path from room 1 to 50 through a maze.</li>
	</ul>
	<p>The link text for the maze is identical as for a standard link.</p>
</div>
</body>
</html>
