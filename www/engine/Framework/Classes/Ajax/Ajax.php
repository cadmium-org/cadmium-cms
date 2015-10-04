<?php

namespace {

	abstract class Ajax {

		# Create new dataset

		public static function dataset() {

			return new Ajax\Utils\Dataset();
		}

		# Check if object is dataset

		public static function isDataset($object) {

			return ($object instanceof Ajax\Utils\Dataset);
		}

		# Output JSON data

		public static function output(Ajax\Utils\Dataset $dataset) {

			Headers::nocache(); Headers::status(STATUS_CODE_200); Headers::content(MIME_TYPE_JSON);

			echo json_encode(array_merge(['status' => intval($dataset->status())], $dataset->data()));
		}
	}
}
