<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>To Do List PHP</title>
</head>
<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">    
                <div class="col col-lg-9 col-xl-7">    
                    <div class="card rounded-3">
                        <div class="card-body p-4"> 
                            <?php include('tasks.php') ?>       
                            <h4 class="text-center my-3 pb-3">To Do App</h4>

                            <form id="loadTask" method="POST" class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                                <div class="col-12 mb-4">
                                    <div class="form-outline mb-4">
                                        <input type="text" id="taskName" name="taskName" class="form-control" placeholder="Ingresa aqui la tarea" required/>                                        
                                    </div>
                                    <div class="form-outline">                                        
                                        <select id="taskType" name="taskType" class="form-control" required>
                                            <option value="" selected disabled>Seleccione el tipo de tarea</option>                                            
                                            <option value="contact">Tarea de contacto</option>
                                            <option value="process">Tarea de proceso</option>
                                            <option value="reminder">Tarea de recordatorio</option>
                                        </select>                                        
                                    </div>
                                </div>
                                <!-- Formulario para Tarea de Contacto -->
                                <div id="contactFields" style="display: none">
                                    <input type="text" id="contactName" name="contactName" class="form-control" placeholder="Nombre de la persona" />
                                    <input type="text" id="contactReason" name="contactReason" class="form-control" placeholder="Razón para contactar" />
                                    <input type="text" id="contactPhone" name="contactPhone" class="form-control" placeholder="Número de teléfono" />
                                    <input type="email" id="contactEmail" name="contactEmail" class="form-control" placeholder="Correo electrónico" />
                                </div>

                                <!-- Formulario para Tarea de Proceso -->
                                <div id="processFields" style="display: none">
                                    <div id="subtasks">                                        
                                        <input type="text" id="subtaskName0" name="subtaskName[]" class="form-control" placeholder="Nombre de la subtarea" />                                        
                                    </div>
                                    <button type="button" id="addSubtask" class="btn btn-primary mt-2">Agregar subtarea</button>
                                    <button type="button" id="removeSubtask" class="btn btn-primary mt-2">Eliminar subtarea</button>                                   
                                </div>

                                <!-- Formulario para Tarea de Recordatorio -->
                                <div id="reminderFields" style="display: none">
                                    <input type="text" id="reminderDescription" name="reminderDescription" class="form-control" placeholder="Descripción" />
                                    <input type="datetime-local" id="reminderDateTime" name="reminderDateTime" class="form-control" />
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>                                                        
                            </form>
                            <table class="table mb-4">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Todo</th>
                                        <th scope="col">Tipo</th>                                        
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $id = 0 ?>
                                    <?php foreach($tasks as $task): ?>
                                        <?php $taskObj = unserialize($task); ?>
                                        <tr>
                                            <th scope="row"><?php echo $id+1?></th>
                                            <td><?php echo $taskObj->getName(); ?></td>
                                            <td><?php echo $taskObj->gettype(); ?></td>                                            
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name= "delete">
                                                    <input  type="hidden" name="task_id" value="<?php echo $id?>">
                                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                                    <button type="submit" class="btn btn-success ms-1">Finalizado</button> 
                                                    <button type="button" class="btn btn-info ms-1" data-toggle="modal" data-target="#taskDetailsModal" onclick="showDetails(<?php echo $id?>)">Detalles</button>                                                                                                     
                                                </form>    
                                            </td>
                                        </tr>                                        
                                        <?php $id++?>
                                    <?php endforeach;?>
                                </tbody>
                            </table>                            
                        </div>
                    </div>            
                </div>    
            </div>    
        </div>            
    </section>
    <!-- Modal de detalles de la tarea -->
    <div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskDetailsModalLabel">Detalles de la tarea</h5>                    
                </div>
                <div class="modal-body" id="taskDetails">
                    <!-- Los detalles de la tarea se llenarán aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>     
</body>
<script>
    var tasks = <?php echo json_encode(array_map(function($task) {
        $taskObj = unserialize($task);

        $taskArray = [
        'name' => $taskObj->getName(),
        'type' => $taskObj->getType(),
    ];

    switch ($taskObj->getType()) {
        case 'process':
            $taskArray['subtasks'] = $taskObj->getSubtasks();
            break;

        case 'contact':
            $taskArray['contactName'] = $taskObj->getContactName();
            $taskArray['contactReason'] = $taskObj->getContactReason();
            $taskArray['contactPhone'] = $taskObj->getContactPhone();
            $taskArray['contactEmail'] = $taskObj->getContactEmail();
            break;

        case 'reminder':
            $taskArray['reminderDescription'] = $taskObj->getReminderDescription();
            $taskArray['reminderDateTime'] = $taskObj->getReminderDateTime();
            break;

        // Agrega más casos aquí para otros tipos de tareas
    }

    return $taskArray;
        

    }, $tasks)); ?>;

    console.log(tasks);

    function showDetails(taskId) {        
        var task = tasks[taskId];        
        var details = 'Nombre: ' + task.name + '<br/>';
        details += 'Tipo: ' + task.type + '<br/>';
        
        
        switch (task.type) {
        case 'process':
            var subtasksList = '<ul>' + task.subtasks.map(function(subtask) {
            return '<li>' + subtask + '</li>';
            }).join('') + '</ul>';
            details += 'Subtareas: ' + subtasksList + '<br/>';
            break;

        case 'contact':
            details += 'Nombre de contacto: ' + task.contactName + '<br/>';
            details += 'Razón de contacto: ' + task.contactReason + '<br/>';
            details += 'Teléfono de contacto: ' + task.contactPhone + '<br/>';
            details += 'Email de contacto: ' + task.contactEmail + '<br/>';
            break;

        case 'reminder':
            details += 'Descripción del recordatorio: ' + task.reminderDescription + '<br/>';
            details += 'Fecha y hora del recordatorio: ' + task.reminderDateTime + '<br/>';
            break;       
        }
               
        document.getElementById('taskDetails').innerHTML = details;
    }

    document.getElementById('taskType').addEventListener('change', function() {
        // Ocultar todos los campos
        document.getElementById('contactFields').style.display = 'none';
        document.getElementById('processFields').style.display = 'none';
        document.getElementById('reminderFields').style.display = 'none';

        // Mostrar los campos correspondientes a la opción seleccionada
        switch (this.value) {
            case 'contact':
                document.getElementById('contactFields').style.display = 'block';
                break;
            case 'process':
                document.getElementById('processFields').style.display = 'block';
                break;
            case 'reminder':
                document.getElementById('reminderFields').style.display = 'block';
                break;
        }
    });


    document.getElementById('addSubtask').addEventListener('click', function() {
        var subtasksDiv = document.getElementById('subtasks');
        var subtaskCount = subtasksDiv.getElementsByTagName('input').length / 2;

        var nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.id = 'subtaskName' + subtaskCount;
        nameInput.name = 'subtaskName[]';
        nameInput.className = 'form-control';
        nameInput.placeholder = 'Nombre de la subtarea';   
        
        
        subtasksDiv.appendChild(nameInput);       
    });

    document.getElementById('removeSubtask').addEventListener('click', function() {
        var subtasksDiv = document.getElementById('subtasks');
        var inputs = subtasksDiv.getElementsByTagName('input');

        if (inputs.length > 0) {            
            subtasksDiv.removeChild(inputs[inputs.length - 2]); // Elimina el último campo de nombre
        }
    });
</script>
</html>
