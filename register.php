<?php
// Путь к файлу с пользователями
$user_file = 'users.json';

// Получаем данные из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Захешированный пароль
    $role = $_POST['role'];

    // Проверяем, существует ли файл с пользователями
    if (file_exists($user_file)) {
        $user_data = file_get_contents($user_file);
        $users = json_decode($user_data, true);
    } else {
        $users = [];
    }

    // Проверяем, не существует ли уже пользователя с таким именем
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            echo "<script>alert('Пользователь с таким именем уже существует!'); window.location.href = 'register.html';</script>";
            exit;
        }
    }

    // Добавляем нового пользователя
    $new_user = [
        'username' => $username,
        'password' => $password,
        'role' => $role
    ];
    $users[] = $new_user;

    // Сохраняем обновленный список пользователей
    file_put_contents($user_file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo "<script>alert('Регистрация успешна!'); window.location.href = 'login.html';</script>";
}
?>
