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
			'moonbird_talk_project' => 'foobar',
		));
		$crawler = self::submit($form);

		// Check it replaces the previous value in the form.
		$crawler = self::request('GET', 'adm/index.php?i=32&sid=' . $this->sid);
		$this->assertEquals($crawler->filter('#moonbird_talk_api_key')->attr('value'), 'bluhbluh');
		$this->assertEquals($crawler->filter('#moonbird_talk_project')->attr('value'), 'foobar');
	}
}

