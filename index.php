<?php
// Путь к файлу JSON
$file = 'applications.json';

// Проверяем, существует ли файл
if (file_exists($file)) {
    // Читаем содержимое файла
    $json_data = file_get_contents($file);
    // Преобразуем данные из JSON в массив
    $entries = json_decode($json_data, true);

    // Инициализация счетчиков
    $completed_count = 0;
    $total_time = 0;
    $issue_types = [];
    $current_date = date_create(date('Y-m-d'));

    // Перебираем все заявки
    foreach ($entries as $entry) {
        // Если заявка выполнена
        if ($entry['status'] === 'Выполнено') {
            $completed_count++;

            // Подсчитываем среднее время выполнения заявки
            $start_date = date_create($entry['date']);
            $completion_date = date_create($entry['completion_date']);
            $interval = date_diff($start_date, $completion_date);
            $total_time += $interval->days;
        }

        // Статистика по типам неисправностей
        $issue_type = $entry['issue_type'];
        if (!isset($issue_types[$issue_type])) {
            $issue_types[$issue_type] = 1;
        } else {
            $issue_types[$issue_type]++;
        }
    }

    // Вычисление среднего времени выполнения
    $average_time = ($completed_count > 0) ? ($total_time / $completed_count) : 0;

    // Вывод статистики
    echo "<h2>Статистика</h2>";
    echo "<p>Количество выполненных заявок: $completed_count</p>";
    echo "<p>Среднее время выполнения заявки: " . round($average_time, 2) . " дней</p>";

    echo "<h3>Типы неисправностей:</h3>";
    echo "<ul>";
    foreach ($issue_types as $type => $count) {
        echo "<li>$type: $count</li>";
    }
    echo "</ul>";
    echo '<a href="form.html">Перейти на создание заявки</a>';

} else {
    // Если файл не найден
    echo "<p>Файл с заявками не найден.</p>";
}
?>
