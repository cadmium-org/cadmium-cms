<html>

	<head>

		<meta charset="UTF-8" />

		<title>%MAIL_SUBJECT_REGISTER% | $site_title$</title>

	</head>

	<body style="padding:20px; background-color:#F6F6F6; font:12px/16px Tahoma, sans-serif; text-align:left; color:#000;">

		<div style="max-width:500px; margin:0 auto; background-color:#FFF; border:1px solid #CCC; border-radius:5px;">

			<div style="padding:10px; border:1px solid #FFF; border-radius:4px 4px 0 0; background-color:#00B5AD; font-size:18px; line-height:1.5;">

				<a href="$system_url$" style="font-weight:bold; color:#FFF; text-decoration:none;">$site_title$</a>

			</div>

			<div style="padding:10px;">

				<p>%MAIL_TEXT_GREETING%, <strong>$name$</strong>!</p>

				<p>%MAIL_TEXT_REGISTER_SUCCESS% <a href="$system_url$">$system_url$</a>.</p>

				<p>%MAIL_TEXT_REGISTER_LINK%:<br /><a href="$link$">$link$</a>.</p>

			</div>

			<div style="padding:10px; border:1px solid #FFF; border-radius:0 0 4px 4px; background-color:#EEE; font-size:10px; line-height:1.5; color:#666;">

				<p>%MAIL_TEXT_FOOTER_NOREPLY%.<br />%MAIL_TEXT_FOOTER_REPLY_TO%:

				<a href="mailto:$system_email$" style="color:#666; text-decoration:underline;">$system_email$</a></p>

				<p><a href="$system_url$" style="color:#666; text-decoration:underline;">$site_title$</a> &copy; $copyright$</p>

			</div>

		</div>

	</body>

</html>
