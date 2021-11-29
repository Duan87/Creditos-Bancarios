<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="api/views/assets/js/import/jquery-3.3.1.min.js"></script>
    <script>
      function test(){
        $.post(
          'api/controllers/EmployeeController.php',
          {action:"pendingRequests",id:5},
          function(response){

            $("h1").html(response);
            response = $.parseJSON(response);
            console.log(response);
          }

        );
      }
    </script>
  </head>
  <body>
    <button onClick="test()">Test</button>
     <h1>Index</h1>
  </body>
</html>
