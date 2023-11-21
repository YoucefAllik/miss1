
<h3 class="align-center">Fiche du cumule des frais du visiteur : </h3>
    <div class="encadre">
  	<table class="listeLegere">
             <tr>
                <th class='mois'> Mois: </th>    
                <th class='montant'>Montant cumulé: </th> 

           
             </tr>
        <?php    foreach ( $montant as $unMontant ): ?>
            <tr>
            <td><?=$unMontant['mois']?></td>
              <td><?=$unMontant['somme']?></td>
           </tr>
           <?php endforeach?>
          
    </table>
  </div>
