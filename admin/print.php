<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print</title>

	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	<style>
		/* @page {
			margin-top: 2cm;
			margin-bottom: 2cm;
			margin-left: 2cm;
			margin-right: 2cm;
		} */

		@page {
			size: auto;
			margin: 0mm;
		}

		#print {
			display: none;
		}

		.results ul {
			list-style: none;
			margin-left: 0;
			padding-left: 0;
			font-size: 18px;
		}

		.results ul li {
			margin-bottom: 30px;
		}

		h1{
			margin-bottom: 4rem;
		}

		@media print {
			#print {
				margin-top: 2cm;
				margin-bottom: 2cm;
				margin-left: 2cm;
				margin-right: 2cm;
				display: block;
			}
		}
	</style>

</head>

<body>
	<div id="print">
		<h1 class="text-center">Northeastern Cebu Colleges, Inc.<br>
			Supreme Student Council</h1>
		<h2 class="text-center">Vote Results</h2>
		<div class="results">
			<?php
			$positionSQL = 'SELECT * FROM positions ORDER BY positions.priority';
			$positionQuery = $conn->query($positionSQL);
			?>
			<ul>
				<?php while ($positionRow = $positionQuery->fetch_assoc()) : ?>
					<li>
						<h3><strong><?php echo $positionRow['description'] ?></strong></h3>
						<?php
						$voteSQL = "SELECT *, positions.description, count(votes.voters_id) as vote_count FROM candidates
																INNER JOIN positions ON positions.id = candidates.position_id
																LEFT JOIN votes ON votes.candidate_id = candidates.id
																WHERE positions.id = " . $positionRow['id'] . "
																GROUP BY candidates.id";

						$voteQuery = $conn->query($voteSQL);
						?>

						<?php while ($voterRow = $voteQuery->fetch_assoc()) : ?>
							<p><?php echo $voterRow['firstname'] . " " . $voterRow['lastname']  ?> - <?php echo $voterRow['vote_count'] ?></p>
						<?php endwhile ?>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>


	<script>
		window.print();
		close();
	</script>
</body>

</html>




<?php //backup------------------------------------------------------------------------------ 
// function generateRow($conn){
// 	$contents = '';

// 	$sql = "SELECT * FROM positions ORDER BY priority ASC";
//       $query = $conn->query($sql);
//       while($row = $query->fetch_assoc()){
//       	$id = $row['id'];
//       	$contents .= '
//       		<tr>
//       			<td colspan="2" align="center" style="font-size:15px;"><b>'.$row['description'].'</b></td>
//       		</tr>
//       		<tr>
//       			<td width="80%"><b>Candidates</b></td>
//       			<td width="20%"><b>Votes</b></td>
//       		</tr>
//       	';

//       	$sql = "SELECT * FROM candidates WHERE position_id = '$id' ORDER BY lastname ASC";
//   		$cquery = $conn->query($sql);
//   		while($crow = $cquery->fetch_assoc()){
//   			$sql = "SELECT * FROM votes WHERE candidate_id = '".$crow['id']."'";
//     			$vquery = $conn->query($sql);
//     			$votes = $vquery->num_rows;

//     			$contents .= '
//     				<tr>
//     					<td>'.$crow['lastname'].", ".$crow['firstname'].'</td>
//     					<td>'.$votes.'</td>
//     				</tr>
//     			';

//   		}

//       }

// 	return $contents;
// }

//echo generateRow($conn);

// $parse = parse_ini_file('config.ini', FALSE, INI_SCANNER_RAW);
//   $title = $parse['election_title'];

// require_once('../tcpdf/tcpdf.php');  
//   $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
//   $pdf->SetCreator(PDF_CREATOR);  
//   $pdf->SetTitle('Result: '.$title);  
//   $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
//   $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
//   $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
//   $pdf->SetDefaultMonospacedFont('helvetica');  
//   $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
//   $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
//   $pdf->setPrintHeader(false);  
//   $pdf->setPrintFooter(false);  
//   $pdf->SetAutoPageBreak(TRUE, 10);  
//   $pdf->SetFont('helvetica', '', 11);  
//   $pdf->AddPage();  
//   $content = '';  
//   $content .= '
//     	<h2 align="center">'.$title.'</h2>
//     	<h4 align="center">Tally Result</h4>
//     	<table border="1" cellspacing="0" cellpadding="3">  
//     ';  
//  	$content .= generateRow($conn);  
//   $content .= '</table>';  
//   $pdf->writeHTML($content);  
//   $pdf->Output('election_result.pdf', 'I');

?>