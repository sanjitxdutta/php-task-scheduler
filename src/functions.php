<?php

function readJsonFile($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }
    $content = file_get_contents($filePath);
    return json_decode($content, true) ?: [];
}

function writeJsonFile($filePath, $data) {
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}

function addTask($task_name) {
    $file = __DIR__ . '/tasks.txt';
    $tasks = readJsonFile($file);

    foreach ($tasks as $task) {
        if (strtolower($task['name']) === strtolower($task_name)) {
            return false;
        }
    }

    $tasks[] = [
        "id" => uniqid(),
        "name" => $task_name,
        "completed" => false
    ];

    writeJsonFile($file, $tasks);
    return true;
}

function getAllTasks() {
    $file = __DIR__ . '/tasks.txt';
    return readJsonFile($file);
}

function markTaskAsCompleted($task_id, $is_completed) {
    $file = __DIR__ . '/tasks.txt';
    $tasks = readJsonFile($file);
    foreach ($tasks as &$task) {
        if ($task['id'] === $task_id) {
            $task['completed'] = $is_completed;
            writeJsonFile($file, $tasks);
            return true;
        }
    }
    return false;
}

function deleteTask($task_id) {
    $file = __DIR__ . '/tasks.txt';
    $tasks = readJsonFile($file);
    $tasks = array_filter($tasks, fn($task) => $task['id'] !== $task_id);
    writeJsonFile($file, array_values($tasks));
    return true;
}

function generateVerificationCode() {
    return strval(rand(100000, 999999));
}

function subscribeEmail($email) {
    $pendingFile = __DIR__ . '/pending_subscriptions.txt';
    $pending = readJsonFile($pendingFile);
    $code = generateVerificationCode();

    $pending[$email] = [
        "code" => $code,
        "timestamp" => time()
    ];
    writeJsonFile($pendingFile, $pending);

    $link = "http://localhost:8000/verify.php?email=" . urlencode($email) . "&code=$code";
    $subject = "Verify subscription to Task Planner";
    $message = "<p>Click the link below to verify your subscription to Task Planner:</p>
<p><a id='verification-link' href='$link'>Verify Subscription</a></p>";
    $headers = "MIME-Version: 1.0\r\nContent-type:text/html;charset=UTF-8\r\nFrom: no-reply@example.com\r\n";

    return mail($email, $subject, $message, $headers);
}

function verifySubscription($email, $code) {
    $pendingFile = __DIR__ . '/pending_subscriptions.txt';
    $subFile = __DIR__ . '/subscribers.txt';
    $pending = readJsonFile($pendingFile);

    if (!isset($pending[$email]) || $pending[$email]['code'] !== $code) {
        return false;
    }

    unset($pending[$email]);
    writeJsonFile($pendingFile, $pending);

    $subscribers = readJsonFile($subFile);
    if (!in_array($email, $subscribers)) {
        $subscribers[] = $email;
        writeJsonFile($subFile, $subscribers);
    }

    return true;
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/subscribers.txt';
    $subscribers = readJsonFile($file);
    $subscribers = array_values(array_filter($subscribers, fn($sub) => $sub !== $email));
    writeJsonFile($file, $subscribers);
    return true;
}

function sendTaskReminders() {
    $tasks = getAllTasks();
    $pending_tasks = array_filter($tasks, fn($task) => !$task['completed']);
    $pending_names = array_map(fn($task) => $task['name'], $pending_tasks);

    if (empty($pending_names)) return;

    $file = __DIR__ . '/subscribers.txt';
    $subscribers = readJsonFile($file);
    foreach ($subscribers as $email) {
        sendTaskEmail($email, $pending_names);
    }
}

function sendTaskEmail($email, $pending_tasks) {
    $unsubscribe_link = "http://localhost:8000/unsubscribe.php?email=" . urlencode($email);
    $subject = "Task Planner - Pending Tasks Reminder";
    $message = "<h2>Pending Tasks Reminder</h2>
<p>Here are the current pending tasks:</p>
<ul>";
    foreach ($pending_tasks as $task) {
        $message .= "<li>" . htmlspecialchars($task) . "</li>";
    }
    $message .= "</ul>
<p><a id='unsubscribe-link' href='$unsubscribe_link'>Unsubscribe from notifications</a></p>";

    $headers = "MIME-Version: 1.0\r\nContent-type:text/html;charset=UTF-8\r\nFrom: no-reply@example.com\r\n";
    return mail($email, $subject, $message, $headers);
}
