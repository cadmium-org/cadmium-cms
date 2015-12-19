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
				width:100%; height:100%; min-width:320px; background-color:#FFF;
				font:12px/16px "Courier New", Courier, monospace; color:#000; text-align:left;
			}

			.header { padding:16px; background-color:#F3F3F3; border-bottom:1px dotted #CCC; }

			.header .icon { position:absolute; top:0; left:0; width:32px; height:32px; }

			.header .icon > * { position:absolute; top:0; left:12px; width:8px; height:32px; background-color:#C55500; border-radius:2px; }

			.header .icon .e1 {
				-webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg);
				-o-transform:rotate(45deg); transform:rotate(45deg);
			}

			.header .icon .e2 {
				-webkit-transform:rotate(-45deg); -moz-transform:rotate(-45deg); -ms-transform:rotate(-45deg);
				-o-transform:rotate(-45deg); transform:rotate(-45deg);
			}

			.header .text { position:relative; padding:8px 0 8px 42px; font-weight:bold; }

			.content { padding:16px 16px 16px 58px; background-color:#F9F9F9; border-bottom:1px dotted #DDD; }

			.content p { margin-bottom:8px; }

		</style>

	</head>

	<body>

		<div class="header">

			<div class="text">

				<div class="icon"><div class="e1"></div><div class="e2"></div></div>$message$

			</div>

		</div>

		<div class="content">

			<p><b>$file$</b><br />on line <b>$line$</b></p>

			<p><b>Trace:</b><br />$trace$</p>

		</div>

	</body>

</html>
