<?php

/**
 * @package Framework\Headers
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Headers {

		private static $cache_sent = false;

		# Status codes

		private static $status_codes = [

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
		];

		# Content types

		private static $content_types_text = [

			MIME_TYPE_HTML      => 'text/html',
			MIME_TYPE_XML       => 'text/xml',
			MIME_TYPE_JSON      => 'application/json'
		];

		private static $content_types_media = [

			MIME_TYPE_JPEG      => 'image/jpeg',
			MIME_TYPE_PNG       => 'image/png',
			MIME_TYPE_GIF       => 'image/gif'
		];

		/**
		 * Check if a given value is a valid status code
		 */

		public static function isStatusCode(int $value) : bool {

			return isset(self::$status_codes[$value]);
		}

		/**
		 * Check if a given value is a valid content type
		 */

		public static function isContentType(string $value) : bool {

			return (self::isTextContentType($value) || self::isMediaContentType($value));
		}

		/**
		 * Check if a given value is a text content type
		 */

		public static function isTextContentType(string $value) : bool {

			return isset(self::$content_types_text[$value]);
		}

		/**
		 * Check if a given value is a media content type
		 */

		public static function isMediaContentType(string $value) : bool {

			return isset(self::$content_types_media[$value]);
		}

		/**
		 * Send a status code header
		 */

		public static function sendStatus(int $code) {

			if (self::isStatusCode($code)) header(getenv('SERVER_PROTOCOL') . ' ' . self::$status_codes[$code]);
		}

		/**
		 * Send a content type header
		 */

		public static function sendContent(string $type) {

			if (self::isTextContentType($type)) {

				return header('Content-type: ' . self::$content_types_text[$type] . '; charset=UTF-8');
			}

			if (self::isMediaContentType($type)) {

				return header('Content-type: ' . self::$content_types_media[$type]);
			}
		}

		/**
		 * Send cache headers with a given expiration time and cache-control (can be private or public)
		 */

		public static function sendCache(int $expires, bool $public = false) {

			if (self::$cache_sent) return;

			header('Expires: ' . gmdate('D, d M Y H:i:s', (REQUEST_TIME + $expires)) . ' GMT');

			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', REQUEST_TIME) . ' GMT');

			$limiter = ($public ? 'public' : 'private');

			header('Cache-Control: ' . $limiter . ', max-age=' . $expires . ', pre-check=' . $expires);

			header('Pragma: ' . $limiter);

			# ------------------------

			self::$cache_sent = true;
		}

		/**
		 * Tell a client not to cache a response
		 */

		public static function sendNoCache() {

			if (self::$cache_sent) return;

			header('Expires: ' . gmdate('D, d M Y H:i:s', strtotime('-1 day')) . ' GMT');

			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', strtotime('-1 day')) . ' GMT');

			header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

			header('Cache-Control: post-check=0, pre-check=0', false);

			header('Pragma: no-cache');

			# ------------------------

			self::$cache_sent = true;
		}
	}
}
