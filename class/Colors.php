<?php
class Colors {
    
    protected $id;

    protected $color;


    public function getColors() {
        $colors = [];

        $db = DatabaseConection::getConection();
        $query = "SELECT * FROM colors;";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();
        $colors = $PDOStatement->fetchAll();

        return $colors;
    }

    public function get_by_id(int $id): ?Colors {
        $db = DatabaseConection::getConection();
        $query = "SELECT * FROM colors WHERE id = $id";

        $PDOStatement = $db -> prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement -> execute();

        $result = $PDOStatement->fetch();

        if (!$result) {
            return null;
        }
        return $result;
    }
    public function getColorById($id) {

        $db = DatabaseConection::getConection();
        $query = "SELECT * FROM colors WHERE id = $id;";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();
        $color = $PDOStatement->fetch();

        if (!$color) {
            return null;
        }

        return $color;
    }

    public function createColor(
        $color
    ) {
        $db = DatabaseConection::getConection();
        $query = "INSERT INTO `colors`
        (`color`) VALUES ('$color');
        SELECT MAX(id) AS id FROM categories";

        $PDOStatement = $db -> prepare($query);
        $PDOStatement -> execute();

        $getId = "SELECT MAX(id) AS id FROM colors";

        $PDOStatement = $db->prepare($getId);
        $PDOStatement -> execute();
        $result = $PDOStatement -> fetch();

        return $result['id'];
    }

    public function deleteColor($id)
    {
        $db = DatabaseConection::getConection();
        $query = "DELETE FROM colors WHERE id = :id";

        $PDOStatement = $db -> prepare($query);
        $PDOStatement -> execute(
            [

                'id' => $id
            ]
        );
    }
    
    public function editColor(
        $id,
        $color,
    ) {
        $db = DatabaseConection::getConection();
        $query = "UPDATE colors SET color = :color  WHERE id = :id";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute([
            ':id'=>$id,
            ':color'=>$color
        ]);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function get_colors_x_product($productId) {
        $colors = [];
        $colorsSelected = [];
    
        $db = DatabaseConection::getConection();
        $query = "SELECT product_id, GROUP_CONCAT(color_id) AS colors FROM product_x_color WHERE product_x_color.product_id= $productId GROUP BY product_x_color.product_id;";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute();
        $colors = $PDOStatement->fetch();
        
        if(!empty($colors)) {
            $values = explode(",", $colors['colors']);  
       
            foreach ($values as $color) {
                array_push($colorsSelected, $this->getColorById((int)$color));
            }
        }
       

        return $colorsSelected;
    }

}