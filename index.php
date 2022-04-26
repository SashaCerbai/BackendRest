<?PHP 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: *');
    require("connessione.php");
    header('Content-Type: application/json');
    
        //variabili varie
        $page=@$_GET["page"] ?? 0;
        $size=@$_GET["size"] ?? 20;
        $id = @$_GET["id"] ?? 0;
        $conta = contaRighe();
        $last = ceil($conta/$size) -1;
        $urlDiBase = "http://localhost:8080/index.php";
        $query="select count(id) as tot from employees";
        
        //array del json
        $arrayJSON = array ();

        $arrayJSON['_embedded'] = array(
            "employees" => array(
                
            )
        );
    
        $arrayJSON['_links'] = links($page, $size, $last, $urlDiBase);

        $arrayJSON['page']=array(
            "size"=> $size,
            "totalElements"=> $conta,
            "totalPages"=> $last,
            "number"=> $page

        );

        //switch per GET, POST, ecc...
        switch($_SERVER['REQUEST_METHOD']){

            case 'GET':
                if($id != 0){
                    $arrayJSON['_embedded']['employees'] = GET_BY_ID($id);
                    echo json_encode($arrayJSON);
                }else{
                    $arrayJSON['_embedded']['employees'] = GET($page*$size, $size);
                    echo json_encode($arrayJSON);
                }
                break;
    
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                POST($data["first_name"], $data["last_name"], $data["gender"]);
    
                echo json_encode($data);
                break;
    
            case 'PUT':
                $data = json_decode(file_get_contents('php://input'), true);
                PUT($data["first_name"], $data["last_name"], $data["gender"], $id);
    
                echo json_encode($data);
                break;
    
            case 'DELETE':
                DELETE($id);
    
                if(($key = array_search('id: '. $id, $arrayJSON)) !== false){
                    unset($arrayJSON[$key]);
                }
    
                echo json_encode($arrayJSON);
                break;
            
            default:
                header("HTTP/1.1 400 BAD REQUEST");
                break;

        }

        function contaRighe(){
            require("connessione.php");
            $query = "SELECT count(*) FROM employees";
    
            $result = $mysqli-> query($query);
            $row = $result-> fetch_row();
    
            return $row[0];
        }   

        function href($urlDiBase, $page, $size){
            return $urlDiBase . "?page=" . $page . "&size=" . $size;
        }
    
        //vari link
        function links($page, $size, $last, $urlDiBase){
            $links = array(
                "first" => array ( "href" => href($urlDiBase, 0, $size)),
                "self" => array ( "href" => href($urlDiBase, $page, $size), "templated" => true),
                "last" => array ( "href" => href($urlDiBase, $last, $size))
            );
            
            if($page > 0){
                $links["prev"] = array( "href" => href($urlDiBase, $page - 1, $size));
            }
            
            if($page < $last){
                $links["next"] = array ( "href" => href($urlDiBase, $page + 1, $size));
            }
            
            return $links;
        }

        //metodi get, post, ecc...

        function GET($page, $lenght){
            require("connessione.php");
            $query = "SELECT * FROM employees ORDER BY id LIMIT $page, $lenght";
            $rows = array();
    
            if($result = $mysqli-> query($query)){
                while($row = $result-> fetch_assoc()){
                    $rows[] = $row;
                }
            }
    
            return $rows;
        }
    
        function GET_BY_ID($id){
            require("connessione.php");
            $query = "SELECT * FROM employees WHERE id = $id";
            $rows = array();
    
            if($result = $mysqli-> query($query)){
                while($row = $result-> fetch_assoc()){
                    $rows[] = $row;
                }
            }
    
            return $rows;
        }
    
        function POST($firstN, $lastN, $g){
            require("connessione.php");
            $query = "INSERT INTO employees (first_name, last_name, gender) VALUES ('$firstN', '$lastN', '$g')";
            $result = $mysqli-> query($query);
    
        }
    
        function PUT($firstN, $lastN, $g, $id){
            require("connessione.php");
            $query = "UPDATE employees SET first_name = '$firstN', last_name = '$lastN', gender = '$g' WHERE id = '$id'";
            $result = $mysqli-> query($query);
            
        }
    
        function DELETE($id){
            require("connessione.php");
            $query = "DELETE FROM employees WHERE id = $id";
            $result = $mysqli-> query($query);
            
        }
    ?>

   