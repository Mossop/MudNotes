<?

require "mudnotes.php";

if ((isset($_POST['mud']))
		&&(isset($_POST['zone']))
		&&(isset($_POST['targetmud']))
		&&(isset($_POST['targetzone'])))
{
	if ((!is_dir(getZoneDir($_POST['mud'],$_POST['zone'])))&&(is_dir(getZoneDir($_POST['targetmud'],$_POST['targetzone']))))
	{
		$fh=fopen(getMudDir($_POST['mud']).'/'.$_POST['zone'],"w");
		fwrite($fh,$_POST['targetmud']."\n");
		fwrite($fh,$_POST['targetzone']."\n");
		fclose($fh);
	}
	redirect("showmud.php?mud=".$_POST['mud']);
}
else
{
	redirect("index.php");
}

?>
