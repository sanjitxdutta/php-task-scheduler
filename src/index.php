<?php
require_once __DIR__ . '/functions.php';

// Handle task submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task-name'])) {
        addTask(trim($_POST['task-name']));
    }

    if (isset($_POST['task-complete'])) {
        markTaskAsCompleted($_POST['task-complete'], true);
    }

    if (isset($_POST['task-uncomplete'])) {
        markTaskAsCompleted($_POST['task-uncomplete'], false);
    }

    if (isset($_POST['task-delete'])) {
        deleteTask($_POST['task-delete']);
    }

    if (isset($_POST['email'])) {
        subscribeEmail(trim($_POST['email']));
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$tasks = getAllTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Scheduler</title>
    <style>
        .task-item.completed {
            text-decoration: line-through;
            color: gray;
        }
    </style>
</head>
<body>
    <h1>Task Scheduler</h1>

    <!-- Add Task Form -->
    <form method="POST">
        <input type="text" name="task-name" id="task-name" placeholder="Enter new task" required>
        <button type="submit" id="add-task">Add Task</button>
    </form>

    <!-- Task List -->
    <ul class="tasks-list">
        <?php foreach ($tasks as $task): ?>
            <li class="task-item <?= $task['completed'] ? 'completed' : '' ?>">
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="<?= $task['completed'] ? 'task-uncomplete' : 'task-complete' ?>" value="<?= $task['id'] ?>">
                    <input type="checkbox" class="task-status" onchange="this.form.submit()" <?= $task['completed'] ? 'checked' : '' ?>>
                    <?= htmlspecialchars($task['name']) ?>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="task-delete" value="<?= $task['id'] ?>">
                    <button class="delete-task" type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Subscribe Form -->
    <h2>Subscribe to Email Reminders</h2>
    <form method="POST">
        <input type="email" name="email" required>
        <button id="submit-email">Submit</button>
    </form>
</body>
</html>
