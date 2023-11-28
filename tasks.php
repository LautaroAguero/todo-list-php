<?php
    require_once 'Task.php';
    require_once 'ContactTask.php';
    require_once 'ProcessTask.php';
    require_once 'ReminderTask.php';

    $tasks = json_decode(file_get_contents('tasks.json'), true);
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['taskName'], $_POST['taskType'])) {  
            $taskName = $_POST['taskName'];
            $taskType = $_POST['taskType'];

            switch ($taskType) {
                case 'contact':
                    $task = new ContactTask($taskName, $_POST['contactName'], $_POST['contactReason'], $_POST['contactPhone'], $_POST['contactEmail']);
                    break;
                case 'process':
                    $task = new ProcessTask($taskName, $_POST['subtaskName']);                                    
                    break;
                case 'reminder':
                    $task = new ReminderTask($taskName, $_POST['reminderDescription'], $_POST['reminderDateTime']);
                    break;
            }

            $tasks[] = serialize($task);            
            $json = json_encode($tasks);
        } else if (isset($_POST['delete'])) {
            $task_id = $_POST['task_id'];
            deleteTask($task_id);
            $json = json_encode($tasks);
        }

        file_put_contents('tasks.json', $json);        
    }

    function deleteTask($task_id) {
        global $tasks;        
        array_splice($tasks,$task_id,1);

    }

?>

