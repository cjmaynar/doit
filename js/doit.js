$().ready(function() {
   $('#add-form').hide();
   $('#due').datepicker();

   //Show the form to create a new task
   $('#add-task').click(function(e) {
        e.preventDefault();
        $('#add-form').toggle();
        $('#add-task').toggle();
   });

   //Hide the add form, and show the Add Task button
   $('#cancel-create').click(function(e) {
       e.preventDefault();
       $('#add-form').toggle();
       $('#add-task').toggle();
   });

   //Perform an AJAX call to add the task to the DB, then
   //write the DOM for it to the table.
   $('#new-task').submit(function(e) {
       e.preventDefault();

       if ($("#task").val() === '' || $("#due").val() === '') {
           alert("You must fill in the form to create a task");
           return false;
       }

       $('#add-form').hide();
       $('#add-task').toggle();
       $.post('ajax.php', $(this).serialize(), function(data) {
           var task = JSON.parse(data);
           $("#tasks > tbody").append("<tr id='task-" + task.id + "'><td class='task-name'>" + task.task + "</td><td class='task-due'>" + task.due + "</td><td class='actions'><a class='btn btn-success complete-task'>Complete</a> <a class='btn edit-task'>Edit</a> <a class='btn btn-danger del-task'>Delete</a></td></tr>");
           $("#task").val('');
           $("#due").val('');
       });
       return false;
   });

   //On edit click convert the text to inline editable fields
   $(document).on('click', '.edit-task', function(e) {
        e.preventDefault();
        var row = $(this).parent().parent();
        var task = row.find('.task-name');
        var due = row.find('.task-due');

        task.html('<input type="text" class="task-name" value="' + task.html() + '" />');

        //create the dueElement as a jQuery object to allow
        //datepicker to be attached to it
        var dueElement = $('<input type="text" class="task-due" value="' + due.html() + '" />');
        dueElement.datepicker();
        due.html(dueElement);

        row.find('.edit-task').toggle();
        row.find('.complete-task').toggle();
        row.find('.actions').prepend(' <a class="btn cancel-edit">Cancel</a>');
        row.find('.actions').prepend('<a class="btn btn-primary save-task">Save</a>');
   });

   //On cancel click restore the row to the original
   $(document).on('click', '.cancel-edit', function(e) {
        e.preventDefault();
        var row = $(this).parent().parent();
        var task = row.find('.task-name input').attr('value');
        var due = row.find('.task-due input').attr('value');

        row.find('.task-name').html(task);
        row.find('.task-due').html(due);
        row.find('.cancel-edit').remove();
        row.find('.save-task').remove();
        row.find('.edit-task').toggle();
        row.find('.complete-task').toggle();
   });

   //On save send an AJAX call out to update the task with
   //the new information
   $(document).on('click', '.save-task', function(e) {
        e.preventDefault();
        var row = $(this).parent().parent();
        var taskid = row.attr('id').split('-')[1];
        var task = row.find('.task-name input').val();
        var due = row.find('.task-due input').val();

        if (task === '') {
            alert("There must be a task");
            return false;
        }

        var data = {
            'action': 'edit',
            'task': task,
            'due': due,
            'id': taskid
        };
        $.post('ajax.php', data, function(data) {
            data = JSON.parse(data);
            row.find('.task-name').html(data.task);
            row.find('.task-due').html(data.due);
            row.find('.cancel-edit').remove();
            row.find('.save-task').remove();
            row.find('.edit-task').toggle();
            row.find('.complete-task').toggle();
        });
   });

   //On delete perform an AJAX call to remove the task,
   //and then remove the DOM
   $(document).on('click', '.del-task', function(e) {
        e.preventDefault();
        var taskid = $(this).parent().parent().attr('id').split('-')[1];
        var data = {
            'action': 'delete',
            'id': taskid
        };
        $.post('ajax.php', data, function(data) {
            $('#task-' + taskid).hide();
            $('#task-' + taskid).remove();
        });
   });

   //On complete make a AJAX call to complete the task,
   //and then remove the DOM
   $(document).on('click', '.complete-task', function(e) {
       e.preventDefault();
       var taskid = $(this).parent().parent().attr('id').split('-')[1];
       var data = {
           'action': 'complete',
           'id': taskid
       };
       $.post('ajax.php', data, function(data) {
           $('#task-' + taskid).hide();
           $('#task-' + taskid).remove();
       });
   });
});
