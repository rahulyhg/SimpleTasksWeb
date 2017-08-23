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

function redirect($url, $extra = [])
{
    //Get the response
    $response = \Symfony\Component\HttpFoundation\Response::create(null,
        \Symfony\Component\HttpFoundation\Response::HTTP_FOUND,
        ['Location' => $url]);

    //Check for extras
    if(key_exists('cookies', $extra))
    {
        foreach($extra['cookies'] as $cookie)
        {
            $response->headers->setCookie($cookie);
        }
    }

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
            AND user = :user
        ");

        $query->execute([
            'id' => $id,
            'user' => getCurrentUser()['id']
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
            WHERE user = :user
        ");
        $query->execute([
            'user' => getCurrentUser()['id']
        ]);
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

    try
    {
        $query = $db->prepare("
            INSERT INTO items(name, user, done, created)
            VALUES (:name, :user, 0, NOW())
        ");

        return $query->execute([
            'name' => $name,
            'user' => getCurrentUser()['id']
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
            'user' => getCurrentUser()['id']
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

    try
    {
        switch(strtolower($status)) {
            case 'done':
                $query = $db->prepare("
                    UPDATE items
                    SET done = 1
                    WHERE id = :item
                    AND user = :user
                ");

                $query->execute([
                    'item' => $id,
                    'user' => getCurrentUser()['id']
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
                    'user' => getCurrentUser()['id']
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

    try
    {
        $query = $db->prepare("
            DELETE FROM items
            WHERE id = :id
            AND user = :user
        ");

        $query->execute([
            'id' => $id,
            'user' => getCurrentUser()['id']
        ]);
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

function getCurrentUser()
{
    global $db;

    try
    {
        $userId = decodeJWT('sub');
    }
    catch(\Exception $e)
    {
        throw $e;
    }

    try
    {
        $query = $db->prepare("
            SELECT * FROM users
            WHERE id = :user
        ");

        $query->execute([
            'user' => $userId
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function getAllUsers()
{
    global $db;

    try
    {
        $query = $db->prepare("
            SELECT * FROM users
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function createUser($email, $password)
{
    global $db;

    try
    {
        $query = $db->prepare("
            INSERT INTO users (email, password, role_id, created)
            VALUES (:email, :password, :role_id, NOW())
        ");

        $query->execute([
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

function updatePassword($password, $userId)
{
    global $db;

    try
    {
        $query = $db->prepare("
            UPDATE users
            SET password = :password
            WHERE id = :user
        ");

        $query->execute([
            'password' => $password,
            'user' => $userId,
        ]);
    }
    catch(\Exception $e)
    {
        return false;
    }

    return true;
}

function promote($userId)
{
    global $db;

    try
    {
        $query = $db->prepare("
            UPDATE users
            SET role_id = 1
            WHERE id = :user
        ");

        $query->execute([
            'user' => $userId,
        ]);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function demote($userId)
{
    global $db;

    try
    {
        $query = $db->prepare("
            UPDATE users
            SET role_id = 2
            WHERE id = :user
        ");

        $query->execute([
            'user' => $userId,
        ]);
    }
    catch(\Exception $e)
    {
        throw $e;
    }
}

function decodeJWT($prop = null)
{
    \Firebase\JWT\JWT::$leeway = 1;
    $jwt = \Firebase\JWT\JWT::decode(
        request()->cookies->get('access_token'),
        getenv('SECRET_KEY'),
        ['HS256']
    );

    if($prop == null)
    {
        return $jwt;
    }
    else
    {
        return $jwt->{$prop};
    }
}

function isAuthenticated()
{
    if(!request()->cookies->has('access_token'))
    {
        return false;
    }

    try
    {
        decodeJWT();
        return true;
    }
    catch(\Exception $e)
    {
        return false;
    }
}

function isAdmin()
{
    if(!isAuthenticated())
    {
        return false;
    }

    try
    {
        $isAdmin = decodeJWT('is_admin');
    }
    catch(\Exception $e)
    {
        return false;
    }

    return (boolean)$isAdmin;
}

function requireAuth()
{
    if(!isAuthenticated())
    {
        $accessToken = new \Symfony\Component\HttpFoundation\Cookie('access_token',
            'Expired',
            time() - 3600,
            '/',
            getenv('COOKIE_DOMAIN'));
        redirect("../login.php", ['cookies' => [$accessToken]]);
    }
}

function requireAdmin()
{
    global $session;

    if(!isAuthenticated())
    {
        $accessToken = new \Symfony\Component\HttpFoundation\Cookie('access_token',
            'Expired',
            time() - 3600,
            '/',
            getenv('COOKIE_DOMAIN'));
        redirect("../login.php", ['cookies' => [$accessToken]]);
    }

    try
    {
        if(!decodeJWT('is_admin'))
        {
            $session->getFlashBag()->add('error', 'Not Authorized.');
            redirect('/');
        }
    }
    catch(\Exception $e)
    {
        $accessToken = new \Symfony\Component\HttpFoundation\Cookie('access_token',
            'Expired',
            time() - 3600,
            '/',
            getenv('COOKIE_DOMAIN'));
        redirect("../login.php", ['cookies' => [$accessToken]]);
    }
}

function displaySuccess()
{
    global $session;

    if(!$session->getFlashBag()->has('success'))
    {
        return '';
    }

    $messages = $session->getFlashBag()->get('success');

    $response = '<div style="margin: 10px" class="alert alert-success alert-dismissable">';
    foreach($messages as $message)
    {
        $response .= "{$message}<br>";
    }
    $response .= '</div>';

    return $response;
}

function displayErrors()
{
    global $session;

    if(!$session->getFlashBag()->has('error'))
    {
        return '';
    }

    $messages = $session->getFlashBag()->get('error');

    $response = '<div style="margin: 10px" class="alert alert-danger alert-dismissable">';
    foreach($messages as $message)
    {
        $response .= "{$message}<br>";
    }
    $response .= '</div>';

    return $response;
}
