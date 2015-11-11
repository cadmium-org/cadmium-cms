<!DOCTYPE html>

<html>

	<head>

		<meta charset="UTF-8" />

		<title>Exception</title>

		<style type="text/css">

			* {
				width:auto; height:auto; padding:0; margin:0; border:none; outline:none;
				background-color:transparent; background-repeat:no-repeat; background-position:0 0;
			}

			html { width:100%; height:100%; }

			body {
				width:100%; height:100%; min-width:800px; background-color:#FFF;
				font:12px/16px "Courier New", Courier, monospace; color:#000; text-align:left;
			}

			div.container {
				width:auto; height:auto; padding:16px;
				background-color:#F3F3F3; border-bottom:1px dotted #CCC; font-weight:bold;
			}

			div.icon { position:absolute; top:0; left:0; width:32px; height:32px; }

			div.icon div { position:absolute; top:0; left:12px; width:8px; height:32px; background:#C55500; border-radius:2px; }

			div.icon div.e1 {
				-webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg);
				-o-transform:rotate(45deg); transform:rotate(45deg);
			}

			div.icon div.e2 {
				-webkit-transform:rotate(-45deg); -moz-transform:rotate(-45deg); -ms-transform:rotate(-45deg);
				-o-transform:rotate(-45deg); transform:rotate(-45deg);
			}

			div.text { position:relative; width:auto; height:16px; padding:8px 0 8px 42px; }

		</style>

	</head>

	<body>

		<div class="container">

			<div class="text">

				<div class="icon"><div class="e1"></div><div class="e2"></div></div>$message$

			</div>

		</div>

	</body>

</html>
