<?php


Class templates {
	// ------------------------------------------------------------------------ Consts.
	const PLUGIN = 'handy-print-pdf';
	const EXTENSION = 'jpg'; 
	const LOGO = 'logo';
	const HEADER = 'header';
	const FOOTER = 'footer';
	const TITLE = 'Print';
	
	// ------------------------------------------------------------------------ Vars.
	
    /**
     * The server name, used throughout to refer to plugin directory and more.
     * @var string
     */	
	private $servername;
	
    /**
     * The styles, used throughout to refer all the important cascading style sheets.
     * @var string
     */	
	private $style;
	
    /**
     * The Wordpress post content, with get post-id.
     * @var string
     */		
	private $content;
	
    /**
     * The Wordpress post-id.
     * @var integer
     */		
	private $id;
	
    /**
     * The plgin path.
     * @var integer
     */		
	private $path;
	
	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		// Doe wat.
	}
	
	// ------------------------------------------------------------------------ Public functions.
	
    /**
     * Will get the worpdpress content, with the get post-id.
     *
     * @since 1.0
     */	
	public function printGetContent($a = null) {
		// -----------------------------------------------------
		$this->id = strip_tags($_GET['print']);
		$this->id = trim($this->id);
		//$this->content = get_post_field('post_content', $this->id);
		//return print_r($this->content);
		// -----------------------------------------------------
		// $post_7 = get_post($this->id, ARRAY_A);
		// $title = $post_7['post_title'];
		// $content = $post_7['post_content'];
		// $content = str_replace( '<br>', '<p>', $content );
		// -----------------------------------------------------	
		$object_single_post = get_post($this->id);
		$title = '<h1>' . $object_single_post->post_title . '</h1>';
		$content = $object_single_post->post_content;		
		$content = explode(PHP_EOL . PHP_EOL, $content);		
		$htmlcontent = '';
		$i = 0;
		foreach($content as $line){
			($i == 0? $htmlcontent .= $title : $htmlcontent .= '');
			$htmlcontent .= '<p>' . str_replace(PHP_EOL, '<br />' , $line) . '</p>';
			$i++;
		} 
		$this->content = $htmlcontent;	
		return $this->content;
	}
	
    /**
     * Will return the print layout.
     *
     * @since 1.0
	 * @see main-class __construct()
     */		
	public function printTemplate() {
		$this->servername = 'http://' . strip_tags($_SERVER['SERVER_NAME']);
		$this->path = $this->servername . '/wp-content/plugins/' . self::PLUGIN;
		$this->style = $this->path . '/package/style/print.css';
		?>
			<!DOCTYPE html>
				<html>
					<head>
						<meta charset="UTF-8" />
						<?php echo '<link rel="stylesheet" type="text/css" href="' . $this->style . '"/>' . "\n"; ?>
						<?php echo '<link rel="stylesheet" type="text/css" href="' . $this->style . '" media="print"/>' . "\n"; ?>
						<title><?php echo self::TITLE ?></title>
					</head>
						<body onload="timer = setTimeout('window.print()',1000)">
							<div class="print-holder">
								<div class="print-logo-holder">
									<img src="<?php echo $this->path . '/package/images/' . self::LOGO . '.' . self::EXTENSION; ?>" />
								</div>
								<div class="print-header-holder">
									<img src="<?php echo $this->path . '/package/images/' . self::HEADER . '.' . self::EXTENSION; ?>" />
								</div>						
								<?php echo $this->printGetContent(); ?>
								<div class="print-footer-holder">
									<img src="<?php echo $this->path . '/package/images/' . self::FOOTER . '.' . self::EXTENSION; ?>" />
								</div>
							</div>
						</body>
				</html>	
		<?php
		return $this;
	}
	
    /**
     * Will return the print pdf layout.
     *
     * @since 1.0
	 * @see main-class __construct()
     */		
	public function pdfTemplate() {
	}
}
?>
