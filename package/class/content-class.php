<?php
/**
 * @file
 * The plugin content viewer for on the website.
 *
 * This is the content for the plugin to show the options in the wordpress
 * website.
 *
 * Auhtor: Mitch Rompelman.
 * Date: 16-04-2014.
 * Date modified: 16-04-2014.
 * Time: 08:33:14.
 */
 
class content {
	// ------------------------------------------------------------------------ Consts.
	
    /**
     * The plugin name, used throughout to refer to plugin directory.
     * @var string
     */
	const PLUGIN = 'handy-print-pdf';
	
    /**
     * The image name, used throughout to refer to plugin directory package images.
     * @var string
     */
	const IMAGE_1 = 'print-icon.png';
	
    /**
     * The image name, used throughout to refer to plugin directory package images.
     * @var string
     */
	const IMAGE_2 = 'pdf-icon.png';
	
	// ------------------------------------------------------------------------ Vars.
	
    /**
     * The server name, used throughout to refer to plugin directory and more.
     * @var string
     */	
	private $a;
	
    /**
     * The image path, used throughout to refer to plugin images directory.
     * @var string
     */	
	private $b;
	
	// ------------------------------------------------------------------------ Magic Methods.
	
	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		// Do something for the plugin.
	}
	
	/**
	 * toString
	 *
	 * @since 1.0
	 * @see global main-class.php pluginBody()
	 */
	public function __toString() {
		return $this->createContent();
	}
	
	// ------------------------------------------------------------------------ Public Functions.
	
    /**
     * Get the wordpress post ID.
     *
     * @since 1.0
     */		
	public function WordpressPostId() {
        global $post;
        return $post->ID;
	}
	
	/**
	 * createContent
	 *
	 * @since 1.0
	 * @see global main-class.php pluginBody()
	 */		
	public function createContent() {
		$this->a = 'http://' . strip_tags($_SERVER['SERVER_NAME']);
		$this->b = $this->a . '/wp-content/plugins/handy-print-pdf/package/images/';	
		return array ( 
			"<div class='handy-print-holder'>",
				"<div class='handy-print-print'>",
					"<a href='?print=" . $this->WordpressPostId() . "'><img title='print' src='" . $this->b . self::IMAGE_1 . "' /></a>",
				"</div>",
				"<div class='handy-print-pdf'>",
					"<a href='?pdf=" . $this->WordpressPostId() . "'><img title='print-pdf' src='" . $this->b . self::IMAGE_2 . "' /></a>",
				"</div>",
			"</div>",
		);	
	}
}

$pluginContent = new content;
