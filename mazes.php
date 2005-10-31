<?

require_once("mudnotes.php");

$dirnames=array('N','E','S','W','U','D');

function encodeMazeRoom($name,$object,$n,$e,$s,$w,$u,$d)
{
	$newname=$name;
	$newname=preg_replace("/\"/","\\\"",$newname);
	$newname="\"".$newname."\"";
	$newobj=$object;
	$newobj=preg_replace("/\"/","\\\"",$newobj);
	$newobj="\"".$newobj."\"";
	return $newname.','.$newobj.',"'.$n.'","'.$e.'","'.$s.'","'.$w.'","'.$u.'","'.$d."\"\n";
}

function extractUnquoted($text)
{
	if ($pos=strpos($text,","))
	{
		$part=substr($text,0,$pos);
		$rest=substr($text,$pos+1);
		return array($part,$rest);
	}
	else
	{
		return array($text,"");
	}
}

function extractQuoted($text)
{
	$text=substr($text,1);
	$bit="";
	if (preg_match("/((?:^)|(?:.*?[^\\\\]))\"(?:(?:,(.*))|(?:$))/",$text,$matches))
	{
		$bit=$matches[1];
		$rest=$matches[2];
		$bit=preg_replace("/\\\\\"/","\"",$bit);
		return array($bit,$rest);
	}
	return array("",$text);
}

function decodeMazeRoom($text)
{
	$text=substr($text,0,-1);
	list($name,$text)=extractQuoted($text);
	list($object,$text)=extractQuoted($text);
	list($n,$text)=extractQuoted($text);
	list($e,$text)=extractQuoted($text);
	list($s,$text)=extractQuoted($text);
	list($w,$text)=extractQuoted($text);
	list($u,$text)=extractQuoted($text);
	list($d,$text)=extractQuoted($text);
	return array($name,$object,$n,$e,$s,$w,$u,$d);
}

class Maze
{
	var $start = -1;
	var $end = -1;
	var $rooms = array();

	function planRoute($start,$end)
	{
		global $dirnames;
		
		for ($loop=1; $loop<=count($this->rooms); $loop++)
		{
			$shortest[$loop]=-1;
			$found[$loop]=false;
			$previous[$loop]=-1;
			$dirto[$loop]=-1;
		}
		$shortest[$start]=0;
		$found[$start]=true;
		$current=$start;
		while (!$found[$end])
		{
			$nextdist=$shortest[$current]+1;
			$room=$this->rooms[$current];
			for ($dir=2; $dir<=7; $dir++)
			{
				$target=$room[$dir];
				if ((is_numeric($target))&&($target>0)&&($target<=count($this->rooms)))
				{
					$distto=$shortest[$target];
					if (($distto<0)||($distto>$nextdist))
					{
						$shortest[$target]=$nextdist;
						$dirto[$target]=$dir-2;
						$previous[$target]=$current;
					}
				}
			}
			$best=-1;
			for ($loop=1; $loop<=count($this->rooms); $loop++)
			{
				if ((!$found[$loop])&&($shortest[$loop]>0))
				{
					if ($best<0)
					{
						$best=$loop;
					}
					else
					{
						if ($shortest[$loop]<$shortest[$best])
						{
							$best=$loop;
						}
					}
				}
			}
			if ($best==-1)
			{
				return "No valid route";
			}
			$current=$best;
			$found[$current]=true;
		}
		$pos=$end;
		$route="";
		while ($pos!=$start)
		{
			$route=$dirnames[$dirto[$pos]].' '.$route;
			$pos=$previous[$pos];
		}
		return rtrim($route);
	}
		
	function getRoom($id)
	{
		if (($id>0)&&($id<=count($this->rooms)))
		{
			return $this->rooms[$id];
		}
		else
		{
			return false;
		}
	}
	
	function addRoom($name,$object,$n,$e,$s,$w,$u,$d)
	{
		$newid=count($this->rooms)+1;
		$roomdata = array($name,$object,$n,$e,$s,$w,$u,$d);
		$this->rooms[$newid]=$roomdata;
		return $newid;
	}
	
	function size()
	{
		return count($this->rooms);
	}
	
	function load($filename)
	{
		if ($fh=fopen($filename,"r"))
		{
			$this->rooms=array();
			$first=fgets($fh);
			if (preg_match("/^(\d*),(\d*)\n$/",$first,$matches))
			{
				$this->start=$matches[1];
				$this->end=$matches[2];
			}
			$id=1;
			while ($line=fgets($fh))
			{
				$this->rooms[$id]=decodeMazeRoom($line);
				$id++;
			}
			fclose($fh);
		}
	}
	
	function save($filename)
	{
		if ($fh=fopen($filename,"w"))
		{
			fwrite($fh,$this->start.','.$this->end."\n");
			for ($id=1; $id<=count($this->rooms); $id++)
			{
				$room=$this->rooms[$id];
				fwrite($fh,encodeMazeRoom($room[0],$room[1],$room[2],$room[3],$room[4],$room[5],$room[6],$room[7]));
			}
			fclose($fh);
		}
	}
}

?>
