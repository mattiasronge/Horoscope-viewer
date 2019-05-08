<?php
class Horoscope{
 
    // database connection, table name
    private $conn;
    private $table_name = "scope";
 
    // objekt egenskaper
    public $id;
    public $name;
    public $description;
    public $created;
 
    // constructor med $db som databas connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read 
    function read(){
     
        // Välj alla query
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created DESC";
     
        // Förbered query statement
        $stmt = $this->conn->prepare($query);
     
        // Kör query
        $stmt->execute();
     
        return $stmt;
    }

     // Skapa horoskop
    function create(){
     
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, description=:description, created=:created";
     
        // förbered query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=$this->description;
        $this->created=htmlspecialchars(strip_tags($this->created));
     
        // bind egenskaper
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created);
     
        // kör query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }  

    // used when filling up the update horoscope form
    function readOne(){
     
        // query to single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 
                WHERE
                    id = ?
                LIMIT
                    0,1";
     
        // förbered query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id och horoskop för uppdatering
        $stmt->bindParam(1, $this->id);
     
        // kör query
        $stmt->execute();
     
        // hämta row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        // sätt värde till okjekt egenskap
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->created = $row['created'];
    }     

    // updatera horoskop
    function update(){
     
        // updatera query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name, description = :description
                WHERE
                    id = :id";
     
        // förbered query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=$this->description;
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind nya värden
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':description', $this->description);
     
        // kör query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    // radera horoskop
    function delete(){
     
        // radera query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
     
        // förbered query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
     
        // kör query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }    
}

class Person{
    public $horoscope;
    function __construct($date){
        
        $this->date = $date;
        if(strlen($date) < 4){
            $this->horoscope = "<p>Felaktigt personnummer!</p>";
        }
        elseif($date >= '1222' && $date <= '1230' || $date >= '0101' && $date <= '0119'){  
            $this->horoscope = "<img src='assets/pics/stenbock.jpg' class='pics'>#<span class='default'><strong>Element: Jord</strong><br >Tillbakadragen, blyg, trogen, pliktkänsla, ambitiös, lojal</span>
                <span class='other'><strong>Stenbock: </strong><br>22 december - 19 januari</span><div style='clear:both'></div>";
        }
        elseif($date >= '0120' && $date <= '0131' || $date >= '0201' && $date <= '0218'){  

            $this->horoscope = "<img src='assets/pics/vattuman.jpg' class='pics'>#<span class='default'><strong>Element: Vatten</strong><br >Fredsälskare, klarsynt, intuitiv, lojal, uppfinningsrik, revolutionär</span>
                <span class='other'><strong>Vattuman: </strong><br>20 januari - 18 februari</span><div style='clear:both'></div>";

        }
        elseif($date >= '0219' && $date <= '0228' || $date >= '0301' && $date <= '0320'){  
 
            $this->horoscope = "<img src='assets/pics/fisk.jpg' class='pics'>#<span class='default'><strong>Element: Vatten</strong><br >Empati, human, slarvig, vänlig, hemlighetsfull, lättpåverkad, inspirerande</span>
                <span class='other'><strong>Fisk: </strong><br>19 februari - 20 mars</span><div style='clear:both'></div>";            
        }
         
        elseif($date >= '0321' && $date <= '0331' || $date >= '0401' && $date <= '0419'){  

            $this->horoscope = "<img src='assets/pics/vadur.jpg' class='pics'>#<span class='default'><strong>Element: Eld</strong><br >Varm, entusiastisk, social, känslosam, stressad, impulsstyrd, aggressiv</span>
                <span class='other'><strong>Vädur: </strong><br>21 mars - 19 april</span><div style='clear:both'></div>";             
        }
         
        elseif($date >= '0420' && $date <= '0430' || $date >= '0501' && $date <= '0520'){  

            $this->horoscope = "<img src='assets/pics/oxe.jpg' class='pics'>#<span class='default'><strong>Element: Jord</strong><br >Envis, beskyddande, lojal, tålmodig, uthållig, stabil, praktisk, realistisk</span>
                <span class='other'><strong>Oxe: </strong><br>20 april - 20 maj</span><div style='clear:both'></div>";             
        }
        elseif($date >= '0521' && $date <= '0531' || $date >= '0601' && $date <= '0621'){  

            $this->horoscope = "<img src='assets/pics/tvilling.jpg' class='pics'> # <span class='default'><strong>Element: Luft</strong><br >Kvick, kommunikativ, ytlig, nyfiken, självständig, modig, impulsiv, stressad</span>
                <span class='other'><strong>Tvilling: </strong><br>21 maj - 21 juni</span><div style='clear:both'></div>";              
        }
        elseif($date >= '0622' && $date <= '0630' || $date >= '0701' && $date <= '0722'){  

            $this->horoscope = "<img src='assets/pics/krafta.jpg' class='pics'>#<span class='default'><strong>Element: Vatten</strong><br >Föräldern, beskyddaren, bevararen, den trofaste, den lojale & sympatiske</span>
                <span class='other'><strong>Kräfta: </strong><br>22 juni - 22 juli</span><div style='clear:both'></div>";                  
        }
         
        elseif($date >= '0723' && $date <= '0731' || $date >= '0801' && $date <= '0822'){  

            $this->horoscope = "<img src='assets/pics/lejon.jpg' class='pics'>#<span class='default'><strong>Element: Solen</strong><br >Storsint, kärleksfull, viljestark, svarsjuk, ledare, trofast, plikttrogen</span>
                <span class='other'><strong>Lejon: </strong><br>23 juli - 22 augusti</span><div style='clear:both'></div>";              
        }
        elseif($date >= '0823' && $date <= '0831' || $date >= '0901' && $date <= '0922'){  

            $this->horoscope = "<img src='assets/pics/jungfru.jpg' class='pics'>#<span class='default'><strong>Element: Jord</strong><br >Blyg, självmedveten, analytisk, produktiv, kritisk, föränderlig</span>
                <span class='other'><strong>Jungfru: </strong><br>23 augusti - 22 september</span><div style='clear:both'></div>";               
        }
        elseif($date >= '0923' && $date <= '0930' || $date >= '1001' && $date <= '1022'){  

            $this->horoscope = "<img src='assets/pics/vag.jpg' class='pics'>#<span class='default'><strong>Element: Luft</strong><br >Förälskelse, charm, obeslutsamhet, förföriskhet, diplomati, social kompetens</span>
                <span class='other'><strong>Våg: </strong><br>23 september - 22 oktober</span><div style='clear:both'></div>";                
        }
         
        elseif($date >= '1023' && $date <= '1031' || $date >= '1101' && $date <= '1121'){  

            $this->horoscope = "<img src='assets/pics/skorpion.jpg' class='pics'>#<span class='default'><strong>Element: Vatten</strong><br >Intensiv, svarsjuk, passionerad, tystlåten, intensiv, lojal, modig, stark</span>
                <span class='other'><strong>Skorpion: </strong><br>23 oktober - 21 november</span><div style='clear:both'></div>";             
        }
        elseif($date >= '1122' && $date <= '1130' || $date >= '1201' && $date <= '1221'){  

            $this->horoscope = "<img src='assets/pics/skytt.jpg' class='pics'>#<span class='default'><strong>Element: Eld</strong><br >Ärlig, generös, idealistisk, optimistisk, överdrivande, entusiastisk, sökare</span>
                <span class='other'><strong>Skytt: </strong><br>22 november - 21 december</span><div style='clear:both'></div>";            
        }
        else {
            $this->horoscope = "<p>Felaktigt personnummer!</p>";
        }
    }
    
    public function printSign(){
        return $this->horoscope;
    }
    
}