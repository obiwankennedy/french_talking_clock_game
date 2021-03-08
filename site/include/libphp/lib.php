<?php
define('MJ',"maitre de jeu");
define('PJ',"joueur");
define('ADMIN',"admin");
define('HOME',"http://nwod.rolisteam.org");

function isInside($str,$array)
{
    foreach($array as $value)
    {
        if($value===$str)
        {
            return true;
        }
    }
return false;
}
function currentUserIsRegisted()
{
    if(!empty($_SESSION['user']['id']))
    {
        return True;
    }
    else
    {
        return False;
    }
}

function redirect($time,$dest)
{
    //<body onLoad="redirection_temp()">
        $result = '<script type="text/javascript">
delay = "'.$time.'" ;
url = "'.$dest.'" ;
function redirection_temp() { self.setTimeout("self.location.href = url;",delay) ; }
</script>';

return $result;

}

function displayAudioPlayerForFile($filepath)
{
  $result ='<figure>
      <figcaption>Lire le fichier audio:</figcaption>
      <audio
          controls
          src="'.$filepath.'">
              Your browser does not support the
              <code>audio</code> element.
      </audio>
  </figure>';
  return $result;
}


function getLang($lang)
{
  return true;
}

function tr($key)
{
  return $key;
}

?>
