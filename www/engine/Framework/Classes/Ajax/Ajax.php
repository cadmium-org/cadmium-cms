<?php

namespace {

	abstract class Ajax {

		# Get requested data

		public static function request(array $params) {

			$form = new Form('ajax');

			foreach ($params as $name) $form->virtual($name);

			# ------------------------

			return $form->post();
		}

		# Create new response

		public static function response() {

			return new Ajax\Utils\Response();
		}

		# Check if object is response

		public static function isResponse($object) {

			return ($object instanceof Ajax\Utils\Response);
		}

		# Output JSON data

		public static function output(Ajax\Utils\Response $response) {

			Headers::nocache(); Headers::status(STATUS_CODE_200); Headers::content(MIME_TYPE_JSON);

			echo json_encode(array_merge(['status' => intval($response->status())], $response->data()));
		}
	}
}
