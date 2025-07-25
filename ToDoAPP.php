
<?php

const TASK_FILE = 'task.json';

function saveTasks(array$task):void
{ 
    file_put_contents(filename: TASK_FILE, data: json_encode(value: $tasks, flags: JSON_PRETTY_PRINT));
}

function lodeTask(){
    if(!file_exists(TASK_FILE)){
       return[] ;
    }
    $data  =  file_get_contents(TASK_FILE) ;
    return $data ?json_decode($data) : [] ;
}

$task = lodeTask();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
   if(isset($_POST[' task']) && !empty(trim($_POST[' task']))){
        $task [] = [
           "task" => htmlspecialchars(trim($_POST[' task'])),
           "done" => false
        ];
        saveTasks($task) ;
        header(' Location:' .$_SERVER['PHP_SELF']) ;
        exit ;
    } elseif (isset($_POST['toggle'])) {
        $index = $_POST['toggle'];
        if (isset($tasks[$index])) {
            $tasks[$index]['done'] = !$tasks[$index]['done'];
            savetasks($tasks);
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['delet'])) {
        unset($tasks[$_POST['delet']]);
        $task= array_values(array : $tasks);
        saveTasks($tasks);
        header('Location :' .$_SERVER[PHP_SELF]);
        exit ;

    }
}
?>



<!-- UI -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
    <style>
        body {
            margin-top: 20px;
        }
        .task-card {
            border: 1px solid #ececec; 
            padding: 20px;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        }
        .task{
            color: #888;
        }
        .task-done {
            text-decoration: line-through;
            color: #888;
        }
        .task-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        ul {
            padding-left: 20px;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="task-card">
            <h1>To-Do App</h1>

            <!-- Add Task Form -->
            <form method="POST">
                <div class="row">
                    <div class="column column-75">
                        <input type="text" name="task" placeholder="Enter a new task" required>
                    </div>
                    <div class="column column-25">
                        <button type="submit" class="button-primary">Add Task</button>
                    </div>
                </div>
            </form>

            <!-- Task List -->
            <h2>Task List</h2>
            <ul style="list-style: none; padding: 0;">
                <!-- TODO: Loop through tasks array and display each task with a toggle and delete option -->
                <!-- If there are no tasks, display a message saying "No tasks yet. Add one above!" -->
                <?php if(empty($task)) : ?>
                <li>No tasks yet. Add one above!</li>
                <?php else : ?>
                    <?php foreach($task as $index => $task) : ?>
                    <!-- if there are tasks, display each task with a toggle and delete option -->
                 
                    
                        <li class="task-item">
                            <form method="POST" style="flex-grow: 1;">
                                <input type="hidden" name="toggle" value="<?= $index ?>">
                           
                            <button type="submit" sgind: none; cursor: pointer; text-align: left; width: 100%;">
                        <span class=" <?= $task ['done'] ? 'task-done' : 'task' ?>">
                        <?= htmlspecialchars(string: $task[ 'task']) ?>
                        </span>
                    </button>
                     </form>

                     <form method="POST">
                <input type="hidden" name="delete" value="">
                <button type="submit" class="button button-outline" style="margin-left: 10px;">Delete</button>
                     </form>
                        </li>
                <?php endforeach; ?>
                <?php endif; ?>

            </ul>

        </div>
    </div>   
<!-- Code injected by live-server -->
<script>
    // <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>

</body>
</html>