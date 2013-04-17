<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Authentication!</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript">
        function submitAjax (){ 
            $('#test').html('Loading...');
            $.ajax({ 
                    type: "POST",
                    url: "ajax.php",
                    data: { begin: "Kezdet", end: "Vég" },
                    success: function(data){
                         $('#test').html(data);                    
                    }
            });

        }
        </script>
    </head>
    <body>
        