<?php
session_start();

include 'includes/conn.php';
if (isset($_SESSION['admin'])) {
	header('location: admin/home.php');
}

if (isset($_SESSION['voter'])) {
	header('location: home.php');
}
?>
<?php include 'includes/header.php'; ?>




<style>
	.vote-results {
		margin-left: 35px;
	}

	.login-box {
		width: 380px;
		margin: 0 auto;
	}

	.login-logo h1,
	.vote-results h1 {

		margin-top: 100px;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 50px;
		font-weight: 700;
	}

	.vote-results .results ul {
		list-style: none;
		margin-left: 0;
		padding-left: 0;
		font-size: 18px;
	}

	.vote-results .results ul li {
		margin-bottom: 30px;
	}

</style>


<body class="hold-transition login-page">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="vote-results">
					<h1>Vote results</h1>
					<div class="results">
					<?php
						$positionSQL = 'SELECT * FROM positions ORDER BY positions.priority';
						$positionQuery = $conn->query($positionSQL);
						?>
						<ul>
							<?php while ($positionRow = $positionQuery->fetch_assoc()) : ?>
								<li>
									<h3><strong><?php echo $positionRow['description']?></strong></h3>
									<?php 
										$voteSQL = "SELECT *, positions.description, count(votes.voters_id) as vote_count FROM candidates
																INNER JOIN positions ON positions.id = candidates.position_id
																LEFT JOIN votes ON votes.candidate_id = candidates.id
																WHERE positions.id = " . $positionRow['id'] . "
																GROUP BY candidates.id";

										$voteQuery = $conn->query($voteSQL);
									?>

									<?php while($voterRow = $voteQuery->fetch_assoc() ): ?>
										<p><?php echo $voterRow['firstname'] . " " . $voterRow['lastname']  ?> - <?php echo $voterRow['vote_count'] ?></p>
									<?php endwhile ?>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="login-box">
					<div class="login-logo">
						<h1>NCC STUDENT COUNCIL VOTING SYSTEM</h1>
					</div>

					<div class="login-box-body">
						<h4 class="login-box-msg">Sign in to start your session</h4>

						<form action="login.php" method="POST">
							<div class="form-group has-feedback">
								<input type="text" class="form-control" name="voter" placeholder="Voter's ID" required>
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="password" class="form-control" name="password" placeholder="Password" required>
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="row">
								<div class="col-xs-4">
									<button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<?php
			if (isset($_SESSION['error'])) {
				echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>" . $_SESSION['error'] . "</p> 
			  	</div>
  			";
				unset($_SESSION['error']);
			}
			?>
		</div>
	</div>


	<?php include 'includes/scripts.php' ?>
</body>

</html>