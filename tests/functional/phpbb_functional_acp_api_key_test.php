<?php
/**
 * @group functional
 */
class phpbb_functional_acp_api_key_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('moonbird/talk');
	}

	public function test_acp_api_key()
	{
		$this->login();
		$this->admin_login();

		// Set the API key
		$crawler = self::request('GET', 'adm/index.php?i=32&sid=' . $this->sid);
		$form = $crawler->selectButton('Submit')->form(array(
			'moonbird_talk_api_key' => 'bluhbluh',
		));
		$crawler = self::submit($form);

		// Check it saved correctly.
		$this->assertEquals(self::$config['moonbird_talk_api_key'], 'bluhbluh');

		// Check it shows up in the form
		$crawler = self::request('GET', 'adm/index.php?i=32&sid=' . $this->sid);
		$this->assertEquals($crawler->filter('#moonbird_talk_api_key').html(), 'bluhbluh');
	}
}

