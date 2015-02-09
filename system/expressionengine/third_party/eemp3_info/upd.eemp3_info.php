<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * EEmp3 Info Module Install/Update File
 *
 * @package EEmp3 Info
 * @author  TJ Draper
 * @link    http://www.buzzingpixel.com
 */

include(PATH_THIRD . 'eemp3_info/config.php');

class Eemp3_info_upd {

	public $name = EEMP3_INFO_NAME;
	public $version = EEMP3_INFO_VER;

	public function install()
	{
		$sanitizedName = ucfirst(
			strtolower(
				str_replace(' ', '_', $this->name)
			)
		);

		ee()->db->insert('modules', array(
			'module_name' => $sanitizedName,
			'module_version' => $this->version,
			'has_cp_backend' => 'n',
			'has_publish_fields' => 'n'
		));

		ee()->load->dbforge();

		$fields = array();

		$fields['id'] = array(
			'type' => 'INT',
			'unsigned' => true,
			'auto_increment' => true
		);

		$fields['file_identifier'] = array(
			'type' => 'TEXT'
		);

		$fields['filesize'] = array(
			'type' => 'BIGINT',
			'unsigned' => true,
			'default' => 0
		);

		$fields['channels'] = array(
			'type' => 'TINYINT',
			'unsigned' => true,
			'default' => 0
		);

		$fields['sample_rate'] = array(
			'type' => 'INT',
			'unsigned' => true,
			'default' => 0
		);

		$fields['bitrate'] = array(
			'type' => 'DOUBLE'
		);

		$fields['channelmode'] = array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			'default' => ''
		);

		$fields['bitrate_mode'] = array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			'default' => ''
		);

		$fields['lossless'] = array(
			'type' => 'INT',
			'unsigned' => true,
			'default' => 0
		);

		$fields['compression_ratio'] = array(
			'type' => 'DOUBLE'
		);

		$fields['playtime_seconds'] = array(
			'type' => 'DOUBLE'
		);

		$fields['playtime_string'] = array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			'default' => ''
		);

		ee()->dbforge->add_field($fields);

		ee()->dbforge->add_key('id', true);

		ee()->dbforge->create_table('eemp3', true);

		return true;
	}

	public function uninstall()
	{
		$sanitizedName = ucfirst(
			strtolower(
				str_replace(' ', '_', $this->name)
			)
		);

		ee()->db->delete('modules', array(
			'module_name' => $sanitizedName
		));

		ee()->load->dbforge();

		ee()->dbforge->drop_table('eemp3');

		return true;
	}

	public function update($current = '')
	{
		return true;
	}
}