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
		global $table_prefix;
		$this->db->sql_query("SELECT mb_sentiment_version, forum_id, post_text, post_time FROM {$table_prefix}posts WHERE post_id = {$post_id}");
		$row = $this->db->sql_fetchrow(false);
		$this->db->sql_freeresult(false);

		if ($row['mb_sentiment_version'] === 0)
		{
			$resultJson = $this->curl_service->post(\moonbird\talk\service::MOONBIRD_TALK_API_PREFIX . "submit",
				array(
					'apitoken' => $this->config['moonbird_talk_api_key'],
					'space' => $this->config['moonbird_talk_project'],
					'channel' => $row['forum_id'],
					'message' => $row['post_text'],
					'timestamp' => $row['post_time'],
				));

			$result = json_decode($resultJson);

			$this->db->sql_query("UPDATE {$table_prefix}posts SET mb_sentiment_version = 1, mb_sentiment_magnitude = {$this->db->sql_escape($result->SentimentMagnitude)}, mb_sentiment_score = {$this->db->sql_escape($result->SentimentScore)} WHERE post_id = {$post_id}");
		}
	}
}
