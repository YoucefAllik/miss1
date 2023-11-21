<div id="contenu">
    <form action="index.php?uc=cumulefraisvisiteurs&action=voirCumuleVisiteur" method="post">
        <div class="corpsForm">
            <h2>Visiteur</h2>
            <p>
                <label for="num" accesskey="n">Numéro: </label>
                <select id="num" name="numero">
                    <?php
                    foreach ($visiteurs as $unVisiteur)
                    {
                        ?>
                        <option selected value="<?php echo $unVisiteur['id'] ?>"><?php echo  $unVisiteur['id'] ?> </option>
                        <?php
                    }

                    ?>
                </select>
                </select>
            </p>
        </div>
        <div class="piedForm">
            <p>
                <input id="ok" type="submit" value="Valider" size="20" />
                <input id="annuler" type="reset" value="Effacer" size="20" />
            </p>
        </div>
    </form>
</div>