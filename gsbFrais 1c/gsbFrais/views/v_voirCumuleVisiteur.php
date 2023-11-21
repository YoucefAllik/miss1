<?php include_once 'v_cumuleVisiteur.php';?>
<h3 class="align-center">Fiche du cumule des frais du visiteur: </h3>
<div class="encadre">
    <table class="listeLegere">
        <tr>
            <th class='montant'>ETP</th>
            <th class='montant'>KM</th>
            <th class='montant'>NUI</th>
            <th class='montant'>REP</th>
        </tr>
        <tr>
            <?php foreach($etp as $etp): ?>
                <td><?=$etp['somme']?></td>
            <?php endforeach?>
            <?php foreach($km as $km): ?>
                <td><?=$km['somme']?></td>
            <?php endforeach?>
            <?php foreach($nui as $nui): ?>
                <td><?=$nui['somme']?></td>
            <?php endforeach?>
            <?php foreach($rep as $rep): ?>
                <td><?=$rep['somme']?></td>
            <?php endforeach?>
        </tr>
    </table>
</div>
