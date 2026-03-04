<?php
class Categories {
    
    /** @var int */
    protected $id;
    
    /** @var string */
    protected $name;


    public function getCategories() {
        $categories = [];

        $db = DatabaseConection::getConection();
        $query = "SELECT * FROM categories;";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();
        $categories = $PDOStatement->fetchAll();

        return $categories;
    }

    public function getCategoriesById($id) {

        $db = DatabaseConection::getConection();
        $query = "SELECT * FROM categories WHERE id = $id";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();
        $category = $PDOStatement->fetch();

        if (!$category) {
            return null;
        }

        return $category;
    }

    public function editCategory(
        $id,
        $catName,
    ) {
        $db = DatabaseConection::getConection();
        $query = "UPDATE categories SET name = :catName  WHERE id = :id";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute([
            ':id'=>$id,
            ':catName'=>$catName
        ]);
    }

    public function get_categories_x_product($productId) {
        $categories = [];
        $categoriesSelected = [];
    
        $db = DatabaseConection::getConection();
        $query = "SELECT product_id, GROUP_CONCAT(category_id) AS categories FROM product_x_category WHERE product_x_category.product_id= $productId GROUP BY product_x_category.product_id;";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute();
        $categories = $PDOStatement->fetch();
        
        if(!empty($categories)) {
            $values = explode(",", $categories['categories']);  
       
            foreach ($values as $category) {
                array_push($categoriesSelected, $this->getCategoriesById((int)$category));
            }
        }
       

        return $categoriesSelected;
    }

    public function createCategory(
        $name
    ) {
        $db = DatabaseConection::getConection();
        $query = "INSERT INTO `categories`
        (`name`) VALUES ('$name');
        SELECT MAX(id) AS id FROM categories";

        $PDOStatement = $db -> prepare($query);
        $PDOStatement -> execute();

        $getId = "SELECT MAX(id) AS id FROM categories";

        $PDOStatement = $db->prepare($getId);
        $PDOStatement -> execute();
        $result = $PDOStatement -> fetch();

        return $result['id'];
    }

   

    public function get_by_id(int $id): ?Categories {
        $db = DatabaseConection::getConection();
        $query = "SELECT * FROM categories WHERE id = $id";

        $PDOStatement = $db -> prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement -> execute();

        $result = $PDOStatement->fetch();

        if (!$result) {
            return null;
        }
        return $result;
    }

    public function deleteCategory($id)
    {
        $db = DatabaseConection::getConection();
        $query = "DELETE FROM categories WHERE id = :id";

        $PDOStatement = $db -> prepare($query);
        $PDOStatement -> execute(
            [

                'id' => $id
            ]
        );
    }

    /**
     * Category id getter
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Category name getter
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}