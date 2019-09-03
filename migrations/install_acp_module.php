<?php
/**
 *
 * Moonbird Talk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, John Beshir, https://moonbird.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace moonbird\talk\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['moonbird_talk_api_key']);
	}

	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('moonbird_talk_api_key', '')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_TALK_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_TALK_TITLE',
				array(
					'module_basename'	=> '\moonbird\talk\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
