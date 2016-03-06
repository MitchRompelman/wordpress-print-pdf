<?php

require('pdf-class.php');
		
class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;

function PDF($orientation='P', $unit='mm', $size='A4')
{
    // Call parent constructor
    $this->FPDF($orientation,$unit,$size);
    // Initialization
    $this->B = 0;
    $this->I = 0;
    $this->U = 0;
    $this->HREF = '';
}

function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
}

$a = 'http://' . strip_tags($_SERVER['SERVER_NAME']);
$b = $a . '/wp-content/plugins/handy-print-pdf/package/images/';

function printGetContent($a = null) {
	$id = strip_tags($_GET['pdf']);
	$id = trim($id);
	$object_single_post = get_post($id);
	$title = '<b>' . $object_single_post->post_title . '</b><br>';
	$content = $object_single_post->post_content;
	$content = str_replace(array('<strong>', '</strong>'), array('<b>', '</b>') , $content);		
	$content = explode(PHP_EOL . PHP_EOL, $content);		
	$htmlcontent = '';
	$i = 0;
	foreach($content as $line){
		($i == 0? $htmlcontent .= $title : $htmlcontent .= '');
		$htmlcontent .= '<br>' . str_replace(PHP_EOL, '<br>' , $line) . '<br>';
		$i++;
	} 
	$test = $htmlcontent;	
	return $test;
}

$str = utf8_decode(printGetContent());
$html = $str;
$pdf = new PDF();

// First page.
$pdf->AddPage();
$pdf->SetFont('Arial','',20);
$pdf->SetLink($link);
$pdf->Image($b . 'logo.jpg',10,12,70,0,'','http://www.fpdf.org');
$pdf->Ln(30); // Line break
$pdf->SetLeftMargin(10);
$pdf->SetFontSize(14);
$pdf->WriteHTML($html);
$pdf->Output();

?>