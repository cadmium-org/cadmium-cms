<?php

namespace {

	abstract class Headers {

		private static $cache_send = false;

		private static $status_codes = array (

			STATUS_CODE_100     => '100 Continue',
			STATUS_CODE_101     => '101 Switching Protocols',
			STATUS_CODE_102     => '102 Processing',

			STATUS_CODE_200     => '200 OK',
			STATUS_CODE_201     => '201 Created',
			STATUS_CODE_202     => '202 Accepted',
			STATUS_CODE_203     => '203 Non-Authoritative Information',
			STATUS_CODE_204     => '204 No Content',
			STATUS_CODE_205     => '205 Reset Content',
			STATUS_CODE_206     => '206 Partial Content',
			STATUS_CODE_207     => '207 Multi-Status',
			STATUS_CODE_226     => '226 IM Used',

			STATUS_CODE_300     => '300 Multiple Choices',
			STATUS_CODE_301     => '301 Moved Permanently',
			STATUS_CODE_302     => '302 Found',
			STATUS_CODE_303     => '303 See Other',
			STATUS_CODE_304     => '304 Not Modified',
			STATUS_CODE_305     => '305 Use Proxy',
			STATUS_CODE_307     => '307 Temporary Redirect',

			STATUS_CODE_400     => '400 Bad Request',
			STATUS_CODE_401     => '401 Unauthorized',
			STATUS_CODE_402     => '402 Payment Required',
			STATUS_CODE_403     => '403 Forbidden',
			STATUS_CODE_404     => '404 Not Found',
			STATUS_CODE_405     => '405 Method Not Allowed',
			STATUS_CODE_406     => '406 Not Acceptable',
			STATUS_CODE_407     => '407 Proxy Authentication Required',
			STATUS_CODE_408     => '408 Request Timeout',
			STATUS_CODE_409     => '409 Conflict',
			STATUS_CODE_410     => '410 Gone',
			STATUS_CODE_411     => '411 Length Required',
			STATUS_CODE_412     => '412 Precondition Failed',
			STATUS_CODE_413     => '413 Request Entity Too Large',
			STATUS_CODE_414     => '414 Request-URI Too Long',
			STATUS_CODE_415     => '415 Unsupported Media Type',
			STATUS_CODE_416     => '416 Requested Range Not Satisfiable',
			STATUS_CODE_417     => '417 Expectation Failed',
			STATUS_CODE_422     => '422 Unprocessable Entity',
			STATUS_CODE_423     => '423 Locked',
			STATUS_CODE_424     => '424 Failed Dependency',
			STATUS_CODE_425     => '425 Unordered Collection',
			STATUS_CODE_426     => '426 Upgrade Required',
			STATUS_CODE_449     => '449 Retry With',

			STATUS_CODE_500     => '500 Internal Server Error',
			STATUS_CODE_501     => '501 Not Implemented',
			STATUS_CODE_502     => '502 Bad Gateway',
			STATUS_CODE_503     => '503 Service Unavailable',
			STATUS_CODE_504     => '504 Gateway Timeout',
			STATUS_CODE_505     => '505 HTTP Version Not Supported',
			STATUS_CODE_506     => '506 Variant Also Negotiates',
			STATUS_CODE_507     => '507 Insufficient Storage',
			STATUS_CODE_509     => '509 Bandwidth Limit Exceeded',
			STATUS_CODE_510     => '510 Not Extended'
		);

		private static $content_types_text = array (

			MIME_TYPE_HTML      => 'text/html',
			MIME_TYPE_XML       => 'text/xml',
			MIME_TYPE_JSON      => 'application/json'
		);

		private static $content_types_media = array (

			MIME_TYPE_GIF       => 'image/gif',
			MIME_TYPE_JPEG      => 'image/jpeg',
			MIME_TYPE_PNG       => 'image/png'
		);

		# Check if string is status code

		public static function isStatusCode($string) {

			return isset(self::$status_codes[$string]);
		}

		# Check if string is content type

		public static function isContentType($string) {

			return (self::isContentTypeText($string) || self::isContentTypeMedia($string));
		}

		# Check if string is text content type

		public static function isContentTypeText($string) {

			return isset(self::$content_types_text[$string]);
		}

		# Check if string is media content type

		public static function isContentTypeMedia($string) {

			return isset(self::$content_types_media[$string]);
		}

		# Send status header

		public static function status($code) {

			if (self::isStatusCode($code)) header(getenv('SERVER_PROTOCOL') . ' ' . self::$status_codes[$code]);
		}

		# Send content header

		public static function content($type) {

			if (self::isContentTypeText($type)) {

				return header('Content-type: ' . self::$content_types_text[$type] . '; charset=' . CONFIG_FRAMEWORK_DEFAULT_CHARSET);
			}

			if (self::isContentTypeMedia($type)) {

				return header('Content-type: ' . self::$content_types_media[$type]);
			}
		}

		# Send cache headers

		public static function cache($limiter, $expires) {

			if (self::$cache_send) return;

			$limiter = String::validate($limiter); $expires = Number::unsigned($expires);

			if (!in_array($limiter, array(CACHE_LIMITER_PRIVATE, CACHE_LIMITER_PUBLIC), true)) return;

			header('Expires: ' . gmdate('D, d M Y H:i:s', (ENGINE_TIME + $expires)) . ' GMT');

			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', ENGINE_TIME) . ' GMT');

			header('Cache-Control: ' . $limiter . ', max-age=' . $expires . ', pre-check=' . $expires);

			header('Pragma: ' . $limiter);

			# ------------------------

			self::$cache_send = true;
		}

		# Send no cache headers

		public static function nocache() {

			if (self::$cache_send) return;

			header('Expires: ' . gmdate('D, d M Y H:i:s', strtotime('-1 day')) . ' GMT');

			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', strtotime('-1 day')) . ' GMT');

			header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

			header('Cache-Control: post-check=0, pre-check=0', false);

			header('Pragma: no-cache');

			# ------------------------

			self::$cache_send = true;
		}
	}
}
