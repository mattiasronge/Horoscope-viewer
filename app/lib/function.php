<?php
class Horoscope{
 
    // database connection and table ID
    private $conn;
    private $table_ID = "scope";
 
    // object properties
    public $id;
    public $ID;
    public $description;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read horoscope
    function read(){
     
        // select all query
        $query = "SELECT * FROM " . $this->table_ID . " ORDER BY created DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

     // create horoscope
    function create(){
     
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_ID . "
                SET
                    ID=:ID, dateFrom=:dateFrom, dateUntil=:dateUntil, horoscopeSign=:horoscopeSign, description=:description, created=:created";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->ID=htmlspecialchars(strip_tags($this->ID));
        $this->dateFrom=$this->dateFrom;
        $this->dateUntil=$this->dateUntil;
        $this->horoscopeSign=$this->horoscopeSign;
        $this->description=$this->description;
        $this->created=htmlspecialchars(strip_tags($this->created));
     
        // bind values
        $stmt->bindParam(":ID", $this->ID);
        $stmt->bindParam(":dateFrom", $this->dateFrom);
        $stmt->bindParam(":dateUntil", $this->dateUntil);
        $stmt->bindParam(":horoscopeSign", $this->horoscopeSign);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }  

    // used when filling up the update horoscope form
    function readOne(){
     
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_ID . " 
                WHERE
                    no = ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of horoscope to be updated
        $stmt->bindParam(1, $this->id);
     
        // execute query
        $stmt->execute();
     
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        // set values to object properties
        $this->ID = $row['ID'];
        $this->dateFrom = $row['dateFrom'];
        $this->dateUntil = $row['dateUntil'];
        $this->horoscopeSign = $row['horoscopeSign'];
        $this->description = $row['description'];
        $this->created = $row['created'];
    }     

    // update the horoscope
    function update(){
     
        // update query
        $query = "UPDATE
                    " . $this->table_ID . "
                SET
                    ID = :ID, dateFrom = :dateFrom, dateUntil = :dateUntil, horoscopeSign = :horoscopeSign, description = :description
                WHERE
                    no = :no";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->no=htmlspecialchars(strip_tags($this->no));
        $this->ID=htmlspecialchars(strip_tags($this->ID));
        $this->dateFrom=$this->dateFrom;
        $this->dateUntil=$this->dateUntil;
        $this->horoscopeSign=$this->horoscopeSign;
        $this->description=$this->description;
     
        // bind new values
        $stmt->bindParam(':no', $this->no);
        $stmt->bindParam(':ID', $this->ID);
        $stmt->bindParam(':dateFrom', $this->dateFrom);
        $stmt->bindParam(':dateUntil', $this->dateUntil);
        $stmt->bindParam(':horoscopeSign', $this->horoscopeSign);
        $stmt->bindParam(':description', $this->description);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    // delete the horoscope
    function delete(){
     
        // delete query
        $query = "DELETE FROM " . $this->table_ID . " WHERE no = ?";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->no=htmlspecialchars(strip_tags($this->no));
     
        // bind no of record to delete
        $stmt->bindParam(1, $this->no);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }    
}

class Person{
    public $horoscope;
    public $from;
    public $until;
    public $horoscopeSign;
    function __construct($date){
        
        $this->date = $date;
        if(strlen($date) < 4){
            $this->horoscope = "<p>Felaktigt personnummer!</p>";
        }
        elseif($date >= '1222' && $date <= '1230' || $date >= '0101' && $date <= '0119'){  
            $this->horoscope = "<img src='assets/pics/stenbock.jpg' class='pics'>#<span class='default'><strong>Element: Jord</strong><br >Tillbakadragen, blyg, trogen, pliktkänsla, ambitiös, lojal</span>
                <span class='other'><strong>Stenbock: </strong><br>22 december - 19 januari</span><div style='clear:both'></div>";
            $this->from = "22 december";
            $this->until = "19 januari";
            $this->horoscopeSign = "Stenbock";

        }
        elseif($date >= '0120' && $date <= '0131' || $date >= '0201' && $date <= '0218'){  

            $this->horoscope = "<img src='assets/pics/vattuman.jpg' class='pics'>#<span class='default'><strong>Element: Vatten</strong><br >Fredsälskare, klarsynt, intuitiv, lojal, uppfinningsrik, revolutionär</span>
                <span class='other'><strong>Vattuman: </strong><br>20 januari - 18 februari</span><div style='clear:both'></div>";
           
            $this->from = "20 januari";
            $this->until = "18 februari";
            $this->horoscopeSign = "Vattuman";
        }
        elseif($date >= '0219' && $date <= '0228' || $date >= '0301' && $date <= '0320'){  
 
            $this->horoscope = "<img src='assets/pics/fisk.jpg' class='pics'>#<span class='default'><strong>Element: Vatten</strong><br >Empati, human, slarvig, vänlig, hemlighetsfull, lättpåverkad, inspirerande</span>
                <span class='other'><strong>Fisk: </strong><br>19 februari - 20 mars</span><div style='clear:both'></div>";        

            $this->from = "19 februari";
            $this->until = "20 mars";
            $this->horoscopeSign = "Fisk";                    
        }
         
        elseif($date >= '0321' && $date <= '0331' || $date >= '0401' && $date <= '0419'){  

            $this->horoscope = "<img src='assets/pics/vadur.jpg' class='pics'>#<span class='default'><strong>Element: Eld</strong><br >Varm, entusiastisk, social, känslosam, stressad, impulsstyrd, aggressiv</span>
                <span class='other'><strong>Vädur: </strong><br>21 mars - 19 april</span><div style='clear:both'></div>"; 

            $this->from = "21 mars";
            $this->until = "19 april";
            $this->horoscopeSign = "Vädur";                         
        }
         
        elseif($date >= '0420' && $date <= '0430' || $date >= '0501' && $date <= '0520'){  

            $this->horoscope = "<img src='assets/pics/oxe.jpg' class='pics'>#<span class='default'><strong>Element: Jord</strong><br >Envis, beskyddande, lojal, tålmodig, uthållig, stabil, praktisk, realistisk</span>
                <span class='other'><strong>Oxe: </strong><br>20 april - 20 maj</span><div style='clear:both'></div>";  

            $this->from = "20 april";
            $this->until = "20 maj";
            $this->horoscopeSign = "Oxe";                            
        }
        elseif($date >= '0521' && $date <= '0531' || $date >= '0601' && $date <= '0621'){  

            $this->horoscope = "<img src='assets/pics/tvilling.jpg' class='pics'>#<span class='default'><strong>Element: Luft</strong><br >Kvick, kommunikativ, ytlig, nyfiken, självständig, modig, impulsiv, stressad</span>
                <span class='other'><strong>Tvilling: </strong><br>21 maj - 21 juni</span><div style='clear:both'></div>"; 

            $this->from = "21 maj";
            $this->until = "21 juni";
            $this->horoscopeSign = "Tvilling";                                 
        }
        elseif($date >= '0622' && $date <= '0630' || $date >= '0701' && $date <= '0722'){  

            $this->horoscope = "<img src='assets/pics/krafta.jpg' class='pics'>#<span class='default'><strong>Element: Vatten</strong><br >Föräldern, beskyddaren, bevararen, den trofaste, den lojale & sympatiske</span>
                <span class='other'><strong>Kräfta: </strong><br>22 juni - 22 juli</span><div style='clear:both'></div>";   

            $this->from = "22 juni";
            $this->until = "22 juli";
            $this->horoscopeSign = "Kräfta";                                
        }
         
        elseif($date >= '0723' && $date <= '0731' || $date >= '0801' && $date <= '0822'){  

            $this->horoscope = "<img src='assets/pics/lejon.jpg' class='pics'>#<span class='default'><strong>Element: Solen</strong><br >Storsint, kärleksfull, viljestark, svarsjuk, ledare, trofast, plikttrogen</span>
                <span class='other'><strong>Lejon: </strong><br>23 juli - 22 augusti</span><div style='clear:both'></div>";       

            $this->from = "23 juli";
            $this->until = "22 augusti";
            $this->horoscopeSign = "Lejon";                            
        }
        elseif($date >= '0823' && $date <= '0831' || $date >= '0901' && $date <= '0922'){  

            $this->horoscope = "<img src='assets/pics/jungfru.jpg' class='pics'>#<span class='default'><strong>Element: Jord</strong><br >Blyg, självmedveten, analytisk, produktiv, kritisk, föränderlig</span>
                <span class='other'><strong>Jungfru: </strong><br>23 augusti - 22 september</span><div style='clear:both'></div>";    

            $this->from = "23 augusti";
            $this->until = "22 september";
            $this->horoscopeSign = "Jungfru";                              
        }
        elseif($date >= '0923' && $date <= '0930' || $date >= '1001' && $date <= '1022'){  

            $this->horoscope = "<img src='assets/pics/vag.jpg' class='pics'>#<span class='default'><strong>Element: Luft</strong><br >Förälskelse, charm, obeslutsamhet, förföriskhet, diplomati, social kompetens</span>
                <span class='other'><strong>Våg: </strong><br>23 september - 22 oktober</span><div style='clear:both'></div>";   

            $this->from = "23 september";
            $this->until = "22 oktober";
            $this->horoscopeSign = "Våg";                                    
        }
         
        elseif($date >= '1023' && $date <= '1031' || $date >= '1101' && $date <= '1121'){  

            $this->horoscope = "<img src='assets/pics/skorpion.jpg' class='pics'>#<span class='default'><strong>Element: Vatten</strong><br >Intensiv, svarsjuk, passionerad, tystlåten, intensiv, lojal, modig, stark</span>
                <span class='other'><strong>Skorpion: </strong><br>23 oktober - 21 november</span><div style='clear:both'></div>";  

            $this->from = "23 oktober";
            $this->until = "21 november";
            $this->horoscopeSign = "Skorpion";                             
        }
        elseif($date >= '1122' && $date <= '1130' || $date >= '1201' && $date <= '1221'){  

            $this->horoscope = "<img src='assets/pics/skytt.jpg' class='pics'>#<span class='default'><strong>Element: Eld</strong><br >Ärlig, generös, idealistisk, optimistisk, överdrivande, entusiastisk, sökare</span>
                <span class='other'><strong>Skytt: </strong><br>22 november - 21 december</span><div style='clear:both'></div>";

            $this->from = "22 november";
            $this->until = "21 december";
            $this->horoscopeSign = "Skytt";                                  
        }
        else {
            $this->horoscope = "<p>Felaktigt personnummer!</p>";
        }
    }
    
    public function printSign(){
        return $this->horoscope;
    }
    
}