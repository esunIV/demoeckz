<?php
session_start();

// Проверка, вошел ли пользователь
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Необходимо войти в систему!'); window.location.href = 'login.html';</script>";
    exit;
}

// Проверка роли пользователя
if ($_SESSION['role'] !== 'executor' && $_SESSION['role'] !== 'admin') {
    echo "<script>alert('У вас нет доступа к этой функции!'); window.location.href = 'index.php';</script>";
    exit;
}
?>
<?php
// Путь к файлу JSON
$file = 'applications.json';

// Проверяем, была ли форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $request_id = $_POST['request_id'];
    $comment = $_POST['comment'];

    // Проверяем, существует ли файл
    if (file_exists($file)) {
        // Читаем содержимое файла
        $json_data = file_get_contents($file);
        // Преобразуем данные из JSON в массив
        $entries = json_decode($json_data, true);

        // Перебираем массив и ищем заявку по номеру
        $updated = false;
        foreach ($entries as &$entry) {
            if ($entry['request_id'] === $request_id) {
                // Добавляем комментарий к заявке
                $entry['comments'][] = $comment;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            // Преобразуем массив обратно в JSON
            $json_data = json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            // Сохраняем обновленные данные в файл
            file_put_contents($file, $json_data);
            // Выводим уведомление об успешном добавлении комментария
            echo "<script>alert('Комментарий успешно добавлен!'); window.location.href = 'comments_form.html';</script>";
        } else {
            // Если заявка не найдена
            echo "<script>alert('Заявка с указанным номером не найдена.'); window.location.href = 'comments_form.html';</script>";
        }
    } else {
        // Если файл не найден
        echo "<script>alert('Файл с заявками не найден.'); window.location.href = 'form.html';</script>";
    }
}
?>

