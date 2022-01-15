<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

    $app->get('/', function (Request $request, Response $response, array $args) {
        echo 'homepage found';
    });

    // SHOW ALL
    $app->get('/api/product', function(Request $request, Response $response){
        $sql = "SELECT * FROM product";

        try {
            $db = new db();
            $pdo = $db->connect();
            $stmt = $pdo->query($sql);
            $product = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($product);
        } catch (\PDOException $e) {
            echo '{"msg": {"resp": '.$e->getMessage().'}}';
        }
    });

    // SHOW BY ID
    $app->get('/api/product/{id}', function(Request $request, Response $response, array $args){
        $id = $request->getAttribute('id');
        $sql = "SELECT * FROM product WHERE id = $id";

        try {
            $db = new db();
            $pdo = $db->connect();
            $stmt = $pdo->query($sql);
            $product = $stmt->fetchAll(PDO::FETCH_OBJ);
            $pdo = null;
            echo json_encode($product);
        } catch (\PDOException $e) {
            echo '{"msg": {"resp": '.$e->getMessage().'}}';
        }
    });

    // CREATE
    $app->post('/api/product/add', function(Request $request, Response $response, array $args){
        $name = $request->getParam('name');
        $price = $request->getParam('price');
        try {
            $db = new db();
            $pdo = $db->connect();
    
            $sql = "INSERT INTO product (name, price) VALUES (?,?)";
            $pdo->prepare($sql)->execute([$name, $price]);     
            echo '{"notice": {"text": "Product '.$name.' has been added to the list"}}';
            $pdo = null;
        } catch (\PDOException $e) {
            echo '{"msg": {"resp": '.$e->getMessage().'}}';
        }
    });

    // UPDATE
    $app->put('/api/product/update/{id}', function(Request $request, Response $response, array $args){
    $id = $request->getAttribute('id');
    $name = $request->getParam('name');
    $price = $request->getParam('price');
        try {
            $db = new db();
            $pdo = $db->connect();
    
            $sql = "UPDATE product SET name =?, price =? WHERE id=?";

            $pdo->prepare($sql)->execute([$name, $price, $id]);
            echo '{"notice": {"text": "Product '.$name.' has been just updated now"}}';
            $pdo = null;
        } catch (\PDOException $e) {
            echo '{"msg": {"resp": '.$e->getMessage().'}}';
        }
    });

    // DELETE
    $app->delete('/api/product/delete/{id}', function(Request $request, Response $response, array $args){
        $id = $request->getAttribute('id');
        try {
            $db = new db();
            $pdo = $db->connect();
    
            $sql = "DELETE FROM product WHERE id=?";

            $pdo->prepare($sql)->execute([$id]);
            $pdo = null;
            echo '{"notice": {"text": "Product with '.$id.' has been just deleted now"}}';
        } catch (\PDOException $e) {
            echo '{"msg": {"resp": '.$e->getMessage().'}}';
        }
    });

$app->run();