<?php if(isset($_GET['json'])){
  header('content-type:text/javascript');
  echo 'goohoobi.se({"result":"';
}?>
<?php if(isset($_GET['search'])){
$query = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
$url = 'select * from query.multi where queries=\'select '.
            'Title,Description,Url,DisplayUrl from microsoft.bing.web(20) '.
            'where query="'.$query.'";select title,clickurl,abstract,'.
            'dispurl from search.web(20) where query = "'.$query.'";'.
            'select titleNoFormatting,url,content,visibleUrl '.
            'from google.search(20) where q = "'.$query.'"\'';
$api ='http://query.yahooapis.com/v1/public/yql?q='.
           urlencode($url).'&format=json&env=store'.
           '%3A%2F%2Fdatatables.org%2Falltableswithkeys&diagnostics=false';
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $api); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch); 
curl_close($ch);
$data = json_decode($output);
if($data->query){
  if($data->query->results->results[0]){
    $res = $data->query->results->results[0]->WebResult;
    $bing = '<h2>Bing</h2><ul>';
    $all = sizeof($res);
    for($i=0;$i<$all;$i++){      
      $bing .= '<li><h3><a href="'.$res[$i]->Url.'">'.$res[$i]->Title.
               '</a></h3><p>'.$res[$i]->Description.'<span>('.
               $res[$i]->DisplayUrl.')</span></p></li>';
    }
    $bing .= '</ul>';
  } else {
    $bing = '<h2>Bing</h2><h3>No results found.</h3>';
  }
  if($data->query->results->results[1]){
    $res = $data->query->results->results[1]->result;
    $yahoo = '<h2>Yahoo</h2><ul>';
    $all = sizeof($res);
    for($i=0;$i<$all;$i++){      
      $yahoo .= '<li><h3><a href="'.$res[$i]->clickurl.'">'.$res[$i]->title.
                '</a></h3><p>'.$res[$i]->abstract.'<span>('.
                $res[$i]->dispurl.')</span></p></li>';
    }
    $yahoo .= '</ul>';
  } else {
    $yahoo = '<h2>Yahoo</h2><h3>No results found.</h3>';
  }
  if($data->query->results->results[2]){
    $res = $data->query->results->results[2]->results;
    $google = '<h2>Google</h2><ul>';
    $all = sizeof($res);
    for($i=0;$i<$all;$i++){      
      $google .= '<li><h3><a href="'.$res[$i]->url.'">'.
                $res[$i]->titleNoFormatting.
                '</a></h3><p>'.$res[$i]->content.'<span>('.
                $res[$i]->visibleUrl.')</span></p></li>';
    }
    $google .= '</ul>';
  } else {
    $google = '<h2>Yahoo</h2><h3>No results found.</h3>';
  }

  
  $out = '<div class="yui-gb">'.
         '<div class="yui-u first" id="google">'.$google.'</div>'.
         '<div class="yui-u" id="yahoo">'.$yahoo.'</div>'.
         '<div class="yui-u" id="bing">'.$bing.'</div>'.
         '</div>';
} else {
  $out = '<h3>Error retrieving data.</h3>';
}
?>
<?php }?>
<?php if(isset($_GET['json'])){
  echo addslashes($out);
  echo '"})';
} else {
  echo $out;
}?>

