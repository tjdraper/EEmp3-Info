<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ID3 Library
 *
 * @author  TJ Draper
 * @link    http://www.buzzingpixel.com
 */

class Getid3_library_handler {

	public function getID3Info($file)
	{
		if (! $file) {
			return false;
		}

		require_once(EEMP3_INFO_PATH . 'libraries/getid3/getid3.php');

		$getID3 = new getID3;

		$fileInfo = $getID3->analyze($file);

		getid3_lib::CopyTagsToComments($fileInfo);

		return $fileInfo;
	}
}