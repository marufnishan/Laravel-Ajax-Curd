<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Laravel 8 Ajax Curd Application</title>
</head>

<body>
    <section style="padding-top: 60px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Students <a href="#" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#studentModal">Add New Student</a>
                        </div>
                        <div class="card-body">
                            <table id="studentTable" class="table">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr id="sid{{$student->id}}">
                                        <td>{{$student->firstname}}</td>
                                        <td>{{$student->lastname}}</td>
                                        <td>{{$student->email}}</td>
                                        <td>{{$student->phone}}</td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="editStudent({{ $student->id }})" class="btn btn-info">Edit</a>
                                            <a href="javascript:void(0)" onclick="deleteStudent({{ $student->id }})" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add New Student Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  id="studentForm">
                        @csrf
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone">
                        </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">Submit</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New Student Modal -->


    <!-- Edit Student Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form  id="studentEditForm">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" id="editfirstname">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" id="editlastname">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="editemail">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="editphone">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
        <script>
            $("#studentForm").submit(function(e){
                e.preventDefault();
                let firstname = $("#firstname").val();
                let lastname = $("#lastname").val();
                let email = $("#email").val();
                let phone = $("#phone").val();
                let _token = $("input[name=_token]").val();

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('[name="_token"]').val()
                        }
                });

                $.ajax({
                    url: '{{route('student.add')}}',
                    type: "POST",
                    data : {
                        firstname:firstname,
                        lastname:lastname,
                        email:email,
                        phone:phone,
                        _token:_token
                    },

                    success:function(response)
                    {
                        if(response)
                        {
                            $("#studentTable tbody").prepend('<tr> <td>'+ response.firstname +'</td> <td>'+ response.lastname +'</td> <td>'+ response.email +'</td> <td>'+ response.phone +'</td> </tr>');
                            $("#studentForm")[0].reset();
                            $("#studentModal").modal('hide');
                        }
                    }
            });
            });
        </script>

<script>
    function editStudent(id){
        $.get('/students/'+id, function(response){
            $('#id').val(response.id);
            $('#editfirstname').val(response.firstname);
            $('#editlastname').val(response.lastname);
            $('#editemail').val(response.email);
            $('#editphone').val(response.phone);
            $('#editModal').modal('toggle');
        });
    }

    // For update 
    $('#studentEditForm').submit(function(e){
        e.preventDefault();

        let id = $("#id").val();
        let firstname = $("#editfirstname").val();
        let lastname = $("#editlastname").val();
        let email = $("#editemail").val();
        let phone = $("#editphone").val();
        let _token = $("input[name=_token]").val();

        $.ajax({
            url: "{{route('student.update')}}",
            type: "POST",
            data:{
                id:id,
                firstname:firstname,
                lastname:lastname,
                email:email,
                phone:phone,
                _token:_token
            },

            success:function(response){
                $('#sid' + response.id +'td:nth-child(1)').text(response.firstname);
                $('#sid' + response.id +'td:nth-child(2)').text(response.lastname);
                $('#sid' + response.id +'td:nth-child(3)').text(response.email);
                $('#sid' + response.id +'td:nth-child(4)').text(response.phone);
                $('#editModal').modal('toggle');
                $('#studentEditForm')[0].reset();
                $("#editModal").modal('hide');
                window.location.href = "{{route('student.show')}}";
            }
        });
    });
</script>

<script>
    function deleteStudent(id)
    {
        if(confirm('Do you realy want to delete record?'))
        {
            $.ajax({
                url:"/students/"+id,
                type:'POST',
                data:{
                    _token: $('input[name=_token]').val()
                },
                success:function(response){
                    $("#sid"+id).remove();
                }
            });
        }
    }
</script>
</body>

</html>
