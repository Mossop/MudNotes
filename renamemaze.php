<?

require "mudnotes.php";

if (!((isset($_POST['mud']))
		&&(isset($_POST['zone']))
		&&(isset($_POST['maze']))
		&&(isset($_POST['newname']))
		&&(is_file(getMaze($_POST['mud'],$_POST['zone'],$_POST['maze'])))))
{
	redirect("mudlist.php");
}
else
{
	if (renameMaze($_POST['mud'],$_POST['zone'],$_POST['maze'],$_POST['newname']))
	{
		redirect("showmaze.php?mud=".$_POST['mud']."&zone=".$_POST['zone']."&maze=".$_POST['newname']);
	}
	else
	{
		redirect("showmaze.php?mud=".$_POST['mud']."&zone=".$_POST['zone']."&maze=".$_POST['maze']);
	}
}

?>