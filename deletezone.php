<?

require "mudnotes.php";

if ((isset($_GET['mud']))
		&&(isset($_GET['zone'])))
{
	removeZone($_GET['mud'],$_GET['zone']);
	redirect("showmud.php?mud=".$_GET['mud']);
}
else
{
	redirect("index.php");
}

?>
