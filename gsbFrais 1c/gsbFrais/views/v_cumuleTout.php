<div id="contenu">
<form action="index.php?uc=cumulefraisvisiteurs&action=voirCumuleTout" method="post">
      <div class="corpsForm">
      <h2>Periode</h2>
      <p>
        <label for="lstMois" accesskey="n">Mois/Annee: </label>
        <select id="lstMois" name="lstMois">
            <?php
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['mois'];
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if($mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php
				}

			}

			?>
			</select>
		</p>
	</div>
	<div class="piedFrom">
		<p>
			<input id="ok" type="submit" value="Valider" />
			<iput id="annuler" type="reset" value="Effacer" />
		</p>
	</div>
</form>
