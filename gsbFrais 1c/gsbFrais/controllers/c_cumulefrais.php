<?php
/** @var PdoGsb $pdo */
include 'views/v_sommaire.php';
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste,
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		include("views/v_listeMois.php");
		break;
	}
	case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		include("views/v_listeMois.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		
		//Gestion des dates
		@list($annee,$mois,$jour) = explode('-',$dateModif);
		$dateModif = "$jour"."/".$mois."/".$annee;

		//$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("views/v_etatFrais.php");
	}
	
    case 'cumulefrais':{
		$typeFrais=$pdo->getTypeDeFrais();
		//$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		//$moisASelectionner = $leMois;
		include("views/v_cumulefrais.php");
		break;
	}

	case 'voirCumuleFrais':{
		$typeFrais=$pdo->getTypeDeFrais();
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		//$moisASelectionner = $leMois;
		include("views/v_cumulefrais.php");
		$idFraisForfait=$_REQUEST['tfrais'];
		$mois = $_REQUEST['lstMois'];
		//$idFraisForfait=$pdo->getTypeDeFrais();
		$montant=$pdo->getCumuleEtatFrais($idVisiteur,$mois,$idFraisForfait);
		//$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("views/v_voirCumuleFrais.php");
		break;
	}

	case 'fraisVisiteur':{
		$visiteurs=$pdo->getIdVisiteur();
		//$leVisiteur=$_REQUEST['numero'];
		$typeFrais=$pdo->getTypeDeFrais();
		//$moisASelectionner = $leMois;
		include("views/v_fraisVisiteur.php");
		break;
	}

	case 'voirFraisVisiteur':{
		$visiteurs=$pdo->getIdVisiteur();
		$leVisiteur=$_REQUEST['numero'];
		$typeFrais=$pdo->getTypeDeFrais();
		//$moisASelectionner = $leMois;
		include("views/v_fraisVisiteur.php");
		$idFraisForfait=$_REQUEST['tfrais'];
		//$mois = $_REQUEST['lstMois'];
		//$idFraisForfait=$pdo->getTypeDeFrais();
		$montant=$pdo->getFraisVisiteur($idVisiteur,$idFraisForfait);
		//$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("views/v_voirFraisVisiteur.php");
		break;
	}

	case 'cumuleTout':{
		$typeFrais=$pdo->getTypeDeFrais();
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		include("views/v_cumuleTout.php");
		break;
	}


	case 'voirCumuleTout':{
		$typeFrais=$pdo->getTypeDeFrais();
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		include("views/v_cumuleTout.php");
		$mois = $_REQUEST['lstMois'];
		$idFraisForfait='ETP';
		$etp=$pdo->getCumuleTout($idVisiteur,$mois,$idFraisForfait);
		$idFraisForfait='KM';
		$km=$pdo->getCumuleTout($idVisiteur,$mois,$idFraisForfait);
		$idFraisForfait='NUI';
		$nui=$pdo->getCumuleTout($idVisiteur,$mois,$idFraisForfait);
		$idFraisForfait='REP';
		$rep=$pdo->getCumuleTout($idVisiteur,$mois,$idFraisForfait);
		include("views/v_voirCumuleTout.php");
		break;

	}

    case 'cumuleVisiteur':{
        $visiteurs=$pdo->getIdVisiteur();
        $typeFrais=$pdo->getTypeDeFrais();
        include("views/v_cumuleVisiteur.php");
        break;
    }

    case 'voirCumuleVisiteur':{
        $visiteurs=$pdo->getIdVisiteur();
        $leVisiteur=$_REQUEST['numero'];
        $typeFrais=$pdo->getTypeDeFrais();
        include("views/v_cumuleVisiteur.php");
        $idFraisForfait='ETP';
        $etp=$pdo->getCumuleVisiteur($idVisiteur,$idFraisForfait);
        $idFraisForfait='KM';
        $km=$pdo->getCumuleVisiteur($idVisiteur,$idFraisForfait);
        $idFraisForfait='NUI';
        $nui=$pdo->getCumuleVisiteur($idVisiteur,$idFraisForfait);
        $idFraisForfait='REP';
        $rep=$pdo->getCumuleVisiteur($idVisiteur,$idFraisForfait);
        include("views/v_voirCumuleVisiteur.php");
        break;

    }

	case 'saisieFrais':{
		$visiteurs=$pdo->getIdVisiteur();
		include("views/v_saisieFrais.php");
		break;
	}

	case 'getSaisieFrais' :{
		$visiteurs=$pdo->getIdVisiteur();
		$visitor = $_REQUEST['num'];
		$m = $_REQUEST['mois'];
		$annee = $_REQUEST['annee'];
		$rm = $_REQUEST['rm'];
		$nui = $_REQUEST['nui'];
		$etp = $_REQUEST['etp'];
		$km = $_REQUEST['km'];
		$mois = $annee.$m;
		$idFraisForfait = "";
		$quantite =" ";

		$si=$pdo->getSaisirFrais($visitor,$mois);
		if($rm != ''){
			$idFraisForfait ='REP';
			$quantite = $rm;
			$rep=$pdo->saisirFrais($visitor,$mois,$idFraisForfait,$quantite);
		}
		if($nui != ''){
			$idFraisForfait ='NUI';
			$quantite = $nui;
			$rep=$pdo->saisirFrais($visitor,$mois,$idFraisForfait,$quantite);
		}
		if($etp != ''){
			$idFraisForfait ='ETP';
			$quantite = $etp;
			$rep=$pdo->saisirFrais($visitor,$mois,$idFraisForfait,$quantite);
		}
		if($km != ''){
			$idFraisForfait ='KM';
			$quantite = $km;
			$rep=$pdo->saisirFrais($visitor,$mois,$idFraisForfait,$quantite);
		}
		include("views/v_voirSaisieFrais.php");
		break;
	}


}
