<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * EEmp3 Info Module
 *
 * @package EEmp3 Info
 * @author  TJ Draper
 * @link    http://www.buzzingpixel.com
 */

include(PATH_THIRD . 'eemp3_info/config.php');

class Eemp3_info {

	public $return_data;

	public function __construct()
	{
		ee()->load->model('eemp3_info_model');
	}

	public function local()
	{
		$path = ee()->TMPL->fetch_param('path');

		if (! $path) {
			return false;
		}

		$file = $_SERVER['DOCUMENT_ROOT'] . $path;

		if (! file_exists($file)) {
			return false;
		}

		// Check the Model for the info in the DB
		$vars = ee()->eemp3_info_model->getInfo($file);

		if (! $vars) {
			var_dump('no db');
			ee()->load->library('getid3_library_handler');

			// Use getID3 to analyze the file
			$fileInfo = ee()->getid3_library_handler->getID3Info($file);

			$vars = $this->_formatVars($fileInfo);

			ee()->eemp3_info_model->setInfo($file, $vars[0]);
		}

		if (! $vars) {
			return false;
		}

		return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $vars);
	}

	public function remote()
	{
		ee()->load->library('remote_files');

		$url = ee()->TMPL->fetch_param('url');

		if (! $url) {
			return false;
		}

		// Check the Model for the info in the DB
		$vars = ee()->eemp3_info_model->getInfo($url);

		// Send for the remote file
		if (! $vars) {
			ee()->load->library('getid3_library_handler');

			$file = ee()->remote_files->getRemoteFile($url);

			// Use getID3 to analyze the remote file
			$fileInfo = ee()->getid3_library_handler->getID3Info($file);

			$vars = $this->_formatVars($fileInfo);

			ee()->eemp3_info_model->setInfo($url, $vars[0]);

			ee()->remote_files->garbageCollection();
		}

		if (! $vars) {
			return false;
		}

		return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $vars);
	}

	private function _formatVars($fileInfo)
	{
		if (! $fileInfo) {
			return false;
		}

		$vars = array();

		$audioInfo = $fileInfo['audio'];

		$vars[0]['filesize'] = $fileInfo['filesize'];
		$vars[0]['channels'] = $audioInfo['channels'];
		$vars[0]['sample_rate'] = $audioInfo['sample_rate'];
		$vars[0]['bitrate'] = $audioInfo['bitrate'];
		$vars[0]['channelmode'] = $audioInfo['channelmode'];
		$vars[0]['bitrate_mode'] = $audioInfo['bitrate_mode'];
		$vars[0]['lossless'] = $audioInfo['lossless'];
		$vars[0]['compression_ratio'] = $audioInfo['compression_ratio'];
		$vars[0]['playtime_seconds'] = $fileInfo['playtime_seconds'];
		$vars[0]['playtime_string'] = $fileInfo['playtime_string'];

		return $vars;
	}
}