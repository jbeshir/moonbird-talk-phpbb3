<?php
/**
 *
 * Moonbird Talk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, John Beshir, https://moonbird.io
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace moonbird\talk\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Moonbird Talk Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return array(
			'core.submit_post_end'	=> 'submit_post_end',
		);
	}

	/**
	 * @var \moonbird\talk\service $service
	 */
	protected $service;

	/**
	 * Constructor
	 * @param \moonbird\talk\service $service Service object
	 */
	public function __construct($service)
	{
		$this->service = $service;
	}

	/**
	 * A sample PHP event
	 * Modifies the names of the forums on index
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function submit_post_end($event)
	{
		$post_id = $event['data']['post_id'];
		$this->service->submit_post($post_id);
	}
}
