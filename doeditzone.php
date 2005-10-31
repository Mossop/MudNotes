<?

require "mudnotes.php";

if (!((isset($_POST['mud']))
		&&(isset($_POST['zone']))
		&&(isset($_POST['text']))
		&&(is_file(getZoneNotes($_POST['mud'],$_POST['zone'])))))
{
	redirect("mudlist.php");
}

$fh=fopen(getZoneNotes($_POST['mud'],$_POST['zone']),"w");
fwrite($fh,$_POST['text']);
fclose($fh);
redirect("showzone.php?mud=".$_POST['mud']."&zone=".$_POST['zone']);

?>
