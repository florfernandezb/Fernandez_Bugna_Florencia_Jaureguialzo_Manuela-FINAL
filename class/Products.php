<?php
require_once "DatabaseConection.php"; 

 class Products {

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;
    
    /** @var int */
    protected $price;

    /** @var string */
    protected $available_date;

    /** @var string */
    protected $product_description;

    /** @var string */
    protected $image;

    /** @var string */
    protected $image_description;
    
    /** @var string */
    protected $product_measurements;

    /**
     * @return Products[]
     */
    public function getProducts(): array {
        $products = [];

        $db = DatabaseConection::getConection();
        $query = "SELECT * FROM products;";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();
        $products = $PDOStatement->fetchAll();

        return $products;
    }

    /**
     * Trae productos filtrando opcionalmente por categoría y/o color.
     * @param int|null $categoryId
     * @param int|null $colorId
     * @return Products[]
     */
    public function getProductsFiltered(?int $categoryId = null, ?int $colorId = null): array
    {
        $db = DatabaseConection::getConection();

        $joins = [];
        $wheres = [];
        $params = [];

        $query = "SELECT DISTINCT p.* FROM products p";

        if ($categoryId !== null) {
            $joins[] = "JOIN product_x_category pc ON pc.product_id = p.id";
            $wheres[] = "pc.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        if ($colorId !== null) {
            $joins[] = "JOIN product_x_color pcol ON pcol.product_id = p.id";
            $wheres[] = "pcol.color_id = :color_id";
            $params['color_id'] = $colorId;
        }

        if ($joins) {
            $query .= " " . implode(" ", $joins);
        }

        if ($wheres) {
            $query .= " WHERE " . implode(" AND ", $wheres);
        }

        $query .= ";";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute($params);

        return $PDOStatement->fetchAll() ?: [];
    }

    public function getProductById(int $productId): ?Products
    {
        $query = "SELECT * FROM products WHERE id = $productId";

        $result = $this->executeQuery($query);

        if (!$result) {
            return null;
        }
        return $result;
    }

    public function getProductsByCategory(int $categoryId) {
        $products = [];

        $db = DatabaseConection::getConection();
        $query = "SELECT category_id, GROUP_CONCAT(product_id) AS productos FROM product_x_category WHERE product_x_category.category_id= $categoryId GROUP BY product_x_category.category_id;";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute();
        $result = $PDOStatement->fetch(PDO::FETCH_ASSOC);
        
        if ($result && !empty($result['productos'])) {
            $values = explode(",", $result['productos']);
            foreach ($values as $productId) {
                array_push($products, $this->getProductById((int)$productId));
            }
        }
        
        return $products;
    }

    public function getProductsByColor(int $colorId) {
        $products = [];

        $db = DatabaseConection::getConection();
        $query = "SELECT color_id, GROUP_CONCAT(product_id) AS productos FROM product_x_color WHERE product_x_color.color_id= $colorId GROUP BY product_x_color.color_id;";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute();
        $result = $PDOStatement->fetch(PDO::FETCH_ASSOC);
        
        if ($result && !empty($result['productos'])) {
            $values = explode(",", $result['productos']);
            foreach ($values as $productId) {
                array_push($products, $this->getProductById((int)$productId));
            }
        }
        
        return $products;
    }

    public function createProduct(
        $name, 
        $price, 
        $available_date, 
        $product_description, 
        $image, 
        $image_description, 
        $product_measurements
    ) {
        $db = DatabaseConection::getConection();
        $query = "INSERT INTO products 
            (name, price, available_date, product_description, image, image_description, product_measurements)
            VALUES (:name, :price, :available_date, :product_description, :image, :image_description, :product_measurements)";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute([
            'name' => $name,
            'price' => $price,
            'available_date' => $available_date,
            'product_description' => $product_description,
            'image' => $image,
            'image_description' => $image_description,
            'product_measurements' => $product_measurements,
        ]);

        return (int)$db->lastInsertId();
    }

    public function editProduct(
        $id,
        $name, 
        $price, 
        $available_date, 
        $product_description, 
        $image, 
        $image_description, 
        $product_measurements
    ) {
        $db = DatabaseConection::getConection();
        $query = "UPDATE products SET name = :name,
        price = :price,
        available_date = :available_date,
        product_description = :product_description,
        image = :image,
        image_description = :image_description,
        product_measurements = :product_measurements   
        WHERE id = :id";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute([
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'available_date' => $available_date,
            'product_description' => $product_description,
            'image' => $image,
            'image_description' => $image_description,
            'product_measurements' => $product_measurements, 
        ]);
    }

    public function deleteProduct($id)
    {
        $db = DatabaseConection::getConection();
        $query = "DELETE FROM products WHERE id = $id";

        $PDOStatement = $db -> prepare($query);
        $PDOStatement -> execute();
    }

    public function add_product_x_category($idProduct, $categoryId) {
        $db = DatabaseConection::getConection();

        $query = "INSERT INTO product_x_category VALUES (NULL, $idProduct, $categoryId)";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute();
    }

    public function delete_product_x_category($idProduct) {
        $db = DatabaseConection::getConection();

        $query = "DELETE FROM product_x_category WHERE product_id = $idProduct";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute();
    }

    public function add_product_x_color($idProduct, $colorId) {
        $db = DatabaseConection::getConection();

        $query = "INSERT INTO product_x_color VALUES (NULL, $idProduct, $colorId)";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute();
    }

    public function delete_product_x_color($idProduct) {
        $db = DatabaseConection::getConection();

        $query = "DELETE FROM product_x_color WHERE product_id = $idProduct";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute();
    }

    public function edit_product_x_category($idProduct, $categoryId) {
        $db = DatabaseConection::getConection();

        $query = "UPDATE product_x_category 
        SET category_id = $categoryId 
        WHERE product_id = $idProduct";

        $PDOStatement = $db->prepare($query);
        $PDOStatement->execute();
    }
    
    /**
     * Product id getter 
     * @return int
     */
    public function getProductId(): int
    {
        return $this->id;
    }

    /**
     * Product name getter
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * Product price getter
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * Product measurements getter
     * @return string
     */
    public function getMeasurements(): string
    {
        return $this->product_measurements;
    }
    
    /**
     * Product description getter
     * @return string
     */
    public function getProductDescription(): string
    {
        return $this->product_description;
    }

    
    /**
     * Product image getter
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Get image URL with correct extension (handles both .png and .jpg, and legacy data without extension)
     * @param string $basePath Base path to images directory (e.g., './res/products/' or '../res/products/')
     * @return string Full image URL
     */
    public function getImageUrl(string $basePath = './res/products/'): string
    {
        $imageName = $this->image;
        
        // Si ya tiene extensión, usarla directamente
        if (preg_match('/\.(png|jpg|jpeg)$/i', $imageName)) {
            return $basePath . $imageName;
        }
        
        // Compatibilidad con datos antiguos: buscar primero .png, luego .jpg
        $productsDir = realpath(__DIR__ . '/../res/products');
        if ($productsDir !== false) {
            $pngPath = $productsDir . DIRECTORY_SEPARATOR . $imageName . '.png';
            $jpgPath = $productsDir . DIRECTORY_SEPARATOR . $imageName . '.jpg';
            
            if (file_exists($pngPath)) {
                return $basePath . $imageName . '.png';
            } elseif (file_exists($jpgPath)) {
                return $basePath . $imageName . '.jpg';
            }
        }
        
        // Fallback: asumir .png por compatibilidad
        return $basePath . $imageName . '.png';
    }

    /**
     * Get mobile image URL with correct extension (handles both .png and .jpg, and legacy data)
     * @param string $basePath Base path to images directory (e.g., './res/products/' or '../res/products/')
     * @return string Full mobile image URL (falls back to regular image if mobile doesn't exist)
     */
    public function getMobileImageUrl(string $basePath = './res/products/'): string
    {
        $imageName = $this->image;
        $baseName = preg_replace('/\.(png|jpg|jpeg)$/i', '', $imageName);
        
        $productsDir = realpath(__DIR__ . '/../res/products');
        if ($productsDir !== false) {
            // Buscar mobile con extensión original si existe
            if (preg_match('/\.(png|jpg|jpeg)$/i', $imageName, $matches)) {
                $ext = strtolower($matches[1]);
                $mobilePath = $productsDir . DIRECTORY_SEPARATOR . $baseName . '-mobile.' . $ext;
                if (file_exists($mobilePath)) {
                    return $basePath . $baseName . '-mobile.' . $ext;
                }
            }
            
            // Buscar mobile.png
            $mobilePngPath = $productsDir . DIRECTORY_SEPARATOR . $baseName . '-mobile.png';
            if (file_exists($mobilePngPath)) {
                return $basePath . $baseName . '-mobile.png';
            }
            
            // Buscar mobile.jpg
            $mobileJpgPath = $productsDir . DIRECTORY_SEPARATOR . $baseName . '-mobile.jpg';
            if (file_exists($mobileJpgPath)) {
                return $basePath . $baseName . '-mobile.jpg';
            }
        }
        
        // Fallback: imagen normal
        return $this->getImageUrl($basePath);
    }

    /**
     * Static helper to get image URL from image name (for use in cart, etc.)
     * @param string $imageName Image name (with or without extension)
     * @param string $basePath Base path to images directory
     * @return string Full image URL
     */
    public static function getImageUrlFromName(string $imageName, string $basePath = './res/products/'): string
    {
        // Si ya tiene extensión, usarla directamente
        if (preg_match('/\.(png|jpg|jpeg)$/i', $imageName)) {
            return $basePath . $imageName;
        }
        
        // Compatibilidad con datos antiguos: buscar primero .png, luego .jpg
        $productsDir = realpath(__DIR__ . '/../res/products');
        if ($productsDir !== false) {
            $pngPath = $productsDir . DIRECTORY_SEPARATOR . $imageName . '.png';
            $jpgPath = $productsDir . DIRECTORY_SEPARATOR . $imageName . '.jpg';
            
            if (file_exists($pngPath)) {
                return $basePath . $imageName . '.png';
            } elseif (file_exists($jpgPath)) {
                return $basePath . $imageName . '.jpg';
            }
        }
        
        // Fallback: asumir .png por compatibilidad
        return $basePath . $imageName . '.png';
    }

    /**
     * Image description getter
     * @return string
     */
    public function getImageDescription(): string
    {

        return $this->image_description;
    }

    /**
     * Available Date getter
     * @return string
     */
    public function getDate(): string
    {

        return $this->available_date;
    }

    protected function getDatabaseData(string $query): ?Products {
        $result = $this->executeQuery($query);
        return $result != null ? $result : null;
    }

    /**
     * execute Products querys
     * @return Products
     */
    protected function executeQuery(string $query): ?Products
    {
        $db = DatabaseConection::getConection();
        
        $PDOStatement = $db->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $result = $PDOStatement->fetch();

        if (!$result) {
            return null;
        }

        return $result;
    }
 }
