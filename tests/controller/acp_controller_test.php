<?php

namespace moonbird\talk\tests\controller;

class acp_controller_test extends \phpbb_test_case
{
	/** @var \moonbird\talk\controller\acp_controller */
	protected $controller;

	protected $config;
	protected $language;
	protected $log;
	protected $request;
	protected $template;
	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->config = $this->getMockBuilder('\phpbb\config\config')
			->disableOriginalConstructor()
			->getMock();
		$this->language = $this->getMockBuilder('\phpbb\language\language')
			->disableOriginalConstructor()
			->getMock();
		$this->log = $this->getMockBuilder('\phpbb\log\log')
			->disableOriginalConstructor()
			->getMock();
		$this->request = $this->getMockBuilder('\phpbb\request\request')
			->disableOriginalConstructor()
			->getMock();
		$this->template = $this->getMockBuilder('\phpbb\template\template')
			->disableOriginalConstructor()
			->getMock();
		$this->user = $this->getMockBuilder('\phpbb\user')
			->disableOriginalConstructor()
			->getMock();

		$this->controller = new \moonbird\talk\controller\acp_controller(
			$this->config,
			$this->language,
			$this->log,
			$this->request,
			$this->template,
			$this->user
		);
	}

	public function test_request_no_post()
	{
		$this->template->expects($this->once())
			->method('assign_vars');

		$this->config->expects($this->once())
			->method('get')
			->with('moonbird_talk_api_key')
			->willReturn('bluhbluh');

		$this->controller->display_options(array(
			'S_ERROR'		=> array(),
			'ERROR_MSG'		=> '',
			'U_ACTION'		=> null,
			'MOONBIRD_TALK_API_KEY'	=> 'bluhbluh',
		));
	}
}