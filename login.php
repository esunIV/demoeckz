<?php
session_start();

// Путь к файлу с пользователями
$user_file = 'users.json';

// Получаем данные из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверяем, существует ли файл с пользователями
    if (file_exists($user_file)) {
        $user_data = file_get_contents($user_file);
        $users = json_decode($user_data, true);

        // Поиск пользователя
        foreach ($users as $user) {
            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                // Устанавливаем сессию
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Переходим на главную страницу после успешной авторизации
                echo "<script>alert('Авторизация успешна!'); window.location.href = 'index.php';</script>";
                exit;
            }
        }

        // Если пользователь не найден или пароль неверный
        echo "<script>alert('Неверное имя пользователя или пароль!'); window.location.href = 'login.html';</script>";
    } else {
        echo "<script>alert('Файл с пользователями не найден!');</script>";
    }
}
?>
