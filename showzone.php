<?

require "mudnotes.php";

if (!((isset($_GET['mud']))
		&&(isset($_GET['zone']))
		&&(is_file(getZoneNotes($_GET['mud'],$_GET['zone'])))))
{
	redirect("mudlist.php");
}

function showLinks()
{
	echo "<div style=\"position: absolute; right: 10px\"><a href=\"editzone.php?mud=".$_GET['mud']."&amp;zone=".$_GET['zone']."\">Edit</a></div>";
	echo "<div style=\"position: absolute; left: 10px\"><a target=\"_top\" href=\"deletezone.php?mud=".$_GET['mud']."&amp;zone=".$_GET['zone']."\">Delete";
	if (isLinkZone($_GET['mud'],$_GET['zone']))
	{
		echo " Link";
	}
	echo "</a></div>";
}

function fixhtml($text)
{
	echo htmlentities($text);
}

function formatRoutes($text)
{
	if (preg_match("/^(.*?)<<(.*?)>>(.*)$/",$text,$matches))
	{
		fixhtml($matches[1]);
		$link=$matches[2];
		$pos=strpos($link,"/");
		$mud=$_GET['mud'];
		if ($pos!==false)
		{
			if ($pos>0)
			{
				$mud=substr($link,0,$pos);
			}
			$link=substr($link,$pos+1);
		}
		$pos=strpos($link,":");
		if ($pos!==false)
		{
			if ($pos==0)
			{
				$zone=$_GET['zone'];
			}
			else
			{
				$zone=substr($link,0,$pos);
			}
			$maze=substr($link,$pos+1);
			if (preg_match("/^(.*)\\((\d*),(\d*)\\)$/",$maze,$mazeparts))
			{
				$maze=$mazeparts[1];
				$start=$mazeparts[2];
				$end=$mazeparts[3];
			}
			if (is_file(getMaze($mud,$zone,$maze)))
			{
				$fulllink="showmaze.php?mud=".$mud."&amp;zone=".$zone."&amp;maze=".$maze.
									"&amp;start=".$start."&amp;end=".$end;
				$loaded = new Maze;
				$loaded->load(getMaze($mud,$zone,$maze));
				if (!isset($start))
				{
					$start=$loaded->start;
				}
				if (!isset($end))
				{
					$end=$loaded->end;
				}
				echo "<a href=\"".$fulllink."\">".$loaded->planRoute($start,$end)."</a>";
			}
			else
			{
				echo "<span class=\"invalidlink\">".$matches[2]."</span>";
			}
		}
		else
		{
			echo "<span class=\"invalidlink\">".$matches[2]."</span>";
		}
		formatRoutes($matches[3]);
	}
	else
	{
		fixhtml($text);
	}
}

function formatLinks($text)
{
	if (preg_match("/^(.*?)\\[\\[(.*?)\\]\\](.*)$/",$text,$matches))
	{
		formatRoutes($matches[1]);
		$link=$matches[2];
		$pos=strpos($link,"/");
		$mud=$_GET['mud'];
		if ($pos!==false)
		{
			if ($pos>0)
			{
				$mud=substr($link,0,$pos);
			}
			$link=substr($link,$pos+1);
		}
		$pos=strpos($link,":");
		if ($pos!==false)
		{
			if ($pos==0)
			{
				$zone=$_GET['zone'];
			}
			else
			{
				$zone=substr($link,0,$pos);
			}
			$maze=substr($link,$pos+1);
			if (is_file(getMaze($mud,$zone,$maze)))
			{
				$fulllink="showmaze.php?mud=".$mud."&amp;zone=".$zone."&amp;maze=".$maze;
				echo "<a href=\"".$fulllink."\">".$matches[2]."</a>";
			}
			else
			{
				echo "<span class=\"invalidlink\">".$matches[2]."</span>";
			}
		}
		else
		{
			$zone=$link;
			if (is_dir(getZoneDir($mud,$zone)))
			{
				$fulllink="showzone.php?mud=".$mud."&amp;zone=".$zone;
				echo "<a href=\"".$fulllink."\">".$matches[2]."</a>";
			}
			else
			{
				echo "<span class=\"invalidlink\">".$matches[2]."</span>";
			}
		}
		formatLinks($matches[3]);
	}
	else
	{
		formatRoutes($text);
	}
}

function formatLine($line)
{
	$line=trim($line);
	formatLinks($line);
	echo "<br/>\n";
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<title>MudNotes</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<? showLinks(); ?>
<h1><a target="_top" href="showmud.php?mud=<?= $_GET['mud'] ?>"><?= $_GET['mud'] ?></a>:
		<?= $_GET['zone'] ?></h1>
<p style="text-align: center; font-size: small; font-style: italic"><?= $_GET['mud'] ?>/<?= $_GET['zone'] ?></p>
<? if (isLinkZone($_GET['mud'],$_GET['zone']))
{
	list($realmud,$realzone)=getRealZone($_GET['mud'],$_GET['zone']);
?><p style="text-align: center; font-size: small; font-style: italic">Links to <?= $realmud ?>/<?= $realzone ?></p><?
} ?>
<div class="notes">
<?
$fh=fopen(getZoneNotes($_GET['mud'],$_GET['zone']),"r");
while($line=fgets($fh))
{
	formatLine($line);
}
?>
</div>
<hr/>
<? showLinks(); ?>
<div class="section">
<h2>Mazes</h2>
<?

$mazes = array();
$titles = array();
if ($dh = opendir(getZoneDir($_GET['mud'],$_GET['zone'])))
{
	while (($file = readdir($dh)) !== false)
	{
		if ((is_file(getZoneDir($_GET['mud'],$_GET['zone']).'/'.$file))&&($file!="notes"))
		{
			$maze = new Maze;
			$maze->load(getMaze($_GET['mud'],$_GET['zone'],$file));
			$mazes[]=$file;
			$titles[$file]="<a target=\"main\" href=\"showmaze.php?zone=".$_GET['zone']."&amp;mud=".$_GET['mud']."&amp;maze=$file\">$file:</a> ".$maze->planRoute($maze->start,$maze->end);
		}
  }
  closedir($dh);
}

natcasesort($mazes);
reset($mazes);
while (list($key, $maze) = each($mazes))
{
	echo "<p style=\"text-align: center\">$titles[$maze]</p>\n";
}
  
?>
</div>
<div class="section">
<h2>Add a new maze</h2>
<form action="addmaze.php" method="post">
<input type="hidden" name="mud" value="<?= $_GET['mud'] ?>"/>
<input type="hidden" name="zone" value="<?= $_GET['zone'] ?>"/>
<table style="margin-left: auto; margin-right: auto">
	<tr><td>Name:</td><td><input type="text" name="maze" value=""/></td></tr>
	<tr><td colspan="2" style="text-align: center"><input type="submit" value="Add"/></td></tr>
</table>
</form>
</div>
</body>
</html>
