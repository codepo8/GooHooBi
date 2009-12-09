<?php
/*
  GooHooBi by Christian Heilmann
  Homepage: http://github.com/codepo8/GooHooBi
  Copyright (c)2009,2010 Christian Heilmann
  Code licensed under the BSD License:
  http://wait-till-i.com/license.txt
*/
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
form{font-size:150%;margin-top:-3.2em;}
h1{font-size:300%;margin:0;text-align:right;color:#3c3}
ul,ul li{margin:0;padding:0;list-style:none;}
p span{display:block;text-align:right;margin-top:.5em;font-size:90%;color:#999;}
input[type=text]{-moz-border-radius:5px;-webkit-border-radius:5px;border:1px solid #fff;padding:3px;}
input[type=submit]{-moz-border-radius:5px;-webkit-border-radius:5px;border:2px solid #3c3;background:#3c3}
.info{font-size:200%;color:#999;margin:1em 0;}
.smallinfo{font-size:120%;color:#999;margin:1em 0;}
#ft p{color:#666;text-align:right;}
#ft a{color:#ccc;}
#yahoo a{color:#c6c;}
#yahoo h2{background:#c6c;}
#bing h2{background:#fc6;}
#bing a{color:#fc6;}
h3{margin:0 0 .2em 0}
#modeswitch{text-align:right;}
#modeswitch a{color:#fff;}
h2#resultsheader,h2#preview{background:#000;padding:2px 5px;color:#fff;margin:1em 0 0 0;font-weight:bold;-moz-box-shadow:none;-moz-border-radius:0;-webkit-border-radius:0;text-shadow:none;}
<?php if(isset($_GET['research'])){?>
#results{height:200px;overflow:auto;}
iframe{display:block;width:100%;border:none;margin:0 0 1em 0;height:400px;}
#results ul,#results h2{margin-right:.5em;}
<?php }?>
</style>
</head>
<body>
<div id="<?php echo (isset($_GET['research']))?'doc2':'doc'?>" class="yui-t7">
  <div id="hd" role="banner"><h1>GooHooBi</h1><p id="modeswitch">Mode <?php echo (isset($_GET['research']))?'<a href="index.php">simple</a>':'<strong>simple</strong>'?> - <?php echo (!isset($_GET['research']))?'<a href="index.php?research">research</a>':'<strong>research</strong>'?></p></div>
  <div id="bd" role="main">
    <form action="index.php" method="get" id="mainform">
      <div>
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" value="<?php echo $search;?>">
        <input type="submit" value="Go!">
      </div>
    </form>
<?php if(!isset($_GET['research'])){?>
  <p class="info">GooHooBi allows you to search Google, Yahoo and Bing in one go. Simply add your search term above and hit the Go button.</p>
<?php }?>
<?php if(isset($_GET['research'])){?>
  <p class="smallinfo">This is GooHooBi in research mode. If you click on links in the results the page will open in the same interface.</p>
  <h2 id="resultsheader">Search results</h2>
<?php }?>
    <div id="results">
    <?php if(isset($_GET['search'])){
      include('goohoobi.php');
    }?>
    </div>
    <?php if(isset($_GET['research'])){?>
      <h2 id="preview">Web preview</h2>
      <iframe name="fr" id="fr"></iframe>
    <?php }?>
  </div>
  <div id="ft" role="contentinfo"><p>Written by <a href="http://wait-till-i.com">Chris Heilmann</a>, powered by <a href="http://developer.yahoo.com/yui">YUI</a> and <a href="http://developer.yahoo.com/yql/console/?q=select%20*%20from%20query.multi%20where%20queries%3D%27%0A%20%20select%20Title%2CDescription%2CUrl%2CDisplayUrl%20%0A%20%20%20%20from%20microsoft.bing.web%2820%29%20where%20query%3D%22cat%22%3B%0A%20%20select%20title%2Cclickurl%2Cabstract%2Cdispurl%20%0A%20%20%20%20from%20search.web%2820%29%20where%20query%3D%22cat%22%3B%0A%20%20select%20titleNoFormatting%2Curl%2Ccontent%2CvisibleUrl%20%0A%20%20%20%20from%20google.search%2820%29%20where%20q%3D%22cat%22%0A%27&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys">YQL</a>.</p></div>
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
    <?php if(isset($_GET['research'])){?>
      var research = '&research=true';
    <?php }?>
    s.setAttribute('src','goohoobi.php?search='+query+'&json=true'+research);
    document.getElementsByTagName('head')[0].appendChild(s);
  }
  document.getElementById('mainform').onsubmit = function(){
    doSearch();
    return false;
  }
  return {se:seed}
}();
</script>
</body>
</html>