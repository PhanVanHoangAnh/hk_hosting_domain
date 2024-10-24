<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel='stylesheet' id='bootstrap-css' href='https://hoangkhang.com.vn/wp-content/themes/tanda/css/bootstrap.min.css?ver=6.4.3' media='all'/>
    
    <!-- Include jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        :root {
            --primary: #22539F;
            --danger: #E74C3C;
        }
        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
        .text-primary {
            color: var(--primary) !important;
        }
        .btn-danger {
            background-color: var(--danger) !important;
            border-color: var(--danger) !important;
        }

        .text-danger {
            color: var(--danger) !important;
        }

        body {
            background: white;
            color: black;
        }
    </style>
</head>
<body>
    @yield('content')

    <!-- You can add your custom scripts here -->
    <script>
        $(document).ready(function() {
            // Your jQuery code here
            console.log("jQuery is ready!");
        });
    </script>
</body>
</html>
