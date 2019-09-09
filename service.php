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
	const MOONBIRD_TALK_API_PREFIX = 'https://talk.moonbird.io/api/';

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\factory */
	protected $db;

	/** @var \moonbird\talk\curl_service */
	protected $curl_service;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config	$config	Config object
	 * @param \phpbb\db\driver\factory $db DB object
	 * @param \moonbird\talk\controller\ $curl_service Interface for remote HTTP requests
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\factory $db, \moonbird\talk\curl_service $curl_service)
	{
		$this->config = $config;
		$this->db = $db;
		$this->curl_service = $curl_service;
	}

	public function submit_post($post_id)
	{
		// NOT IMPLEMENTED
	}
}
