<?php

namespace App\Controllers\Admin\Auth;

use App\Core\Database;
use App\Validator\Validator;
use App\Core\Request;
use PDO;

class LoginController
{
    private $db;

    /**
     * Constructor to initialize database connection.
     */
    public function __construct()
    {
        $database = new Database;
        $this->db = $database->getConnection();
    }

    /**
     * Display the login form view.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle the login request.
     * 
     * @param Request $request the request object containing input data.
     */
    public function login(Request $request)
    {
        // Get input data from the request
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];
        // Validation rules
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        // Initialize the validator
        $validator = new Validator($data);
        // Run validation;
        if (!$validator->validate($rules)) {
            // Store errors in session
            $_SESSION['errors']['login'] = $validator->getErrors();
            $_SESSION['login']['email'] = $data['email'];
            // Redirect back to the registration form
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Fetch user data based on email
        $stmt = $this->db->prepare("SELECT user_id, name, email, password, role_name FROM users LEFT JOIN roles ON users.role_id = roles.role_id WHERE email = :email");
        $stmt->execute(['email' => $request->get('email')]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password and login
        if ($user && password_verify($request->get('password'), $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role_name'];
            header("location: /");
            exit;
        } else {
            $_SESSION['login']['email'] = $data['email'];
            $_SESSION['login']['fail'] = "Username or password is wrong!";
            header("location: /admin/login");
            exit;
        }
    }

    /**
     * Logout the user and destroy session
     */
    public function logout()
    {
        // Start the session
        session_start();
        // Destroy the session
        session_unset();
        session_destroy();
        // Remove the session cookie
        setcookie(session_name(), '', time() - 3600, '/');
        // Redirect to the home page after logout
        header('Location: /');
        exit();
    }
}
