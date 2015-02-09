<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Remote File Handling Library
 *
 * @author  TJ Draper
 * @link    http://www.buzzingpixel.com
 */

class Remote_files {

	public function getRemoteFile($remoteFile)
	{
		set_time_limit(0);

		if (! $remoteFile) {
			return false;
		}

		$path = ee()->config->_config_paths[1] . 'cache/eemp3_info';

		$fileName = uniqid('temp_', true) . '.mp3';

		$file = $path . '/' . $fileName;

		if (! file_exists($path)) {
			mkdir($path);
		}
		
		$fp = fopen($file, 'w');

		$ch = curl_init($remoteFile);

		curl_setopt($ch, CURLOPT_FILE, $fp);

		$data = curl_exec($ch);

		curl_close($ch);

		fclose($fp);

		if (! $data) {
			return false;
		}

		return $file;
	}

	public function garbageCollection()
	{
		$path = ee()->config->_config_paths[1] . 'cache/eemp3_info';

		$files = glob($path . '/*');

		foreach($files as $file) {
			if (is_file($file)) {
				unlink($file);
			}
		}
	}
}