<?php
// Путь к файлу JSON
$file = 'applications.json';

// Получаем данные из формы
$request_id = $_POST['request_id'];
$date = $_POST['date'];
$equipment = $_POST['equipment'];
$issue_type = $_POST['issue_type'];
$description = $_POST['description'];
$client = $_POST['client'];
$status = $_POST['status'];

// Создаем массив с новыми данными
$new_entry = [
    'request_id' => $request_id,
    'date' => $date,
    'equipment' => $equipment,
    'issue_type' => $issue_type,
    'description' => $description,
    'client' => $client,
    'status' => $status
];

// Проверяем, существует ли файл
if (file_exists($file)) {
    // Если файл существует, получаем его содержимое
    $json_data = file_get_contents($file);
    // Преобразуем данные из JSON в массив
    $entries = json_decode($json_data, true);
} else {
    // Если файл не существует, создаем пустой массив
    $entries = [];
}

// Добавляем новую запись в массив
$entries[] = $new_entry;

// Преобразуем массив обратно в JSON с поддержкой кириллицы
$json_data = json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Сохраняем данные в файл
file_put_contents($file, $json_data);

// Выводим сообщение об успешной отправке через alert
echo "<script>alert('Заявка успешно отправлена!'); window.location.href = 'form.html';</script>";
?>
