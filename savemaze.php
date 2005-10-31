<?

require "mudnotes.php";

function isRoomBlank($id)
{
	if ((isBlank("name",$id))
		&&(isBlank("object",$id))
		&&(isBlank("n",$id))
		&&(isBlank("e",$id))
		&&(isBlank("s",$id))
		&&(isBlank("w",$id))
		&&(isBlank("u",$id))
		&&(isBlank("d",$id)))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isBlank($type,$id)
{
	if ($_POST[$type.$id]=="")
	{
		return true;
	}
	return $_POST[$type.$id]==$_POST["def$type"];
}

function findRoom($room,$objlist)
{
	if ($room=="")
	{
		return "";
	}
	if (is_numeric($room))
	{
		return $room;
	}
	reset($objlist);
	while (list($key, $val) = each($objlist))
	{
		if ($val==$room)
		{
			return $key;
		}
	}
	return $room;
}

if (!((isset($_POST['mud']))
		&&(isset($_POST['zone']))
		&&(isset($_POST['maze']))
		&&(is_file(getMaze($_POST['mud'],$_POST['zone'],$_POST['maze'])))))
{
	redirect("mudlist.php");
}
else
{
	$maze = new Maze;
	$rooms=1;
	while (isset($_POST['name'.$rooms]))
	{
		$rooms++;
	}
	$rooms--;
	while (($rooms>0)&&(isRoomBlank($rooms)))
	{
		$rooms--;
	}
	
	if ($rooms>0)
	{
		$objlist = array();
		for ($id=1; $id<=$rooms; $id++)
		{
			$objlist[$id]=$_POST['object'.$id];
		}
		
		for ($id=1; $id<=$rooms; $id++)
		{
			$name=$_POST['name'.$id];
			$object=$_POST['object'.$id];
			$n=findRoom($_POST['n'.$id],$objlist);
			$e=findRoom($_POST['e'.$id],$objlist);
			$s=findRoom($_POST['s'.$id],$objlist);
			$w=findRoom($_POST['w'.$id],$objlist);
			$u=findRoom($_POST['u'.$id],$objlist);
			$d=findRoom($_POST['d'.$id],$objlist);
			$maze->addRoom($name,$object,$n,$e,$s,$w,$u,$d);
		}
	}
	
	if (isset($_POST['start']))
	{
		$maze->start=$_POST['start'];
	}
	if (isset($_POST['end']))
	{
		$maze->end=$_POST['end'];
	}
	
	$maze->save(getMaze($_POST['mud'],$_POST['zone'],$_POST['maze']));

	if (isset($_POST['done']))
	{
		redirect("showmaze.php?mud=".$_POST['mud']."&zone=".$_POST['zone']."&maze=".$_POST['maze']);
	}
	else
	{
		$query="mud=".$_POST['mud']."&zone=".$_POST['zone']."&maze=".$_POST['maze'];
		
		if (isset($_POST['defname']))
		{
			$query=$query."&defname=".$_POST['defname'];
		}
		if (isset($_POST['defobject']))
		{
			$query=$query."&defobject=".$_POST['defobject'];
		}
		if (isset($_POST['defn']))
		{
			$query=$query."&defn=".$_POST['defn'];
		}
		if (isset($_POST['defe']))
		{
			$query=$query."&defe=".$_POST['defe'];
		}
		if (isset($_POST['defs']))
		{
			$query=$query."&defs=".$_POST['defs'];
		}
		if (isset($_POST['defw']))
		{
			$query=$query."&defw=".$_POST['defw'];
		}
		if (isset($_POST['defu']))
		{
			$query=$query."&defu=".$_POST['defu'];
		}
		if (isset($_POST['defd']))
		{
			$query=$query."&defd=".$_POST['defd'];
		}
		
		$query=$query."&addrooms=10";
		
		redirect("editmaze.php?".$query);
	}
}

?>
