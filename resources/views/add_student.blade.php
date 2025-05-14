@extends('index')
@section('content-wrapper')

<div class="card  bg-light">
    <article class="card-body mx-auto " style="max-width: 40rem;">
        <h4 class="card-title mt-3 text-center">ADD NEW STUDENT</h4>
        <div id="frm">
            <!-- //class="mx-auto" -->
            <div class="form-group input-group" style="width:20rem;">
                <input name="" class="form-control" id="student_name" placeholder="Student Name">
            </div> <!-- form-group// -->
            <div class="form-group input-group">

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
            </div> <!-- form-group// -->
            <div class="form-group input-group">

                <select class="form-select form-control" id="class_teacher" aria-label="Default select example">
                    <option selected=""> Select Teacher</option>
                </select>
            </div> 
            <div class="form-group input-group">
                <input type="date" class="form-control" id="admission_date" placeholder="Admission Date">
            </div>
            <div class="form-group input-group">
                <input type="text" class="form-control" id="yearly_fee" placeholder="Yearly fees">
            </div>

            <div class="form-group">
                <button id="butsave" class="btn btn-primary btn-block"> Sumbit </button>
                
            </div> <!-- form-group// -->

        </div>
    </article>
</div> <!-- card.// -->

</div>

@endsection
@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {



        $('#butsave').on('click', function() {
            
            var st_name = $('#student_name').val();
            var class_name = $('#class_name').val();

            var class_teacher = $('#class_teacher').val();
            var admission_date = $('#admission_date').val();
            var yearly_fee = $('#yearly_fee').val();
        

            if (st_name != "" && class_name != "" && class_teacher != "" && admission_date != "" && yearly_fee != "") {
                //   $("#butsave").attr("disabled", "disabled");
                let formdata = new FormData();
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
                        // alert(formdata);
                        alert(response.message);
                        window.location.reload();
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
        });
    });
</script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

@endsection