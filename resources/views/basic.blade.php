<?php
print "<?xml version=\"1.0\" ?>";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
    <meta charset="UTF-8" />
    <title>WEHUNT</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans">
	<script type="text/javascript" src="libs/angularjs/1.8.2/angular.js"></script>
	<script type="text/javascript" src="libs/angularjs/1.8.2/angular-animate.min.js"></script>
	<script type="text/javascript" src="libs/angularjs/1.8.2/angular-route.min.js"></script>
	<script type="text/javascript" src="libs/angularjs/1.8.2/angular-aria.min.js"></script>
	<script type="text/javascript" src="libs/angularjs/1.8.2/angular-messages.min.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery-ui-1.13.3.min.js"></script>
	<script type="text/javascript" src="libs/angular-material/v1.2.2/angular-material.js"></script>
	<link rel="stylesheet" href="libs/angular-material/v1.2.2/angular-material.css">
<script type="text/javascript">
/*<![CDATA[*/
@yield('JSscript')
/*]]>*/
</script>
<style type="text/css">
/*<![CDATA[*/
@yield('CSSscript')
/*]]>*/
</style>
</head>
<body ng-app="weHunt">
@yield('bodyContent')
<script type="text/javascript">
/*<![CDATA[*/
@yield('ANGULARJS')
$(document).ready(function(){
@yield('JSready')
});
/*]]>*/
</script>
</body>
</html>