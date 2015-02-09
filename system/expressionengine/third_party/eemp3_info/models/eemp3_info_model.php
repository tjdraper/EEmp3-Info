<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * EEmp3 Info Model
 *
 * @package EEmp3 Info
 * @author  TJ Draper
 * @link    http://www.buzzingpixel.com
 */

class Eemp3_info_model extends CI_Model {

	public function getInfo($fileIdentifier = false)
	{
		$query = ee()->db
			->select('*')
			->from('eemp3')
			->where('file_identifier', $fileIdentifier)
			->limit(1)
			->get();

		if ($query->num_rows > 0) {
			return $this->_formatVars($query->row());
		}

		return false;
	}

	public function setInfo($fileIdentifier, $info)
	{
		$data = array(
			'file_identifier' => $fileIdentifier,
			'filesize' => $info['filesize'],
			'channels' => $info['channels'],
			'sample_rate' => $info['sample_rate'],
			'bitrate' => $info['bitrate'],
			'channelmode' => $info['channelmode'],
			'bitrate_mode' => $info['bitrate_mode'],
			'lossless' => $info['lossless'],
			'compression_ratio' => $info['compression_ratio'],
			'playtime_seconds' => $info['playtime_seconds'],
			'playtime_string' => $info['playtime_string']
		);

		ee()->db->insert('eemp3', $data);
	}

	private function _formatVars($queryRow)
	{
		if (! $queryRow) {
			return false;
		}

		$vars = array();

		$vars[0]['filesize'] = $queryRow->filesize;
		$vars[0]['channels'] = (int) $queryRow->channels;
		$vars[0]['sample_rate'] = (int) $queryRow->sample_rate;
		$vars[0]['bitrate'] = (double) $queryRow->bitrate;
		$vars[0]['channelmode'] = $queryRow->channelmode;
		$vars[0]['bitrate_mode'] = $queryRow->bitrate_mode;
		$vars[0]['lossless'] = (bool) $queryRow->lossless;
		$vars[0]['compression_ratio'] = (double) $queryRow->compression_ratio;
		$vars[0]['playtime_seconds'] = (double) $queryRow->playtime_seconds;
		$vars[0]['playtime_string'] = $queryRow->playtime_string;

		return $vars;
	}
}