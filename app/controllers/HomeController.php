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
            'home/logoContent',
            [],
            'logo'
        );
    }

    public function page2()
    {
        render(
            'home/listOfContent',
            [],
            '0'
        );
    }

    public function page3()
    {
        render(
            'home/aboutMe',
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
            'home/education',
            ['educationData' => $educationData],
            'education_layout'
        );
    }

    public function page5()
    {
        $db = DataBase::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM skills_list ORDER BY category, id ASC");
        $stmt->execute();
        $skillsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        render(
            'home/skills',
            ['skillsData' => $skillsData],
            'skills_layout'
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
