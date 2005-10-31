<?

require "mudnotes.php";

if (!((isset($_GET['mud']))
		&&(isset($_GET['zone']))
		&&(isset($_GET['maze']))
		&&(is_file(getMaze($_GET['mud'],$_GET['zone'],$_GET['maze'])))))
{
	redirect("mudlist.php");
}
else
{
	$maze = new Maze;
	$maze->load(getMaze($_GET['mud'],$_GET['zone'],$_GET['maze']));
	$start=$maze->start;
	$end=$maze->end;
	if (isset($_GET['start']))
	{
		$start=$_GET['start'];
	}
	if (isset($_GET['end']))
	{
		$end=$_GET['end'];
	}
}

function showLinks()
{
	echo "<div style=\"position: absolute; right: 10px\"><a href=\"editmaze.php?mud=".$_GET['mud']."&amp;zone=".$_GET['zone']."&amp;maze=".$_GET['maze']."\">Edit</a></div>";
	echo "<div style=\"position: absolute; left: 10px\"><a href=\"deletemaze.php?mud=".$_GET['mud']."&amp;zone=".$_GET['zone']."&amp;maze=".$_GET['maze']."\">Delete</a></div>";
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<title>MudNotes</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<? showLinks(); ?>
<h1><a target="_top" href="showmud.php?mud=<?= $_GET['mud'] ?>"><?= $_GET['mud'] ?></a>:
		<a href="showzone.php?mud=<?= $_GET['mud'] ?>&amp;zone=<?= $_GET['zone'] ?>"><?= $_GET['zone'] ?></a>:
		<?= $_GET['maze'] ?></h1>
<p style="text-align: center; font-size: small; font-style: italic"><?= $_GET['mud'] ?>/<?= $_GET['zone'] ?>:<?= $_GET['maze'] ?></p>
<div class="notes">
<form action="showmaze.php" method="get">
<input type="hidden" name="mud" value="<?= $_GET['mud'] ?>"/>
<input type="hidden" name="zone" value="<?= $_GET['zone'] ?>"/>
<input type="hidden" name="maze" value="<?= $_GET['maze'] ?>"/>
<table style="margin-left: auto; margin-right: auto">
<thead>
	<tr>
		<td style="width: 50px"></td>
		<td style="width: 250px">Room</td>
		<td style="width: 150px">object</td>
		<td style="text-align: center; width: 50px">N</td>
		<td style="text-align: center; width: 50px">E</td>
		<td style="text-align: center; width: 50px">S</td>
		<td style="text-align: center; width: 50px">W</td>
		<td style="text-align: center; width: 50px">U</td>
		<td style="text-align: center; width: 50px">D</td>
		<td>Start</td>
		<td>End</td>
	</tr>
</thead>
<?
for ($id=1; $id<=$maze->size(); $id++)
{
	list($name,$object,$n,$e,$s,$w,$u,$d)=$maze->getRoom($id);
?>
	<tr>
		<td style="text-align: center"><?= $id ?></td>
		<td><?= $name ?></td>
		<td><?= $object ?></td>
		<td style="text-align: center"><?= $n ?></td>
		<td style="text-align: center"><?= $e ?></td>
		<td style="text-align: center"><?= $s ?></td>
		<td style="text-align: center"><?= $w ?></td>
		<td style="text-align: center"><?= $u ?></td>
		<td style="text-align: center"><?= $d ?></td>
		<td><input type="radio" name="start" value="<?= $id ?>"<?
		
		if ($start==$id)
		{
			echo " checked=\"checked\"";
		}
		
		?>/></td>
		<td><input type="radio" name="end" value="<?= $id ?>"<?
		
		if ($end==$id)
		{
			echo " checked=\"checked\"";
		}
		
		?>/></td>
	</tr>
<?
}
?>
	<tr><td colspan="11" style="text-align: center"><input type="submit" value="Find Route"/></td></tr>
</table>
</form>
<p style="text-align: center">Best route from <?= $start ?> to <?= $end ?> is: <?= $maze->planRoute($start,$end) ?></p>
</div>
<form method="post" action="renamemaze.php">
<input type="hidden" name="mud" value="<?= $_GET['mud'] ?>"/>
<input type="hidden" name="zone" value="<?= $_GET['zone'] ?>"/>
<input type="hidden" name="maze" value="<?= $_GET['maze'] ?>"/>
<table style="margin-left: auto; margin-right: auto">
	<tr>
		<td><input type="text" name="newname" value="<?= $_GET['maze'] ?>" /></td><td><input type="submit" value="Rename" /></td>
	</tr>
</table>
</form>
<? showLinks(); ?>
</body>
</html>
