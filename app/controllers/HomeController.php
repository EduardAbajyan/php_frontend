<?php

class HomeController
{
    public function index()
    {
        redirect('page1', []);
        exit;
    }

    public function page1()
    {
        render(
            'home/page1',
            [],
            'logo'
        );
    }

    public function page2()
    {
        render(
            'home/page2',
            [],
            '0'
        );
    }

    public function page3()
    {
        render(
            'home/page3',
            [],
            '0'
        );
    }

    public function page4()
    {
        $db = DataBase::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM education_list ORDER BY ending_year DESC");
        $stmt->execute();
        $educationData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        render(
            'home/page4',
            ['educationData' => $educationData],
            'page4_layout'
        );
    }

    public function page5()
    {
        $db = DataBase::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM skills_list ORDER BY category, id ASC");
        $stmt->execute();
        $skillsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        render(
            'home/page5',
            ['skillsData' => $skillsData],
            'page5_layout'
        );
    }

    public function page6()
    {
        render(
            'home/contact',
            [],
            '0'
        );
    }

    public function submitContact()
    {
        // TEMPORARY: Comment out CSRF validation for testing
        /*
        // Debug: Check session tokens
        Core\Session::start();
        $postToken = $_POST['csrf_token'] ?? null;
        $sessionTokens = Core\Session::get('_csrf_tokens', []);

        echo "DEBUG - POST token: " . ($postToken ?? 'not set') . "<br>";
        echo "DEBUG - Session tokens: <pre>" . print_r($sessionTokens, true) . "</pre>";
        echo "DEBUG - Token exists in session: " . (isset($sessionTokens[$postToken]) ? 'YES' : 'NO') . "<br>";
        echo "DEBUG - All POST data: <pre>" . print_r($_POST, true) . "</pre>";

        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || !Core\CSRF::validateToken($_POST['csrf_token'])) {
            echo "CSRF validation failed!<br>";
            Core\Session::flash('error', 'Invalid security token. Please try again.');
            // redirect('page6', []);
            exit;
        }

        echo "CSRF validation passed!<br>";
        */

        // Validate inputs
        $errors = [];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || strlen($name) < 2) {
            $errors[] = 'Name must be at least 2 characters.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        }

        if (empty($subject) || strlen($subject) < 3) {
            $errors[] = 'Subject must be at least 3 characters.';
        }

        if (empty($message) || strlen($message) < 10) {
            $errors[] = 'Message must be at least 10 characters.';
        }

        if (strlen($message) > 1000) {
            $errors[] = 'Message must not exceed 1000 characters.';
        }

        if (!empty($errors)) {
            Core\Session::flash('error', implode(' ', $errors));
            redirect('page6', []);
            exit;
        }

        // Save to database
        try {
            $db = DataBase::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO contact_messages (name, email, subject, message, ip_address, created_at) 
                VALUES (:name, :email, :subject, :message, :ip, NOW())
            ");

            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Core\Session::flash('success', 'Thank you for your message! I\'ll get back to you soon.');
        } catch (PDOException $e) {
            Core\Session::flash('error', 'Sorry, there was an error sending your message. Please try again.');
        }

        redirect('page6', []);
        exit;
    }
}
