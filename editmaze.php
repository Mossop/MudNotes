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
	$defname="";
	$defobject="";
	$defn="";
	$defe="";
	$defs="";
	$defw="";
	$defu="-";
	$defd="-";
	if (isset($_GET['defname']))
	{
		$defname=$_GET['defname'];
	}
	if (isset($_GET['defobject']))
	{
		$defobject=$_GET['defobject'];
	}
	if (isset($_GET['defn']))
	{
		$defn=$_GET['defn'];
	}
	if (isset($_GET['defe']))
	{
		$defe=$_GET['defe'];
	}
	if (isset($_GET['defs']))
	{
		$defs=$_GET['defs'];
	}
	if (isset($_GET['defw']))
	{
		$defw=$_GET['defw'];
	}
	if (isset($_GET['defu']))
	{
		$defu=$_GET['defu'];
	}
	if (isset($_GET['defd']))
	{
		$defd=$_GET['defd'];
	}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<title>MudNotes</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<h1><a target="_top" href="showmud.php?mud=<?= $_GET['mud'] ?>"><?= $_GET['mud'] ?></a>:
		<a href="showzone.php?mud=<?= $_GET['mud'] ?>&amp;zone=<?= $_GET['zone'] ?>"><?= $_GET['zone'] ?></a>:
		<?= $_GET['maze'] ?></h1>
<div class="notes">
<form action="savemaze.php" method="post">
<input type="hidden" name="mud" value="<?= $_GET['mud'] ?>"/>
<input type="hidden" name="zone" value="<?= $_GET['zone'] ?>"/>
<input type="hidden" name="maze" value="<?= $_GET['maze'] ?>"/>
<table style="margin-left: auto; margin-right: auto">
<?
if (($maze->size()>0)||(isset($_GET['addrooms'])))
{
?>
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
}
else
{
?>
<tr><td colspan="11">This maze has no rooms. Choose some defaults then click "Save and
Add New Rooms"</td></tr>
<?
}
for ($id=1; $id<=$maze->size(); $id++)
{
	list($name,$object,$n,$e,$s,$w,$u,$d)=$maze->getRoom($id);
?>
	<tr>
		<td style="text-align: center"><?= $id ?></td>
		<td><input type="text" name="name<?= $id ?>" value="<?= $name ?>"/></td>
		<td><input type="text" name="object<?= $id ?>" value="<?= $object ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="n<?= $id ?>" value="<?= $n ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="e<?= $id ?>" value="<?= $e ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="s<?= $id ?>" value="<?= $s ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="w<?= $id ?>" value="<?= $w ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="u<?= $id ?>" value="<?= $u ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="d<?= $id ?>" value="<?= $d ?>"/></td>
		<td><input type="radio" name="start" value="<?= $id ?>"<?
		
		if ($maze->start==$id)
		{
			echo " checked=\"checked\"";
		}
		
		?>/></td>
		<td><input type="radio" name="end" value="<?= $id ?>"<?
		
		if ($maze->end==$id)
		{
			echo " checked=\"checked\"";
		}
		
		?>/></td>
	</tr>
<?
}
if (isset($_GET['addrooms']))
{
	for ($pos=0; $pos<$_GET['addrooms']; $pos++)
	{
?>
	<tr>
		<td style="text-align: center"><?= $id ?></td>
		<td><input type="text" name="name<?= $id ?>" value="<?= $defname ?>"/></td>
		<td><input type="text" name="object<?= $id ?>" value="<?= $defobject ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="n<?= $id ?>" value="<?= $defn ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="e<?= $id ?>" value="<?= $defe ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="s<?= $id ?>" value="<?= $defs ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="w<?= $id ?>" value="<?= $defw ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="u<?= $id ?>" value="<?= $defu ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="d<?= $id ?>" value="<?= $defd ?>"/></td>
		<td><input type="radio" name="start" value="<?= $id ?>"/></td>
		<td><input type="radio" name="end" value="<?= $id ?>"/></td>
	</tr>
<?
		$id++;
	}
}
?>
	<tr>
		<td colspan="4" style="text-align: center"><input type="submit" name="done" value="Save and Complete"/></td>
		<td colspan="7" style="text-align: center"><input type="submit" name="continue" value="Save and Add New Rooms"/></td>
	</tr>
	<tr>
		<td style="text-align: center"><em>New</em></td>
		<td><input type="text" name="defname" value="<?= $defname ?>"/></td>
		<td><input type="text" name="defobject" value="<?= $defobject ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="defn" value="<?= $defn ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="defe" value="<?= $defe ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="defs" value="<?= $defs ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="defw" value="<?= $defw ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="defu" value="<?= $defu ?>"/></td>
		<td style="text-align: center"><input size="3" type="text" name="defd" value="<?= $defd ?>"/></td>
		<td></td>
		<td></td>
	</tr>
</table>
</form>
</div>
<div class="section" style="width: 60%">
	<p>Rooms can be linked by either putting the room's numerical id into the direction field, or the name
	  of the object in the target room. On save, any object references will be replaced by numerical ids.</p>
	<p>When the maze is saved, any blank rooms at the end of the list will be removed.</p>
	<p>A blank room is one where each of the entries is either blank or identical to that in the defaults.</p>
	<p>Choosing to save and continue will save the maze and then return here with 10 extra blank rooms to work with</p>
</div>
</body>
</html>
