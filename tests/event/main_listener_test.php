<?php
/**
 *
 * Moonbird Talk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, John Beshir, https://moonbird.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace moonbird\talk\tests\event;

class main_test extends \phpbb_test_case
{
	public function test_submit_post_end()
	{
		$service = $this->getMockBuilder('\moonbird\talk\service')
			->disableOriginalConstructor()
			->getMock();

		$eventListener = new \moonbird\talk\event\main_listener($service);

		$events = \moonbird\talk\event\main_listener::getSubscribedEvents();
		$this->assertEquals($events['core.submit_post_end'], 'submit_post_end');

		$service->expects($this->once())
			->method('submit_post')
			->with($this->equalTo(7));

		$event = new \phpbb\event\data(array('data' => array('post_id' => 7)));
		$eventListener->submit_post_end($event);
	}
}
