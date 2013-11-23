$().ready(function() {
   $('#add-form').hide();
   $('#due').datepicker();
   $('#add-task').click(function(e) {
        e.preventDefault();
        $('#add-form').show();
        $('#add-task').toggle();
   });

   $('#new-task').submit(function(e) {
       e.preventDefault();
       $('#add-form').hide();
       $('#add-task').toggle();
       $.post('ajax.php', $(this).serialize(), function(data) {
           var task = JSON.parse(data);
           $("#tasks > tbody").append("<tr><td class='task-name'>" + task['task'] + "</td><td class='task-due'>" + task['due'] + "</td><td><a class='btn edit-task'>Edit</a> <a class='btn del-task'>Delete</a></td></tr>");
       });
       return false;
   });

   $('.edit-task').click(function(e) {
        e.preventDefault();
        var row = $(this).parent().parent();
        var taskid = row.attr('id').split('-')[1];

        var task = row.find('.task-name');
        var due = row.find('.task-due');

        task.html('<input type="text" class="task-name" value="' + task.html() + '" />');

        var dueElement = $('<input type="text" class="task-due" value="' + due.html() + '" />');
        dueElement.datepicker({
            'dateFormat': "yy-mm-dd"
        });
        due.html(dueElement);

        row.find('.edit-task').toggle();
        row.find('.actions').prepend('<a class="btn save-task">Save</a>');
        row.find('.actions').append(' <a class="btn cancel-edit">Cancel</a>');
   });

   $(document).on('click', '.cancel-edit', function(e) {
        e.preventDefault();
        var row = $(this).parent().parent();

        var task = $(row).find('.task-name input').attr('value');
        var due = $(row).find('.task-due input').attr('value');
        $(row).find('.task-name').html(task);
        $(row).find('.task-due').html(due);
        row.find('.cancel-edit').remove();
        row.find('.save-task').remove();
        row.find('.edit-task').toggle();
   });

   $(document).on('click', '.save-task', function(e) {
        e.preventDefault();
        var row = $(this).parent().parent();
        var taskid = row.attr('id').split('-')[1];
        var task = $(row).find('.task-name input').attr('value');
        var due = $(row).find('.task-due input').attr('value');
        var data = {
            'action': 'update',
            'task': task,
            'due': due,
            'id': taskid
        }
        $.post('ajax.php', data, function(data) {
            $(row).find('.task-name').html(task);
            $(row).find('.task-due').html(due);
            row.find('.cancel-edit').remove();
            row.find('.save-task').remove();
            row.find('.edit-task').toggle();
        });
   });

   $('.del-task').click(function(e) {
        e.preventDefault();
        var taskid = $(this).parent().parent().attr('id').split('-')[1];
        var data = {
            'action': 'delete',
            'id': taskid
        }
        $.post('ajax.php', data, function(data) {
            $('#task-' + taskid).hide();
            $('#task-' + taskid).remove();
        });
   });
});
