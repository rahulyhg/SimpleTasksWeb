<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/20/17
 * Time: 10:47 PM
 */

/**
 * @return \Symfony\Component\HttpFoundation\Request
 */
function request()
{
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

function redirect($url)
{
    //Get the response
    $response = \Symfony\Component\HttpFoundation\Response::create(null,
        \Symfony\Component\HttpFoundation\Response::HTTP_FOUND,
        ['Location' => $url]);

    //Send the response
    $response->send();

    exit;
}

function getTask($id)
{
    global $db;

    try
    {
        $query = $db->prepare("
            SELECT id, name, done
            FROM items
            WHERE id = :id
        ");

        $query->execute([
            'id' => $_GET['item']
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function getAllTasks()
{
    global $db;

    try
    {
        $query = $db->prepare("
            SELECT * FROM items
        ");
        $query->execute();
        return $query->fetchAll();
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function addTask($name)
{
    global $db;
    $ownerId = 1;

    try
    {
        $query = $db->prepare("
            INSERT INTO items(name, user, done, created)
            VALUES (:name, :user, 0, NOW())
        ");

        return $query->execute([
            'name' => $name,
            'user' => $ownerId
        ]);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function updateTask($id, $name)
{
    global $db;
    $ownerId = 1;

    try
    {
        $query = $db->prepare("
            UPDATE items
            SET name = :name
            WHERE id = :id
            AND user = :user
        ");

        return $query->execute([
            'name' => $name,
            'id' => $id,
            'user' => $ownerId
        ]);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function markTask($id, $status)
{
    global $db;
    $ownerId = 1;

    try
    {
        switch($status) {
            case 'done':
                $query = $db->prepare("
                    UPDATE items
                    SET done = 1
                    WHERE id = :item
                    AND user = :user
                ");

                $query->execute([
                    'item' => $id,
                    'user' => $ownerId
                ]);
                break;

            case 'undone':
                $query = $db->prepare("
                    UPDATE items
                    SET done = 0
                    WHERE id = :item
                    AND user = :user
                ");

                $query->execute([
                    'item' => $id,
                    'user' => $ownerId
                ]);
                break;
        }
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function deleteTask($id)
{
    global $db;
    $ownerId = 1;

    try
    {
        $query = $db->prepare("
            DELETE FROM items
            WHERE id = :id
            AND user = :user
        ");

        $query->execute([
            'id' => $id,
            'user' => $ownerId
        ]);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function findUserByUsername($username)
{
    global $db;

    try
    {
        $query = $db->prepare("
            SELECT * FROM users
            WHERE username = :username
        ");

        $query->execute([
            'username' => $username
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function findUserByEmail($email)
{
    global $db;

    try
    {
        $query = $db->prepare("
            SELECT * FROM users
            WHERE email = :email
        ");

        $query->execute([
            'email' => $email
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function createUser($username, $email, $password)
{
    global $db;

    try
    {
        $query = $db->prepare("
            INSERT INTO users (username, email, password, role_id)
            VALUES (:username, :email, :password, :role_id)
        ");

        $query->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role_id' => 2
        ]);

        return findUserByEmail($email);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}
