<?php
    class Shoe{
        public $connect;
        

        public function __construct(){
            try{
                $this->connect = Connection::connect();
            }catch(Exception $e){
                die($e->getMessage());
            }
        }

        public function list (){
            try{
                $query = "SELECT * FROM shoes";
                $data  = $this->connect->prepare($query);
                $data->execute();
                return $data->fetchAll(PDO::FETCH_OBJ);
            }catch(Exception $e){
                die($e->getMessage());
            }
        }

        public function insert(){
            $name   = $_POST['name'];
            $brand  = $_POST['brand'];
            $gender = $_POST['gender'];
            $style  = $_POST['style'];
            $color  = $_POST['color'];
            $size   = $_POST['size'];
            $units  = $_POST['units'];
            $price  = $_POST['price'];
            $date   = $_POST['date'];

            $nameImage  = $_FILES['image']['name'];
            $route       = $_FILES['image']['tmp_name'];
            $destination = 'resources/images/'.$nameImage;

            if(move_uploaded_file($route,$destination)){
                try{
                    $query = "INSERT INTO shoes (name,brand,gender,style,color,size,units,price,datetime,image) 
                              VALUES ('$name','$brand','$gender','$style','$color','$size','$units','$price','$date','$nameImage')"; 
                    $data = $this->connect->prepare($query);
                    $data->execute();
                 }catch(Exception $e){
                     die($e->getMessage());
                 }
            }else{
                echo 'imagen existe';
            }
        }

        public function eliminate($id, $nameImage){
            $routeImage = 'resources/images/'.$nameImage;
            unlink($routeImage);
            if(!file_exists($routeImage)){
                try{
                    $query = "DELETE FROM shoes WHERE id = ".$id.""; 
                    $data = $this->connect->prepare($query);
                    $data->execute();
                }catch(Exception $e){
                    die($e->getMessage());
                }
            }else{
                echo 'No se pudo eliminar el zapato';
            }
                
        }

        public function getShoe ($id){
            try{
                $query = "SELECT * FROM shoes where id=".$id;
                $data  = $this->connect->prepare($query);
                $data->execute();
                return $data->fetch(PDO::FETCH_OBJ);
            }catch(Exception $e){
                die($e->getMessage());
            }
        }

        public function update($id){
            $name   = $_POST['name'];
            $brand  = $_POST['brand'];
            $gender = $_POST['gender'];
            $style  = $_POST['style'];
            $color  = $_POST['color'];
            $size   = $_POST['size'];
            $units  = $_POST['units'];
            $price  = $_POST['price'];

            try{
                $query = "UPDATE shoes 
                          SET name='$name',brand='$brand',gender='$gender',style='$style',
                              color='$color',size='$size',units='$units',price='$price' 
                          WHERE id='$id'"; 
                $data = $this->connect->prepare($query);
                $data->execute();
            }catch(Exception $e){
                die($e->getMessage());
            }
        }
    }
?>