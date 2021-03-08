<?php

function selectVoiceAndTimeForm()
{
      $hours="";
      foreach(range(0, 23) as $value)
      {
        if($value < 10)
          $hours.= "<option> 0$value";
        else
          $hours.= "<option> $value";
      }

      $minutes="";
      foreach(range(0, 59) as $value)
      {
        if($value < 10)
          $minutes.= "<option> 0$value";
        else
          $minutes.= "<option> $value";
      }

      $result = '<div class="centred"><form id="main" name="main" method="post">
		    <div id="firstline">
                    <label for="voice_select">Voix:</label>
                    <input id="voice_select" type="input" onchange="audioPlayer()" name="voice" list="voice" required>
                    <datalist id=voice>
                        <option> Renaud
                    </datalist>
	            </div>
                    <label for="heure">Temps:</label>
                    <input id="heure" type="input" value="12" list="heures" name="hour" onchange="audioPlayer()" required>
                    <datalist id=heures>
                    '.$hours.'
                    </datalist>
		    <label for="minute">h</label>
                    <input id="minute" type="input" value="00" list="minutes" name="minute" onchange="audioPlayer()" required>
                    <datalist id=minutes>
                    '.$hours.'
                    </datalist>
                    </form></div>';

    return $result;
}

$page=selectVoiceAndTimeForm();

$page.='<section class="centred" id="content"></section>';

?>
