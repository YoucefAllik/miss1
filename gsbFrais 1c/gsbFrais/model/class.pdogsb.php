<?php
/**
 * Classe d'accès aux données.

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoGsb qui contiendra l'unique instance de la classe

 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbfrais';
      	private static $user='root' ;
      	private static $mdp='' ;
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     * @return null L'unique objet de la classe PdoGsb
     */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;
	}

    /**
     * Retourne les informations d'un visiteur
     * @param $login
     * @param $mdp
     * @return mixed L'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosVisiteur($login, $mdp){
        $req = "select id, nom, prenom from visiteur where login='$login' and mdp='$mdp'";
        $rs = PdoGsb::$monPdo->query($req);
        $ligne = $rs->fetch();
        return $ligne;
    }

    /**
     * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
     
    * @param $madate au format  jj/mm/aaaa
    * @return la date au format anglais aaaa-mm-jj
    */
    public function dateAnglaisVersFrancais($maDate){
        @list($annee,$mois,$jour)=explode('-',$maDate);
        $date="$jour"."/".$mois."/".$annee;
        return $date;
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
     * concernées par les deux arguments
     * La boucle foreach ne peut être utilisée ici, car on procède
     * à une modification de la structure itérée - transformation du champ date-
     * @param $idVisiteur
     * @param $mois 'sous la forme aaaamm
     * @return array 'Tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur,$mois){
        $req = "select * from lignefraishorsforfait where idvisiteur ='$idVisiteur' 
		and mois = '$mois' ";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        $nbLignes = count($lesLignes);
        for ($i=0; $i<$nbLignes; $i++){
            $date = $lesLignes[$i]['date'];
            //Gestion des dates
            @list($annee,$mois,$jour) = explode('-',$date);
            $dateStr = "$jour"."/".$mois."/".$annee;
            $lesLignes[$i]['date'] = $dateStr;
        }
        return $lesLignes;
    }


    /**
     * Retourne les mois pour lesquels, un visiteur a une fiche de frais
     * @param $idVisiteur
     * @return array 'Un tableau associatif de clé un mois - aaaamm - et de valeurs l'année et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur){
        $req = "select mois from  fichefrais where idvisiteur ='$idVisiteur' order by mois desc ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois =array();
        $laLigne = $res->fetch();
        while($laLigne != null)	{
            $mois = $laLigne['mois'];
            $numAnnee =substr( $mois,0,4);
            $numMois =substr( $mois,4,2);
            $lesMois["$mois"]=array(
                "mois"=>"$mois",
                "numAnnee"  => "$numAnnee",
                "numMois"  => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donn�
     * @param $idVisiteur
     * @param $mois 'sous la forme aaaamm
     * @return mixed 'Un tableau avec des champs de jointure entre une fiche de frais et la ligne d'�tat
     */
    public function getLesInfosFicheFrais($idVisiteur,$mois){
        $req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
			where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function getCumuleEtatFrais($idVisiteur,$mois,$idFraisForfait){
        $req = "SELECT li.idVisiteur,li.idFraisForfait,li.mois,v.nom, v.prenom, li.quantite * ff.montant as somme 
        from visiteur v 
        INNER JOIN fichefrais fi on fi.idVisiteur = v.id 
        INNER JOIN lignefraisforfait li on li.idVisiteur = v.id and li.mois = fi.mois 
        INNER JOIN fraisforfait ff on ff.id = li.idFraisForfait 
        WHERE v.id = '$idVisiteur' and fi.mois = '$mois' and ff.id='$idFraisForfait'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function getFraisVisiteur($idVisiteur,$idFraisForfait){
        $req = "SELECT li.mois,v.nom, v.prenom, li.quantite * ff.montant as somme 
        from visiteur v INNER JOIN fichefrais fi on fi.idVisiteur = v.id 
        INNER JOIN lignefraisforfait li on li.idVisiteur = v.id and li.mois = fi.mois 
        INNER JOIN fraisforfait ff on ff.id = li.idFraisForfait 
        WHERE v.id = '$idVisiteur' and ff.id='$idFraisForfait';";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();

        return $laLigne;
    }

    public function getTypeDeFrais(){
        $req = "SELECT id from fraisforfait";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function getIdVisiteur(){
        $req = "SELECT id from visiteur";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function getCumuleTout($idVisiteur,$mois,$idFraisForfait){
        $req = "SELECT li.idVisiteur,li.idFraisForfait,li.mois,v.nom,v.prenom, li.quantite*ff.montant as somme
        FROM visiteur v
        INNER JOIN fichefrais fi on fi.idVisiteur = v.id
        INNER JOIN lignefraisforfait li on li.idVisiteur = v.id and li.mois = fi.mois
        INNER JOIN fraisforfait ff on ff.id = li.idfraisforfait
        WHERE v.id = '$idVisiteur' and fi.mois = '$mois' and ff.id='$idFraisForfait'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function getCumuleVisiteur($idVisiteur,$idFraisForfait){
        $req = "SELECT SUM(quantite) * fraisforfait.montant as somme FROM lignefraisforfait 
        INNER JOIN fraisforfait on idFraisForfait = id 
        where idVisiteur = '$idVisiteur' and fraisforfait.id = '$idFraisForfait'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }

    public function saisirFrais($visitor,$mois,$idFraisForfait,$quantite){
        $req ="INSERT INTO lignefraisforfait('idVisiteur', 'mois', 'idFraisForfait', 'quantite') VALUES ('$visitor', $mois, '$idFraisForfait', $quantite)";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;
    }
        
    public function getSaisirFrais($visitor,$mois){
        $req ="INSERT INTO `fichefrais`(`idVisiteur`, `mois`) VALUES ('$visitor','$mois')";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetchAll();
        return $laLigne;

    }



}

