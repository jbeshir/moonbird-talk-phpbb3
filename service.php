<?php
/**
 *
 * Moonbird Talk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, John Beshir, https://moonbird.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace moonbird\talk;

/**
 * Moonbird Talk Service info.
 */
class service
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\config\config */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param \phpbb\user $user       User object
	 * @param \phpbb\config\config	$config	Config object
	 */
	public function __construct(\phpbb\user $user, \phpbb\config\config $config)
	{
		$this->user = $user;
		$this->config = $config;
	}
}
