<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a43ceed218.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <title>University Student Management CRUD Application...</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head')

    <style>
        /* Set the height of the wrapper div to 100% of the viewport */
        html,
        body {
            height: 100%;
            width: 100%;
        }

        /* Style the footer */
        .footer {
            background-color: #f8f9fa;
            /* padding: 20px; */
            position: fixed;
            bottom: 0;
            left: 0;
            /* width: 100%; */
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Student Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

            <ul class="navbar-nav mr-auto">
                <a class="nav-item nav-link active" href="/">Add Student<span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="/show_student">Show Student</a>
            </ul>
        </div>




    </nav>
    <div class="container mt-4">
        <div class="content-wrapper">
            @yield('content-wrapper')
        </div>

    </div>

    @yield('javascript')
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

   <script type="text/javascript">
        
        $(document).ready(function() {
            
            $.ajax({
                url: "/fetchteacher",
                method: "get",
                timeout: 0,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(res) {
                    const selectElement = document.getElementById('class_teacher');
                    selectElement.innerHTML = '';

                    let option = document.createElement('option');
                    option.selected = true;
                    option.textContent = "Select Teacher";
                    selectElement.appendChild(option);

                    res.data.forEach(teacher => {
                        option = document.createElement('option');
                        option.value = teacher.id;
                        option.textContent = teacher.teacher_name;
                        selectElement.appendChild(option);
                    });

                },
                error: function(res) {
                    const selectElement = document.getElementById('class_teacher');
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = "No teacher added";
                    selectElement.appendChild(option);
                }

            });



        });
    </script>

</body>

</html>