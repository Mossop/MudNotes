<?

require "mudnotes.php";

if ((isset($_POST['user']))
		&&(isset($_POST['passwd']))
		&&(is_file($datadir.'/'.$_POST['user'].'/passwd')))
{
	$fh=fopen($datadir.'/'.$_POST['user'].'/passwd',"r");
	$md=fgets($fh);
	fclose($fh);
	if ($md==md5($_POST['passwd']))
	{
		$_SESSION['user']=$_POST['user'];
		redirect("mudlist.php");
	}
	else
	{
		redirect("index.php");
	}
}
else
{
	redirect("index.php");
}

?>
