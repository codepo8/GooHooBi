<?php
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
  <title>GooHooBi - search Google, Yahoo and Bing in one go!</title>
  <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
  <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
<style type="text/css" media="screen">
html,body{color:#fff;background:#222;font-family:calibri,verdana,arial,sans-serif;}
h2{background:#369;padding:5px;color:#fff;font-weight:bold;-moz-box-shadow: 0px 4px 2px -2px #000;-moz-border-radius:5px;-webkit-border-radius:5px;text-shadow: #000 1px 1px;}
h3 a{color:#69c;text-decoration:none;}
form{font-size:150%;margin-top:-1.8em;}
h1{font-size:300%;margin:0;text-align:right;color:#3c3}
ul,ul li{margin:0;padding:0;list-style:none;}
p span{display:block;text-align:right;margin-top:.5em;font-size:90%;color:#999;}
input[type=text]{-moz-border-radius:5px;-webkit-border-radius:5px;border:1px solid #fff;padding:3px;}
input[type=submit]{-moz-border-radius:5px;-webkit-border-radius:5px;border:2px solid #3c3;background:#3c3}
.info{font-size:200%;color:#999;margin:1em 0;}
#ft p{color:#666;text-align:right;}
#ft a{color:#ccc;}
#yahoo a{color:#c6c;}
#yahoo h2{background:#c6c;}
#bing h2{background:#fc6;}
#bing a{color:#fc6;}
h3{margin:0 0 .2em 0}
</style>
</head>
<body>
<div id="doc" class="yui-t7">
  <div id="hd" role="banner"><h1>GooHooBi</h1></div>
  <div id="bd" role="main">
    <form action="index.php" method="get" id="mainform">
      <div>
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" value="<?php echo $search;?>">
        <input type="submit" value="Go!">
      </div>
    </form>
    <p class="info">GooHooBi allows you to search Google, Yahoo and Bing in one go. Simply add your search term above and hit the Go button.</p>
    <div id="results">
    <?php if(isset($_GET['search'])){
      include('goohoobi.php');
    }?>
    </div>
  </div>
  <div id="ft" role="contentinfo"><p>Written by <a href="http://wait-till-i.con">Chris Heilmann</a>, powered by <a href="http://developer.yahoo.com/yui">YUI</a> and <a href="http://developer.yahoo.com/yql/console/?q=select%20*%20from%20query.multi%20where%20queries%3D%27select%20Title%2CDescription%2CUrl%2CDisplayUrl%20from%20microsoft.bing.web%20where%20query%3D%22css%20site%3Await-till-i.com%22%3Bselect%20title%2Cclickurl%2Cabstract%2Cdispurl%20from%20search.web%20where%20query%20%3D%20%22pizza%20%20site%3Await-till-i.com%22%3Bselect%20titleNoFormatting%2Curl%2Ccontent%2CvisibleUrl%20from%20google.search%20where%20q%20%3D%20%22pizza%20site%3Await-till-i.com%22%27&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys">YQL</a>.</p></div>
</div>
<script type="text/javascript" charset="utf-8">
goohoobi = function(){
  var results = document.getElementById('results');
  function seed(o){
    results.innerHTML = o.result;
  }
  function doSearch(){
    results.innerHTML = '<div class="yui-gb">\
      <div class="yui-u first" id="google">\
      <h2>Google loading &hellip;</h2></div>\
      <div class="yui-u" id="yahoo"><h2>Yahoo loading &hellip;</h2></div>\
      <div class="yui-u" id="bing"><h2>Bing loading &hellip;</h2></div>\
    </div>';
    var query = document.getElementById('search').value;
    var s = document.createElement('script');
    s.setAttribute('src','goohoobi.php?search='+query+'&json=true');
    document.getElementsByTagName('head')[0].appendChild(s);
  }
  document.getElementById('mainform').onsubmit = function(){
    doSearch();
    return false;
  }
  return {
    se:seed
  }
}();
</script>
</body>
</html>