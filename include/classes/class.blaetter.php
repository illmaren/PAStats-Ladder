<?
function blaetterfunktion($seite,$maxseite,$url="",$anzahl=4,$get_name="")
   {

   if($anzahl%2 != 0) $anzahl++; //Wenn $anzahl ungeraden, dann $anzahl++

   $a = $seite-($anzahl/2);
   $b = 0;
   $blaetter = array();
   while($b <= $anzahl)
      {
      if($a > 0 AND $a <= $maxseite)
         {
         $blaetter[] = $a;
         $b++;
         }
      else if($a > $maxseite AND ($a-$anzahl-2)>=0)
         {
         $blaetter = array();
         $a -= ($anzahl+2);
         $b = 0;
         }
      else if($a > $maxseite AND ($a-$anzahl-2)<0)
         {
         break;
         }

      $a++;
      }
   $return = "";
   
   if(!in_array(1,$blaetter) AND count($blaetter) > 1)
      {
      if(!in_array(2,$blaetter)) $return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}1\">1</a>&nbsp;...";
      else $return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}1\">1</a>&nbsp;";
      }
$maxseite = round($maxseite, 0);
$maxseite = $maxseite;
   foreach($blaetter AS $blatt)
      {
      if($blatt == $seite) $return .= "&nbsp;<b>$blatt</b>&nbsp;";
      else $return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}$blatt\">$blatt</a>&nbsp;";
      }
   if(!in_array($maxseite,$blaetter) AND count($blaetter) > 1)
      {
      if(!in_array(($maxseite),$blaetter)) $return .= "...&nbsp;<a href=\"{$url}{$anhang}{$get_name}$maxseite\">last</a>&nbsp;";
      else $return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}$maxseite\">$maxseite</a>&nbsp;";
      }

   if(empty($return))
      return  "&nbsp;<b>1</b>&nbsp;";
   else
      return $return;
   }
?>