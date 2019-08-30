<?php
/**
 *
 * Moonbird Talk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, John Beshir, https://moonbird.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace moonbird\talk\acp;

/**
 * Moonbird Talk ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\moonbird\talk\acp\main_module',
			'title'		=> 'ACP_TALK_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_TALK',
					'auth'	=> 'ext_moonbird/talk && acl_a_board',
					'cat'	=> array('ACP_TALK_TITLE')
				),
			),
		);
	}
}
