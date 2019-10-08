<?php
/**
 * @group functional
 */
class phpbb_functional_acp_unsubmitted_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('moonbird/talk');
	}

	public function test_acp_unsubmitted_count()
	{
		$this->login();
		$this->admin_login();

		$crawler = self::request('GET', 'adm/index.php?i=32&sid=' . $this->sid);
		$this->assertEquals($crawler->filter('#moonbird_posts_unsubmitted_count')->text(), '0');
	}
}

