<?php
/**
 *
 * Moonbird Talk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, John Beshir, https://moonbird.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace moonbird\talk\tests\service;

class service_test extends \phpbb_test_case
{
	protected $config;
	protected $db;
	protected $curl_service;
	protected $service;

	public function setUp()
	{
		parent::setUp();

		$this->config = new \phpbb\config\config(array(
			'moonbird_talk_api_key' => 'bluhbluh',
			'moonbird_talk_project' => 'foobar'
		));

		$this->db = $this->getMockBuilder('\phpbb\db\driver\factory')
			->disableOriginalConstructor()
			->getMock();

		$this->curl_service = $this->getMockBuilder('\moonbird\talk\curl_service')
			->disableOriginalConstructor()
			->getMock();

		$this->service = new \moonbird\talk\service($this->config, $this->db, $this->curl_service);
	}

	public function test_submit_post_already_done()
	{
		global $table_prefix;
		$this->db->expects($this->once())
			->method('sql_query')
			->with("SELECT mb_sentiment_version, forum_id, post_text, post_time FROM {$table_prefix}posts WHERE post_id = 17");

		$this->db->expects($this->once())
			->method('sql_fetchrow')
			->with(false)
			->willReturn(array('mb_sentiment_version' => 1, 'forum_id' => 2, 'post_text' => 'Test happy post yay!'));

		$this->db->expects($this->once())
			->method('sql_freeresult')
			->with(false);

		$this->curl_service->expects($this->never())
			->method('post');

		$this->service->submit_post(17);
	}

	public function test_submit_post_new()
	{
		global $table_prefix;
		$this->db->expects($this->exactly(2))
			->method('sql_query')
			->with($this->logicalOr(
				$this->equalTo("SELECT mb_sentiment_version, forum_id, post_text, post_time FROM {$table_prefix}posts WHERE post_id = 17"),
				$this->equalTo("UPDATE {$table_prefix}posts SET mb_sentiment_version = 1, mb_sentiment_magnitude = 3, mb_sentiment_score = 2 WHERE post_id = 17")
			));

		$this->db->expects($this->once())
			->method('sql_fetchrow')
			->with(false)
			->willReturn(array('mb_sentiment_version' => 0, 'forum_id' => 2, 'post_text' => 'Test happy post yay!', post_time => 123456));

		$this->db->expects($this->once())
			->method('sql_freeresult')
			->with(false);

		$this->curl_service->expects($this->once())
			->method('post')
			->with(\moonbird\talk\service::MOONBIRD_TALK_API_PREFIX . "submit", array(
				'apitoken' => 'bluhbluh',
				'space' => 'foobar',
				'channel' => '2',
				'message' => 'Test happy post yay!',
				'timestamp' => 123456,
			))
			->willReturn("{SentimentMagnitude:3,SentimentScore:2}");

		$this->service->submit_post(17);
	}
}
