<?php
/**
 *
 * Moonbird Talk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, John Beshir, https://moonbird.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace moonbird\talk\tests\dbal;

// Need to include functions.php to use phpbb_version_compare in this test
require_once __DIR__ . '/../../../../../includes/functions.php';

class migrations_test extends \phpbb_database_test_case
{
	/**
	 * @inheritdoc
	 */
	protected static function setup_extensions()
	{
		return array('moonbird/talk');
	}

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;



	/**
	 * @inheritdoc
	 */
	public function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/fixtures/config.xml');
	}

	/**
	 * A simple test checking to see if the database posts table was correctly updated
	 */
	public function test_column()
	{
		if (phpbb_version_compare(PHPBB_VERSION, '3.2.0-dev', '<'))
		{
			// This is how to instantiate db_tools in phpBB 3.1
			$db_tools = new \phpbb\db\tools($this->db);
		}
		else
		{
			// This is how to instantiate db_tools in phpBB 3.2
			$factory = new \phpbb\db\tools\factory();
			$db_tools = $factory->get($this->db);
		}

		$this->assertTrue($db_tools->sql_column_exists(POSTS_TABLE, 'mb_sentiment_version'), 'Asserting that column "mb_sentiment_version" exists');
		$this->assertTrue($db_tools->sql_column_exists(POSTS_TABLE, 'mb_sentiment_magnitude'), 'Asserting that column "mb_sentiment_magnitude" exists');
		$this->assertTrue($db_tools->sql_column_exists(POSTS_TABLE, 'mb_sentiment_score'), 'Asserting that column "mb_sentiment_score" exists');
	}
}
