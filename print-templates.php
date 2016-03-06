<?php
Class templates {

	// ------------------------------------------------------------------------ Vars.
    /**
     * The server name, used throughout to refer to plugin directory and more.
     * @var string
     */	
	private $servername;
	
    /**
     * The styles, used throughout to refer all the important cascading style sheets.
     * @var array
     */	
	private $style;
	
	private $content;
	
	private $id;

	public function __construct() {
		// Doe wat.
	}
	
	// ------------------------------------------------------------------------ Public functions.
	
	public function printGetContent($a = null) {
		$this->id = strip_tags($_GET['print']);
		$this->id = trim($this->id);
		$this->content = get_post_field('post_content', $this->id);
		return $this->content;
	}
	
	
	public function printTemplate() {
		$this->servername = 'http://' . strip_tags($_SERVER['SERVER_NAME']);
		$this->style = $this->servername . '/wp-content/plugins/handy-print-pdf/package/style/print.css';
		?>
			<!DOCTYPE html>
				<html>
					<head>
						<?php echo '<link rel="stylesheet" type="text/css" href="' . $this->style . '"/>' . "\n"; ?>
						<?php echo '<link rel="stylesheet" type="text/css" href="' . $this->style . '" media="print"/>' . "\n"; ?>
						<title>TEST PRINT</title>
					</head>
						<body>
							<div class="print-holder">
								<?php echo $this->printGetContent(); ?>
							</div>
						</body>
				</html>	
		<?php
		return $this;
	}

}
?>
