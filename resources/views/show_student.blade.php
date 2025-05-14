@extends('index')
@section('content-wrapper')
<div class="row">
    <div class="col-sm-10">
        <h2 class="text-center">Students Details</h2>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered nowrap row-border table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Student Name</th>
                                <th class="text-center">Class Name</th>
                                <th class="text-center">Teacher</th>
                                <th class="text-center">Admission Date</th>
                                <th class="text-center">Yealy Fess</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="fetch-student">
                        </tbody>
                    </table>
                </div>
                <div id="loading" class="p-2 d-flex align-items-center flex-column">
                    <img src='https://media.tenor.com/cWhSRPC9900AAAAj/loading-black.gif' width="50px">
                            <p class="text-center text-muted p-2">&nbsp;&nbsp;&nbsp; Loading !!!</p>
                </div>

                <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Student Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm">
                                    <div class="form-group">
                                        <label for="name">Student Name:</label>
                                        <input type="text" class="form-control" id="student_name" name="student_name" val="">
                                    </div>
                                    <div class="form-group">
                                        <label for="priority">Class :</label>
                                        <select class="form-select form-control" id="class_name" aria-label="Default select example">
                                            <option selected="">Select Class</option>
                                            <option value="1">1th</option>
                                            <option value="2">2th</option>
                                            <option value="3">3th</option>
                                            <option value="4">4th</option>
                                            <option value="5">5th</option>
                                            <option value="6">6th</option>
                                            <option value="7">7th</option>
                                            <option value="8">8th</option>
                                            <option value="9">9th</option>
                                            <option value="10">10th</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="priority">Teacher :</label>
                                        <select class="form-select form-control" id="class_teacher" aria-label="Default select example">
                                            <option selected=""> Select Teacher</option>
                                            <option value="1">XYZ</option>
                                            <option value="2">ABC</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="Admission_date">Admission Date:</label>
                                        <input type="date" class="form-control" id="admission_date" placeholder="Admission Date">
                                    </div>
                                    <div class="form-group">
                                        <label for="yearly_fees">Yearly fees</label>
                                        <input type="text" class="form-control" id="yearly_fee" placeholder="Yearly fees">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="editsave">Save</button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
<!-- card.// -->


<!-- Optional JavaScript -->
@endsection
@section("javascript")

<script type="text/javascript">
    $(document).ready(function() {
        loaddetails();

    });



    function loaddetails() {
        $('#fetch-student').html();
        $.ajax({
            url: "/show-details",
            method: "GET",
            timeout: 0,
            success: function(data) {
                if (data.status === "success") {
                    let arr = data["data"];
                    if (arr.length > 0) {
                        let html = ``;
                        for (let i = 0; i < arr.length; i++) {
                            html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-center">${arr[i].student_name}</td>
                                <td class="text-center">${arr[i].class+"th"}</td>
                                <td class="text-center">${arr[i].tea_name}</td>
                                <td class="text-center">${arr[i].admission_date}</td>
                                <td class="text-center">${arr[i].yearly_fees}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" onclick="edit('${arr[i].id}');">Edit</button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" onclick="Delete('${arr[i].id}');">Delete</button>
                                </td>
                            </tr>`;
                        }


                        if ($.fn.DataTable.isDataTable('#example')) {
                            $('#example').DataTable().destroy();
                        }
                        $('#fetch-student').html(html);

                        $('#example').DataTable({
                            responsive: true
                        });



                    }
                } else {
                    alert("Failed to fetch data.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Fetch Error:", xhr.responseText);
                alert("Something went wrong.");
            }
        });
    }

    function edit(id) {

        $.ajax({
            url: '/fetch?id=' + id,
            method: "GET",
            timeout: 0,
            success: function(data) {
                if (data.status == "success") {
                    console.log(data);
                    let arr = data["data"];

                    document.getElementById("student_name").value = arr[0].student_name;
                    document.getElementById("class_name").value = arr[0].class;
                    document.getElementById("class_teacher").value = arr[0].class_teacher_id;
                    document.getElementById("admission_date").value = arr[0].admission_date;
                    document.getElementById("yearly_fee").value = arr[0].yearly_fees;
                    $('#editsave').on('click', function() {
                        update_details(id);
                    });

                }
            }
        });


    }

    function update_details(id) {
        var st_name = $('#student_name').val();
        var class_name = $('#class_name').val();

        var class_teacher = $('#class_teacher').val();
        var admission_date = $('#admission_date').val();
        var yearly_fee = $('#yearly_fee').val();


        if (st_name != "" && class_name != "" && class_teacher != "" && admission_date != "" && yearly_fee != "") {
            //   $("#butsave").attr("disabled", "disabled");
            let formdata = new FormData();
            formdata.append('id', id);
            formdata.append('student_name', st_name);
            formdata.append('class', class_name);
            formdata.append('class_teacher_id', class_teacher);
            formdata.append('admission_date', admission_date);
            formdata.append('yearly_fees', yearly_fee);

            $.ajax({
                url: "/add_edit",
                method: "POST",
                timeout: 0,
                data: formdata,
                dataType: 'json',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    alert(response.message);
                    loaddetails();
                    $('#editModal').modal('hide');

                },
                error: function(response) {
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        let messages = '';
                        $.each(errors, function(key, value) {
                            messages += value[0] + '\n';
                        });
                        alert(messages);
                    } else {
                        alert("Something went wrong.");
                    }
                }
            });
        } else {
            alert('Please fill all the field !');
        }
    }

    function Delete(id) {
        $.ajax({
            url: '/delete?id=' + id,
            method: "GET",
            timeout: 0,
            success: function(data) {
                if (data.status == "success") {
                    alert(data.message);
                }
                loaddetails();
            },
            error: function(data) {
                alert(data.message);
            }
        });

    }
</script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>