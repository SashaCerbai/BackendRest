<!DOCTYPE html>
<html>
    <head>
        <title>mio-sito</title>
    </head>
    <body>

    <?PHP
        
        $obj -> id=10018;
        $obj -> birthdate="1992-07-24";
        $obj -> firstname="Pippo";
        $obj -> lastname="Baudo";
        $obj -> gender="M";
        $obj -> hireDate="2010-11-18";
        $json = json_encode($obj);

        $data = file_get_contents("myJson.js");

        switch($_SERVER['REQUEST_METHOD']){

            case 'GET':
                header("HTTP/1.1 200 OK");
                var_dump($data);
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
