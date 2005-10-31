<?

require "mudnotes.php";

if (isset($_POST['mud']))
{
	if (is_dir(getMudDir($_POST['mud'])))
	{
		redirect("showmud.php?mud=".$_POST['mud']);
	}
	else
	{
		mkdir(getMudDir($_POST['mud']));
		redirect("showmud.php?mud=".$_POST['mud']);
	}
}
else
{
	redirect("mudlist.php");
}

?>
