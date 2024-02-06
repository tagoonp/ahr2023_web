<!DOCTYPE HTML>
<!--
	Paradigm Shift by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>AHR - PGF 2023</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />

		<link href="pgf2023/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/vendor/css/pages/page-icons.css" />
		<link rel="stylesheet" href="./style.css?v=<?php echo date('U'); ?>" />
	</head>
	<body>

		<div class="panal" style="background: #ccc;">
			<div class="container">
				<div class="p-4" style="padding-top: 300px;">
					<h4 class="mb-0" id="op1">INTERNATIONAL HYBRID CONFERENCE</h4>
					<h2 class="mb-0" style="font-size: 2em;">PGF 2023</h2>
					<h3 class="mb-0">THE 17<sup>th</sup> POSTGRADUATE FORUM OF HEALTH SYSTEMS AND POLICIES:</h3>
					<h1 style="font-size: 3.5em;" class="mb-2">Post-Covid Health Equity</h1>
					<h2 class="mb-0" style="font-size: 1.5em;">17 - 18 July 2023</h2>
					<h4 class="mb-2 d-none d-sm-block">at Conference Center and Health Science Library Building
Faculty of Medicine, Prince of Songkla University</h4>
					<div class="d-block d-md-none" style="text-align: right;">
						<button class="btn btn-primary text-white" style="margin-top: -20px; border-radius: 50%; width: 50px; height: 50px;" onclick="window.location = './pgf2023/'"><i class="bx bx-right-arrow-alt" style="font-size: 2em; margin-top: -0px;"></i></button>
					</div>
					<div class="d-none d-md-block">
						<button class="btn btn-primary text-white" style="padding-left: 20px;" onclick="window.location = './pgf2023/'">Visit<i class="bx bx-right-arrow-alt" style="font-size: 2em; margin-top: -10px;"></i></button>
					</div>
				</div>
			</div>
		</div>
		<div class="panal " style="background: #000;">
			<div class="container">
				<div class="p-4 text-right-">
					<h4 class="mb-0 text-white mt-3" id="op2-">INTERNATIONAL HYBRID CONFERENCE</h4>
					<h2 class="mb-0 text-white" style="font-size: 2em;">AHR-iCON 2023</h2>
					<h3 class="mb-3 text-white">THE 2<sup>nd</sup> ANNUAL HEALTH RESEARCH INTERNATIONAL CONFERENCE 2023</h3>
					<h1 style="font-size: 2em;" class="mb-2 text-white">Global Health & Medical Sciences:<br>Research & Innovation towards Post-Covid Health Equity</h1>
					<h2 class="mb-0 text-white" style="font-size: 1.5em;">19 - 20 July 2023</h2>
					<h4 class="mb-2 d-none d-md-block">at Conference Center and Health Science Library Building
Faculty of Medicine, Prince of Songkla University</h4>
					<div class="d-block d-sm-none" style="text-align: left;">
						<button class="btn btn-primary text-white" style="margin-top: -50px; border-radius: 50%; width: 50px; height: 50px;" onclick="window.location = './pgf2023/'"><i class="bx bx-right-arrow-alt" style="font-size: 2em; margin-top: -0px;"></i></button>
					</div>
					<div class="d-none d-md-block">
						<button class="btn btn-success text-white" style="padding-left: 20px;" onclick="window.location = './pgf2023/'">Visit<i class="bx bx-right-arrow-alt" style="font-size: 2em; margin-top: -10px;"></i></button>
					</div>
				</div>
			</div>
		</div>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.scrolly.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>

		<script>
			$(document).ready(function(){
				$h = $(document).height()
				console.log($h);
				$eh = $h/2;
				$('.panal').height($eh)
				setTimeout(function(){ $('#op1').css('margin-top', ($eh/6) + 'px'); $('#op2').css('margin-top', ($eh/6) + 'px') }, 0)
			})
		</script>

	</body>
</html>
