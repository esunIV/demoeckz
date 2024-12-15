<?php
// Путь к файлу JSON
$file = 'applications.json';

// Проверяем, существует ли файл
if (file_exists($file)) {
    // Читаем содержимое файла
    $json_data = file_get_contents($file);
    // Преобразуем данные из JSON в массив
    $entries = json_decode($json_data, true);

    // Проверяем, есть ли заявки
    if (!empty($entries)) {
        echo "<h2>Все заявки:</h2>";
        echo "<ul>";
        foreach ($entries as $entry) {
            echo "<li>";
            echo "Номер заявки: " . htmlspecialchars($entry['request_id']) . "<br>";
            echo "Дата: " . htmlspecialchars($entry['date']) . "<br>";
            echo "Оборудование: " . htmlspecialchars($entry['equipment']) . "<br>";
            echo "Тип неисправности: " . htmlspecialchars($entry['issue_type']) . "<br>";
            echo "Описание проблемы: " . htmlspecialchars($entry['description']) . "<br>";
            echo "Клиент: " . htmlspecialchars($entry['client']) . "<br>";
            echo "Статус: " . htmlspecialchars($entry['status']) . "<br>";
            echo "</li><br>";
        }
        echo "</ul>";
        echo '<a href="form.html">Перейти на создание заявки</a><br>';
        echo '<a href="index.php">Перейти на главную</a><br>';
    } else {
        // Выводим сообщение через alert, если заявок нет
        echo "<script>alert('Заявок пока нет.'); window.location.href = 'form.html';</script>";
    }
} else {
    // Выводим сообщение через alert, если файл не найден
    echo "<script>alert('Файл с заявками не найден.'); window.location.href = 'form.html';</script>";
}
?>
