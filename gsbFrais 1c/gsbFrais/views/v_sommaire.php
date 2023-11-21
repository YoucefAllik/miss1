<!-- Division pour le sommaire -->
<nav class="menuLeft">
    <ul class="menu-ul">
        <li class="menu-item"><a href="index.php">retour</a></li>

        <li class="menu-item">
            Visiteur :<br>
            <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>
        </li>

        <li class="menu-item">
            <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes
                fiches de frais</a>
        </li>
        <li class="menu-item">
            <a href="index.php?uc=cumulefrais&action=cumulefrais" title="Consultation du cumule des frais">
                 cumule des frais</a>
        </li>
        <li class="menu-item">
            <a href="index.php?uc=fraisVisiteur&action=fraisVisiteur" title="Consultation du cumule des frais">
                 Frais du visiteur</a>
        </li>
        <li class="menu-item">
            <a href="index.php?uc=cumulefraismois&action=cumuleTout" title="Cumule frais mois">Cumule des frais par mois</a>
        </li>
        <li class="menu-item">
            <a href="index.php?uc=cumulefraisvisiteurs&action=cumuleVisiteur" title="Cumule frais visiteur">Cumule des frais du visiteur</a>
        </li>
        <li class="menu-item">
            <a href="index.php?uc=saisiefrais&action=saisieFrais" title="Saisir Frais">Saisir Frais</a>
        </li>
        <li class="menu-item">
            <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
        </li>
    </ul>
</nav>
<section class="content">


