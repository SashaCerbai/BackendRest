<!DOCTYPE html>
<html>
    <head>
        <title>mio-sito</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    </head>
    <body style="background-color: red">

    
    <?PHP

    require("connessione.php");

    for($i=0;$i<9;$i++){echo '<i class="fa-solid fa-basketball" style="display: inline-block">&nbsp</i>';}
    echo '<br>';
    for($i=0;$i<10;$i++){echo '<i class="fa-solid fa-child" style="display: inline-block">&nbsp</i>';}
        /*
        $obj -> id=10018;
        $obj -> birthdate="1992-07-24";
        $obj -> firstname="Pippo";
        $obj -> lastname="Baudo";
        $obj -> gender="M";
        $obj -> hireDate="2010-11-18";
        $json = json_encode($obj);
        */
        //$data = file_get_contents("myJson.js");

        switch($_SERVER['REQUEST_METHOD']){

            case 'GET':
                $page=0;
                $size=20;
                /*header("HTTP/1.1 200 OK");
                header("Content-Type: application/json");*/
                echo "<br>";
                $query="select * from employees order by id limit " . $page . ", " . $size;
                if ($result =$mysqli->query($query)) {
                    while($row=$result->fetch_assoc()){
                        $array[]=$row;
                    }
                }
                $data=json_encode($array);
                echo $data;
                break;
            case 'POST':
                echo 'Success Post';
                var_dump($json);
                break;
            case 'PUT':
                echo 'Success Put';
                var_dump($json);
                break;
            case 'DELETE':
                break;
            default:
                header("HTTP/1.1 400 NOT FOUND");
                break;
            ;

        }

    ?>

    </body>
</html>
