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
			'core.user_setup'							=> 'load_language_on_setup',
	'core.display_forums_modify_template_vars'	=> 'display_forums_modify_template_vars',
		);
	}

	/* @var \phpbb\language\language */
	protected $language;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language	$language	Language object
	 */
	public function __construct(\phpbb\language\language $language)
	{
		$this->language = $language;
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'moonbird/talk',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * A sample PHP event
	 * Modifies the names of the forums on index
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function display_forums_modify_template_vars($event)
	{
		$forum_row = $event['forum_row'];
		$forum_row['FORUM_NAME'] .= $this->language->lang('TALK_EVENT');
		$event['forum_row'] = $forum_row;
	}
}
