﻿<?php
// newsindex Make P100 carousel, P101 headlines, P102 index.
// Run after newsreader.php
// WARNING! There are hidden characters in this text that your editor may treat as whitespace.
// If you take them out then the page formatting may be disrupted.
// I used Notepad++ switched to Encoding-UTF8 in order to create this.
include "simple_html_dom.php";

function writeHeader()
{
	echo "DS,inserter\r\n";
	echo "SP,c:\Minited\inserter\ONAIR\P100.tti\r\n";
	echo "DE,Read back page  20/11/07\r\n";
	echo "CT,8,T\r\n";
}

// CEEFAX P100
function writePage($ss)
{
	printf("PN,100%02d\r\n",$ss);
	printf("SC,%04d\r\n",$ss);
	echo "PS,8000\r\n";
	echo "MS,0\r\n";
	echo "OL,0,XXXXXXXXCEEFAX 1 mpp DAY dd MTH hh:nn/ss\r\n"; // An inserter will not use row 0, but wxTED and Muttlee do.
	echo "OL,1,�`ppp`ppp`ppp�||,,,<,,<,,<,,|,,,|,l<,|||\r\n";
	echo 'OL,2,�j $zj $zj tz���7#jsjsjshs4ouz?� '."\r\n";
	echo "OL,3,�j %jj %jj 'k���upjpjpj j 55j� \r\n";
	echo "OL,4,�\"###\"###\"###�##########################\r\n";
	echo "OL,5,�News                                   \r\n";
	//echo "OL,6,�BENEFITS DATA ON 25m PEOPLE MISSING�104\r\n";
	//echo "OL,7,                                        \r\n";
	echo "OL,8,�```````````````````````````````````````\r\n";
	echo "OL,9,�A-Z INDEX     �199�NEWS HEADLINES  �101\r\n";
	echo "OL,10,�BBC INFO      �695�NEWS FOR REGION �160\r\n";
	echo "OL,11,�CHESS         �568�NEWSROUND       �570\r\n";
	echo "OL,12,�COMMUNITY�BBC2�650�RADIO      �BBC1�640\r\n";
	echo "OL,13,�ENTERTAINMENT �500�READ HEAR  �BBC2�640\r\n";
	echo "OL,14,�                                       \r\n";
	echo "OL,15,�FILM REVIEWS  �526�SPORT           �300\r\n";
	echo "OL,16,�FINANCE�  BBC2�200�SUBTITLING      �888\r\n";
	echo "OL,17,�FLIGHTS       �440�TOP 40          �528\r\n";
	echo "OL,18,�GAMES REVIEWS �527�TRAVEL          �430\r\n";
	echo "OL,19,�HORSERACING   �660�TV LINKS        �615\r\n";
	echo "OL,20,�LOTTERY       �555�TV LISTINGS     �600\r\n";
	echo "OL,21,�SCI-TECH      �154�WEATHER         �400\r\n";
	echo "OL,22,                                        \r\n";
	echo "OL,23,���Ceefax: The world at your fingertips \r\n";
	echo "OL,24,�Headlines  �Sport  �West TV �A-Z Index \r\n";
}
$count=20;	// Number of pages in P100
$mpp="10000";
writeHeader();
for ($i=0;$i<$count;$i++)
{
	$page="page$i.html";		// The default input name
	$html = file_get_html($page);	// Get the whole file

	//echo $page."\r\n";
	//$cat= $html->find('meta[property=og:type]');	// Category of story
	//echo "stuff=".$cat[0]->content."\r\n";

	//$cat= $html->find('meta[name=Headline]');	// Category of story
	if (is_object($html))
	{
		$cat= $html->find('title');	// Category of story
		$headline=	htmlspecialchars_decode ($cat[0]->plaintext,ENT_QUOTES);		// Decode html entities	
	//	echo "headline=$headline\r\n";
		writePage($i);
		$headline=substr(trim($headline),0,36);
		if (strlen($headline<36))
		{
			$headline=substr(str_pad($headline,35),0,35);
			$headline.='�';
			
		}
		printf("OL,6,%c%35s%3d\r\n",(0x0d+0x80),strtoupper($headline),104+$i); // Double height headline
	}
	else
		printf("DE,Had a spot of bother with page:".$page."\r\n"); 
}
echo "FL,102,300,160,199,F,100\r\n";
?>