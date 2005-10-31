<?

session_set_cookie_params(0,"/mudnotes/");
session_start();
$datadir="/srv/www/htdocs/mudnotes/data";
$path='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/';

function isValidMudName($name)
{
	if (strstr($name,"/")===false)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isValidZoneName($name)
{
	return isValidMudName($name);
}

function isValidMazeName($name)
{
	return isValidZoneName($name);
}

function getUserDir()
{
	global $datadir;
	
	return $datadir.'/'.getUser();
}

function getMudDir($mud)
{
	return getUserDir().'/'.$mud;
}

function isLinkZone($mud,$zone)
{
	$dir=getMudDir($mud).'/'.$zone;
	if (is_file($dir))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function getRealZone($mud,$zone)
{
	$dir=getMudDir($mud).'/'.$zone;
	if (is_dir($dir))
	{
		return array($mud,$zone);
	}
	else if (is_file($dir))
	{
		$result = array();
		$fh=fopen($dir,"r");
		$result[0]=trim(fgets($fh));
		$result[1]=trim(fgets($fh));
		fclose($fh);
		return $result;
	}
	else
	{
		return false;
	}
}

function renameZone($mud,$zone,$newname)
{
	$dir=getMudDir($mud);
	if ((isValidZoneName($newname))
		&&(file_exists($dir.'/'.$zone))
		&&(!(file_exists($dir.'/'.$newname))))
	{
		if (rename($dir.'/'.$zone,$dir.'/'.$newname))
		{
			if ($dh=opendir(getUserDir()))
			{
				while (($cmud = readdir($dh)) !== false)
				{
					if ((is_dir(getUserDir().'/'.$cmud))&&(substr($cmud,0,1)!='.'))
					{
						if ($dh2 = opendir(getUserDir().'/'.$cmud))
						{
							while (($czone = readdir($dh2)) !== false)
							{
								if (is_file(getUserDir().'/'.$cmud.'/'.$czone))
								{
									$fh=fopen(getUserDir().'/'.$cmud.'/'.$czone,"r");
									$testmud=trim(fgets($fh));
									$testzone=trim(fgets($fh));
									fclose($fh);
									if (($testmud==$mud)&&($testzone==$zone))
									{
										$fh=fopen(getUserDir().'/'.$cmud.'/'.$czone,"w");
										fwrite($fh,$mud."\n");
										fwrite($fh,$newname."\n");
										fclose($fh);
									}
								}
							}
					  }
					  closedir($dh);
					}
			  }
			  closedir($dh);
			}
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function removeZone($mud,$zone)
{
	$dir=getMudDir($mud);
	if (is_dir($dir.'/'.$zone))
	{
		removeDir(getZoneDir($mud,$zone));
	}
	else if (is_file($dir.'/'.$zone))
	{
		unlink($dir.'/'.$zone);
	}
}

function getZoneDir($mud,$zone)
{
	$dir=getMudDir($mud).'/'.$zone;
	if (is_file($dir))
	{
		$fh=fopen($dir,"r");
		$mud=trim(fgets($fh));
		$zone=trim(fgets($fh));
		fclose($fh);
		return getZoneDir($mud,$zone);
	}
	else
	{
		return $dir;
	}
}

function getZoneNotes($mud,$zone)
{
	return getZoneDir($mud,$zone).'/notes';
}

function getMaze($mud,$zone,$maze)
{
	return getZoneDir($mud,$zone).'/'.$maze;
}

function renameMaze($mud,$zone,$maze,$newname)
{
	$dir = getZoneDir($mud,$zone);
	if ((is_file($dir.'/'.$maze))
		&&(!(is_file($dir.'/'.$newname)))
		&&(isValidMazeName($newname)))
	{
		return rename($dir.'/'.$maze,$dir.'/'.$newname);
	}
	else
	{
		return false;
	}
}

function removeDir($dir)
{
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			if (($file!=".")&&($file!=".."))
			{
				if (is_dir($dir.'/'.$file))
				{
					removeDir($dir.'/'.$filr);
				}
				else
				{
					unlink($dir.'/'.$file);
				}
			}
	  }
	  closedir($dh);
	}
	rmdir($dir);
}

function redirect($to)
{
	global $path;
	
	header("Location: ".$path.$to);
}

function getUser()
{
	global $datadir;
	
	if (isset($_SESSION['user']))
	{
		if (is_dir($datadir.'/'.$_SESSION['user']))
		{
			return $_SESSION['user'];
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
}

require_once("mazes.php");

?>
