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
           $("#tasks > tbody").append("<tr><td>" + task['task'] + "</td><td>" + task['due'] + "</td><td><a class='btn edit-task'>Edit</a> <a class='btn del-task'>Delete</a></td></tr>");
       });
       return false;
   });

   $('.edit-task').click(function(e) {
        e.preventDefault();
        var taskid = $(this).parent().parent().attr('id').split('-')[1];
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
