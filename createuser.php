<?

require("mudnotes.php");

if (($_SERVER['REQUEST_METHOD']=='POST')
		&&(isset($_POST['user']))
		&&(isset($_POST['passwd']))
		&&(isset($_POST['passwd2']))
		&&($_POST['passwd']==$_POST['passwd2'])
		&&(!is_dir($datadir.'/'.$_POST['user'])))
{
	mkdir($datadir.'/'.$_POST['user'], 0700);
	$fh=fopen($datadir.'/'.$_POST['user'].'/passwd','w');
	fwrite($fh,md5($_POST['passwd']));
	fclose($fh);
	setcookie("user",$_POST['user']);
	redirect("mudlist.php");
}
else
{
	redirect("index.php");
}

?>
