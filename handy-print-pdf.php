<?php
/**
	* Plugin Name: Handy print & PDF
	* Plugin URI: http://www.rtmmedia.nl
	* Description: This plugin will add a print and pdf option button to your wordpress page.
	* Version: 1.0.0
	* Author: Mitch Rompelman
	* Author URI: http://www.rtmmedia.nl
	* License: GPL v2
 */

/*	
	Copyright (C) 2014  Mitch Rompelman

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

require_once('print-templates.php');
 
Class handyPrintPDF extends templates {
	// ------------------------------------------------------------------------ Consts.
	const WP_HEAD = 'wp_head';
	const WP_FOOTER = 'wp_footer';

	// -------------------------------------------------------------------- Vars.
	
    /**
     * The server name, used throughout to refer to plugin directory and more.
     * @var string
     */	
	private $servername;
	
    /**
     * The style path, used throughout to refer to plugin cascading style sheet directory.
     * @var string
     */	
	private $stylepath;	
	
    /**
     * The styles, used throughout to refer all the important cascading style sheets.
     * @var array
     */	
	private $styles = array(
		'Plugin first style' 	=> 'main.css',
	);
	
    /**
     * The javascript path, used throughout to refer to plugin javascript directory.
     * @var string
     */	
	private $javascriptpath;

    /**
     * The javascripts, used throughout to refer all the important javascripts.
     * @var array
     */	
	private $javascripts = array(
		'Plugin first javascript' 	=> 'print.js',
	);
	
    /**
     * The element name, used throughout to refer to the content body of the plugin.
     * @var string
     */
	private $element = 'content';

	
	private $print;
	
	// -------------------------------------------------------------------- Magic Methods.
	
	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct($a = null) {	
		$this->servername = 'http://' . strip_tags($_SERVER['SERVER_NAME']);
		// Add the plugin style.
		add_action( 'wp_head', array( &$this, 'pluginStyles' ) );
		// Add the plugin javascript.
		add_action( 'wp_head', array( &$this, 'pluginjavascripts' ) );
		// Add the body content.
		add_action( 'wp_footer', array( &$this, 'pluginBody' ) );
		
		add_action( 'wp_footer', array( &$this, 'test' ) );
		
		//$id = get_the_ID();
		//echo $id;
		//die();
		
		if(isset($_GET['print'])) {
			$this->print = strip_tags($_GET['print']);
			$this->print = trim($this->print);
			echo parent::printTemplate();
		}	
		// Add menu options in admin menu.
		add_action( 'admin_menu', array( &$this, 'my_plugin_menu' ) );
	}
	
    /**
     * Get the wordpress post ID.
     *
     * @since 1.0
     */		
	public function pluginPostId() {
        global $post;
        return $post->ID;
	}

	
    /**
     * Print the plugin cascading style sheets, in the header.
     *
     * @since 1.0
     */	
	public function pluginStyles() {
		?><!--- Handy print & pdf cascading style sheets ---><?php echo "\n";
		$this->stylepath = $this->servername . '/wp-content/plugins/' . basename( dirname( __FILE__ ) ) . '/package/style/';
		foreach($this->styles as $key => $a) {
			echo '<link rel="stylesheet" type="text/css" href="' . $this->stylepath . $a . '" />' . "\n";
		}
	}
	
    /**
     * Print the plugin javascripts, in the header.
     *
     * @since 1.0
     */
    public function pluginjavascripts() {
		?><!--- Handy print & pdf javascripts ---><?php echo "\n";
		$this->javascriptpath = $this->servername . '/wp-content/plugins/' . basename( dirname( __FILE__ ) ) . '/package/javascript/';
		foreach($this->javascripts as $key => $a) {
			echo '<script type="text/javascript" src="' . $this->javascriptpath . $a . '"></script>' . "\n";
		}
    }
	
    /**
     * Prints the plugins body, in the footer.
     *
     * @since 1.0
     */	
	public function pluginBody() {
		$pluginAdd = array ( 
			"<form method='get'>",
			"<input type='submit' value='" . $this->pluginPostId() . "' name='print'/>",
			"</form>",
		);
		echo '
		<script>
			var text = "' . implode('', $pluginAdd) . '";
			var div = document.getElementById("content");
			div.innerHTML += text;
		</script>';
	}
	
    /**
     * Creates menu, in the admin menu.
     *
     * @since 1.0
     */		
	public function my_plugin_menu() {
		add_options_page( 'Handy print & PDF Plugin Options', 'Handy print & PDF', 'manage_options', 'my-unique-identifier',  array( &$this, 'my_plugin_options' ) );
	}
	
    /**
     * Creates menu options, in the admin menu.
     *
     * @since 1.0
     */		
	public function my_plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		echo '<div class="wrap">';
		echo '<p>Still working on this!</p>';
		echo '</div>';
	}
	// -------------------------------------------------------------------- Private Functions.	
}

$handyppdf = new handyPrintPDF;

?>
