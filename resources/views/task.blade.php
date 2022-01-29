<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<div class="text-center text-danger bg-dark">
            <h1>Tasks List</h1>
        </div>
      
    <div class="row">
        <div class="col-md-10 offset-md-1">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModalCenter">
  Add Task
</button>
<br /><br/>
            <table id="table" class="table table-bordered">
              <thead style="background-color:black; color:white;">
                <tr>
                  
                  <th>Id</th>
                  <th>Task</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody id="tablecontents" style="background-color:DarkSlateGrey; color:white; ">
                @foreach($posts as $post)
    	            <tr class="row1" data-id="{{ $post->id }}">
    	             
                      <td>{{$post->id}}</th>
    	              <td>{{ $post->title }}</td>
    	              <td>
                  <button type="button" class="btn btn-warning btn-xs openModal" data-id="{{ $post->id }}" data-status-text="{{ $post->name }}" data-toggle="modal" data-target="#myModal_{{$post->id}}">Edit</button> 
                  <div class="modal fade" id="myModal_{{$post->id}}" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button class="btn btn-deafult">Edit: #{{$post->id}}</button>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            
              </div>
      
          
              <div class="modal-body">
              
              <form class="form-group" action="/update-task/{{$post->id}}" method="post" id="editTaskForm_{{$post->id}}">
                @csrf 
                @method('PUT')
                  <input type="text" name="name" class="form-control" value="{{$post->title}}">
                
          </div>
          <div class="modal-footer">
          <button class="btn btn-primary waves-effect waves-light" type="submit" form="editTaskForm_{{$post->id}}">Update Task</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
            </form>
        </div>
    </div>
</div>
                </td> <td>
                  <form action="/delete-task/{{$post->id}}" method="POST">
                  @csrf
                  {{ method_field('DELETE') }} 
                  <button class="btn btn-danger" type="submit" 
                  onClick="return confirm('Do you really want to Delete it?')">Delete</button>
                  </form>
                  </td>
    	            </tr>
                @endforeach
              </tbody>                  
            </table>
            {{$posts->links()}}
            <hr>
            
    	</div>
    </div>
</div>

    <!-- Create Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{URL('/add-task')}}">
      @csrf
      <div class="modal-body">
        <div class="form-group">
    <label for="exampleInputEmail1">Add Task</label>
    <input type="text" class="form-control" placeholder="Enter Task Name" name="name">
  </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
        </form>
  </div>
</div>

    <!-- Create Modal end -->



    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <script type="text/javascript">
      $(function () {
       

        $( "#tablecontents" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });

          $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ url('post-sortable') }}",
                data: {
              order: order,
              _token: token
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
      });
    </script>
</body>
</html>