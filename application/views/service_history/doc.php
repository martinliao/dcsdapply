<?php
header('Content-type: application/doc');
header('Content-Type: text/html; charset=utf-8');
header("Content-Disposition: attachment;Filename=service_history.doc");
?>

<html
xmlns:o='urn:schemas-microsoft-com:office:office'
xmlns:w='urn:schemas-microsoft-com:office:word'
xmlns='http://www.w3.org/TR/REC-html40'>
<head><title></title>

<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:View>Print</w:View>
  <w:Zoom>90</w:Zoom>
</w:WordDocument>
</xml><![endif]-->


<style>
p.MsoFooter, li.MsoFooter, div.MsoFooter
{
    margin:0in;
    margin-bottom:.0001pt;
    mso-pagination:widow-orphan;
    tab-stops:center 3.0in right 6.0in;
    font-size:12.0pt;
}
	<style>
	<!-- /* Style Definitions */

	@page Section1
	{
		mso-page-orientation:portrait;
		margin:1.27cm 1.27cm 1.27cm 1.27cm;
		mso-header-margin:42.55pt;
		mso-footer-margin:49.6pt;
	    mso-title-page:yes;
	    mso-header: h1;
	    mso-footer: f1;
	    mso-first-header: h1;
	    mso-first-footer: f1;
	    mso-paper-source:0;
	}

	div.Section1
	{
	    page:Section1;
	}

	table#hrdftrtbl
	{
	    margin:0in 0in 0in 900in;
	    width:1px;
	    height:1px;
	    overflow:hidden;
	}

			table,h1,h2
			{
				position:relative;
			    border-collapse:collapse;
			    /*border: 1px solid black; border-collapse: collapse;*/
				left:4.5cm;
				font-family: DFKai-sb;
			}
			td,tr{
		    /*border: 1px solid black;*/
		        padding:0 0 0 0;
				font-family: DFKai-sb;
			}
			/*分散對齊*/
			div.disperse{
		　　text-align:justify;text-justify:distribute-all-lines;text-align-last:justify
			}
			.must_border{
				border: 1px solid black; border-collapse: collapse;
			}
			.must_border td{
				border: 1px solid black;
			}

	-->
	</style>
</head>

	<body lang=EN-US style='tab-interval:.5in'>
		<div class=Section1>
			<?php 
				echo $table;
			?>
		</div>
	</body>
</html>