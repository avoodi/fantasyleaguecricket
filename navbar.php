<nav class="navbar fixed-top navbar-expand-lg bg-white">
		<div class="container">
			<a class="navbar-brand text-danger" href="teamLandingPg.php"> <strong> <em> Fantasy League Cricket </em></strong></a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon text-danger"> Menu </span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link text-danger" href="PlayersListForBidding.php">Bidding</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-danger" href="ViewYourTeam.php">Your Team</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-danger" href="#" id="navbarDropdownLeague" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							League
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownLeague">
							<? if ($isOwner=='No') {?>
								<a class="dropdown-item text-danger" href="LeagueRulesView.php">League Rules</a>
							<? } ?>

							<? if ($isOwner=='Yes') { ?>
								<a class="dropdown-item text-danger" href="LeagueRules.php">League Rules</a>
							<? } ?>
							<a class="dropdown-item text-danger" href="#" onclick="call_leaguestanding()">League Standing </a>
							<a class="dropdown-item text-danger" href="ShowLeagueDraws.php">League Schedule(draws)</a>
						</div>
					</li>
					

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-danger" href="#" id="navbarDropdownPlayer" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							Players
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPlayer">
							<a class="dropdown-item text-danger" href="PlayerPurchaseAfterBiddingOver.php">Player Purchase</a>
							<a class="dropdown-item text-danger" href="Sellplayer.php">Player Sell</a>
							<a class="dropdown-item text-danger" href="viewallplayersperf.php">All Players performance</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>