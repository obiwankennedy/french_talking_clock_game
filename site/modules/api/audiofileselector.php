<?php
function hourToTextFr($num)
{
  $unity=array("un","une","deux","trois","quatre","cinq","six","sept","huit","neuf");
  $tens=array("dix","onze","douze","treize","quatorze","quinze","seize","vingt","trente","quarante","cinquante");
  $words=array("midi","minuit","et","quart","moins", "heure", "le");

  $sentences = array_merge($unity, $tens, $words);
  $hour="";
  if ($num == 0)
      $hour=array($sentences[22]);
  else if ($num == 12)
      $hour=array($sentences[21]);
  else if ($num < 17)
      $hour=array($sentences[intval($num)],$sentences[26]);
  else if ($num< 20)
      $hour=array($sentences[10],$sentences[$num-10],$sentences[26]);
  else if ($num== 20)
      $hour=array($sentences[17],$sentences[26]);
  else if ($num== 21)
      $hour=array($sentences[17],$sentences[23],$sentences[1],$sentences[26]);
  else
      $hour=array($sentences[17],$sentences[i-20],$sentences[26]);

   return $hour;
}


function minuteToTextFr($num)
{
  $unity=array("un","une","deux","trois","quatre","cinq","six","sept","huit","neuf");
  $tens=array("dix","onze","douze","treize","quatorze","quinze","seize","vingt","trente","quarante","cinquante");
  $words=array("midi","minuit","et","quart","moins", "heure", "le");

  $sentences = array_merge($unity, $tens, $words);
  $minute="";
      if($num == 0)
        $minute="";
      else if($num< 17)
          $minute=array($sentences[intval($num)]);
      else if($num< 20)
          $minute=array($sentences[10],$sentences[$num-10]);
      else if($num< 30)
          if($num== 21)
              $minute=array($sentences[17],$sentences[23],$sentences[1]);
          else if($num== 20)
              $minute=array($sentences[17]);
          else
              $minute=array($sentences[17],$sentences[$num-20]);
      else if($num< 40)
          if($num== 31)
              $minute=array($sentences[18],$sentences[23],$sentences[1]);
          else if($num== 30)
              $minute=array($sentences[18]);
          else
              $minute=array($sentences[18],$sentences[$num-30]);
      else if($num< 50)
          if($num== 41)
              $minute=array($sentences[19],$sentences[23],$sentences[1]);
          else if($num== 40)
              $minute=array($sentences[19]);
          else
              $minute=array($sentences[19],$sentences[$num-40]);
      else if($num< 60)
          if($num== 51)
              $minute=array($sentences[20],$sentences[23],$sentences[1]);
          else if($num== 50)
              $minute=array($sentences[20]);
          else
              $minute=array($sentences[20],$sentences[$num-50]);

      $simple="";
      if($num == 55) // -5
        $simple=array($sentences[25],$sentences[5]);
      else if($num == 50) // -10
          $simple=array($sentences[25],$sentences[10]);
      else if($num == 45) // -15
          $simple=array($sentences[25],$sentences[27],$sentences[24]);
      else if($num == 40) // -20
          $simple=array($sentences[25],$sentences[17]);
      else if($num == 35) // -25
          $simple=array($sentences[25],$sentences[17],$sentences[5]);

   return array("min"=>$minute, "simple"=>$simple);
}



if (empty($_POST["voice"]) || empty($_POST["hour"]) || empty($_POST["minute"]))
{
  echo json_encode("Impossible de trouver l'heure indiquée.");
  exit(1);
}

//if($prod)
//{
  $voice=$_POST["voice"];
  $hour=$_POST["hour"];
  $minute=$_POST["minute"];
//else {
//  $voice="Renaud";
//  $hour="13";
//  $minute="02";
//}

$dest_dir='data/voice/'.$voice;
// /home/renaud/www/scripts/19_francais/site/data/voice/Renaud
if(!is_dir($dest_dir))
{
  echo json_encode("$dest_dir est impossible à trouver");
  exit(1);
}



$hourText =hourToTextFr($hour);
$minuteArray =minuteToTextFr($minute);

$page="";

// Min array
$minText=$minuteArray["min"];
$value="";
if(!empty($minText))
  $value=implode('_',$minText);
$test=implode('_',$hourText);


$file_to_read=sprintf("%s/%s_%s.ogg",$dest_dir, $test, $value );
if(empty($minText))
    $file_to_read=sprintf("%s/%s.ogg",$dest_dir, $test);
$page.=displayAudioPlayerForFile($file_to_read);

// Simple array
$simpleText=$minuteArray["simple"];

if(!empty($simpleText))
{
  $newHour = $hour+1 < 24 ? $hour+1 : 0;
  $hourText =hourToTextFr($newHour);
  $value=implode('_',$simpleText);
  $test=implode('_',$hourText);
  $file_to_read=sprintf("%s/%s_%s.ogg",$dest_dir, $test, $value );
  $page.=displayAudioPlayerForFile($file_to_read);
}
#echo array_merge($minuteText,$hourText);


echo json_encode($page);


?>
