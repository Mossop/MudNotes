<?

require "mudnotes.php";

if ((isset($_POST['mud']))
		&&(isset($_POST['zone']))
		&&(isset($_POST['maze']))
		&&(is_dir(getZoneDir($_POST['mud'],$_POST['zone']))))
{
	if (!is_file(getMaze($_POST['mud'],$_POST['zone'],$_POST['maze'])))
	{
		$maze = new Maze;
		$maze->save(getMaze($_POST['mud'],$_POST['zone'],$_POST['maze']));
	}
	redirect("editmaze.php?mud=".$_POST['mud']."&zone=".$_POST['zone']."&maze=".$_POST['maze']);
}
else
{
	redirect("index.php");
}

?>
