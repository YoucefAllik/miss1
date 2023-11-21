<div id="contenu">
    <form action="index.php?uc=saisiefrais&action=getSaisieFrais" method="post">
        <div class="corpsForm">
            <h2>Saisie</h2>
            <p>
                <h3>Visiteur</h3>
                <label for="num" accesskey="n">Numéro: </label>
                <input type="text" id="num" name="num">
                </br>
                <h3>Période D'engagement: </h3>

                <label for="mois" accesskey="n">Mois (2 chiffres): </label>
                <input type="text" id="mois" name="mois">
                <label for="annee" accesskey="n">Année (4 chiffres): </label>
                <input type="text" id="annee" name="annee">
                </br>
                </br>
                </br>   
                <h2>Frais au Forfait</h2>
                </br>
                <h3>Repas Midi</h3>
                <label for="rm" accesskey="n">Repas Midi: </label>
                <input type="text" id="rm" name="rm" size="20">
                <label for="nui" accesskey="n">Nuitées: </label>
                <input type="text" id="nui" name="nui" size="20">
                <label for="etp" accesskey="n">Etape: </label>
                <input type="text" id="etp" name="etp" size="20">
                <label for="km" accesskey="n">Kilomètre : </label>
                <input type="text" id="km" name="km" size="20">
            </p>
            <div class="piedFrom">
            <p>
                <input id="ok" type="submit" value="Valider" />

            </p>
        </div>
    </form>
</div>