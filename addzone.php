<?

require "mudnotes.php";

if ((isset($_POST['mud']))
		&&(isset($_POST['zone'])))
{
	if (!is_dir(getZoneDir($_POST['mud'],$_POST['zone'])))
	{
		mkdir(getZoneDir($_POST['mud'],$_POST['zone']),0700);
		$fh=fopen(getZoneNotes($_POST['mud'],$_POST['zone']),"w");
		fclose($fh);
	}
	redirect("showmud.php?mud=".$_POST['mud']."&zone=".$_POST['zone']);
}
else
{
	redirect("index.php");
}

?>
