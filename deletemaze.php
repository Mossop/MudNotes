<?

require "mudnotes.php";

if ((isset($_GET['mud']))
		&&(isset($_GET['zone']))
		&&(isset($_GET['maze'])))
{
	if (is_file(getMaze($_GET['mud'],$_GET['zone'],$_GET['maze'])))
	{
		unlink(getMaze($_GET['mud'],$_GET['zone'],$_GET['maze']));
	}
	redirect("showzone.php?mud=".$_GET['mud']."&zone=".$_GET['zone']);
}
else
{
	redirect("index.php");
}

?>
