<?php

class Default_Model_Actualites extends Default_Model_AbstractBdd {

    const TABLE_NAME = "actualites";

    private function toFrMonth($date) {
        $mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        return $mois[date("n", strtotime($date))];
    }

    private function toFrDay($date) {
        $jour = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
        return $jour[date("w", strtotime($date))];
    }
	
	/**
     *
     * @return array Les actualités sous forme de tableau. Autant de ligne que
     *  d'actualités. 
     *  Chaque ligne contient quatre éléments : 
     *      - la description [description]
     *      - une date au format Lundi 14 Septembre 2014 à 19h30 [date]
     * 
     * Sachant que l'heure de fin peut être vide.
     */
    public function getAllActualites() {


        // connexion
        $connexion = $this->connect();

        $query = "select * from " . self::TABLE_NAME . " " .
                 " where date > now() " .
				 "ORDER BY date DESC, heureDebut DESC;";
        $result = mysql_query($query, $connexion);

        if ($result) {
            $i = 0;
            date_default_timezone_set('Europe/Paris');
            $actualites = array();
            while ($actualite = mysql_fetch_assoc($result)) {

                $actualites[$i]['id'] = $actualite['id'];
                $actualites[$i]['description'] = $actualite['description'];
                $actualites[$i]['titre'] = $actualite['titre'];
                $d = $actualite['date'];
                $actualites[$i]['date'] = $this->toFrDay($d)
                        . " "
                        . date("j", strtotime($d))
                        . " "
                        . $this->toFrMonth($d);

                $deb = $actualite['heureDebut'];
                $fin = $actualite['heureFin'];

                $actualites[$i]['longdate'] = $actualites[$i]['date'] 
                        . " " 
                        . date("Y", strtotime($d));

                // Uniquement l'heure de fin est rempli
                if (($fin !== "" && $fin !== null) && ($deb === "" || $deb === null)) {
                    $actualites[$i]['date'] .= " à " . $this->formatTime(fin);
                    $actualites[$i]['longdate'] .= " à " . $this->formatTime(fin);
                }

                // Uniquement l'heure de début est rempli
                if (($fin === "" || $fin === null) && ($deb !== "" && $deb !== null)) {
                    $actualites[$i]['date'] .= " à " . $this->formatTime($deb);
                    $actualites[$i]['longdate'] .= " à " . $this->formatTime($deb);
                }

                // Les deux heures sont remplies
                if (($fin !== "" && $fin !== null) && ($deb !== "" && $deb !== null)) {
                    $actualites[$i]['date'] .= " de " . $this->formatTime($deb) . " à " . $this->formatTime($fin);
                    $actualites[$i]['longdate'] .= " de " . $this->formatTime($deb) . " à " . $this->formatTime($fin);
                }

                // Rien à faire lorsque les deux heures sont vides
                                
                $i++;
            }
            // deco
            $this->deco($connexion);
            return $actualites;
        }

        // deco
        $this->deco($connexion);
    }

    /**
     *
     * @return array Les actualités sous forme de tableau. Autant de ligne que
     *  d'actualités. 
     *  Chaque ligne contient quatre éléments : 
     *      - la description [description]
     *      - une date au format Lundi 14 Septembre 2014 à 19h30 [date]
     * 
     * Sachant que l'heure de fin peut être vide.
     */
    public function getActualites() {


        // connexion
        $connexion = $this->connect();

        $query = "select * from " . self::TABLE_NAME . " " .
                 " where date > now() " .
				 "ORDER BY date asc, heureDebut asc LIMIT 2;";
        $result = mysql_query($query, $connexion);

        if ($result) {
            $i = 0;
            date_default_timezone_set('Europe/Paris');
            $actualites = array();
            while ($actualite = mysql_fetch_assoc($result)) {
				
				if ($i === 3)
					break;

                $actualites[$i]['id'] = $actualite['id'];
                $actualites[$i]['description'] = $actualite['description'];
                $actualites[$i]['titre'] = $actualite['titre'];
                $d = $actualite['date'];
                $actualites[$i]['date'] = $this->toFrDay($d)
                        . " "
                        . date("j", strtotime($d))
                        . " "
                        . $this->toFrMonth($d);

                $deb = $actualite['heureDebut'];
                $fin = $actualite['heureFin'];

                $actualites[$i]['longdate'] = $actualites[$i]['date'] 
                        . " " 
                        . date("Y", strtotime($d));

                // Uniquement l'heure de fin est rempli
                if (($fin !== "" && $fin !== null) && ($deb === "" || $deb === null)) {
                    $actualites[$i]['date'] .= " à " . $this->formatTime(fin);
                    $actualites[$i]['longdate'] .= " à " . $this->formatTime(fin);
                }

                // Uniquement l'heure de début est rempli
                if (($fin === "" || $fin === null) && ($deb !== "" && $deb !== null)) {
                    $actualites[$i]['date'] .= " à " . $this->formatTime($deb);
                    $actualites[$i]['longdate'] .= " à " . $this->formatTime($deb);
                }

                // Les deux heures sont remplies
                if (($fin !== "" && $fin !== null) && ($deb !== "" && $deb !== null)) {
                    $actualites[$i]['date'] .= " de " . $this->formatTime($deb) . " à " . $this->formatTime($fin);
                    $actualites[$i]['longdate'] .= " de " . $this->formatTime($deb) . " à " . $this->formatTime($fin);
                }

                // Rien à faire lorsque les deux heures sont vides
                                
                $i++;
            }
            // deco
            $this->deco($connexion);
            return $actualites;
        }

        // deco
        $this->deco($connexion);
    }

}

?>
