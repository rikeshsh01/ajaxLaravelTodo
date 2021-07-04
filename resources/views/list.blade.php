<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax Todo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <br>
    <div class="card" >
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-3 col-lg-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">Ajax Todo List <a href="" id="addNew" class="pull-right" data-toggle="modal" data-target="#Modal"><i class="fas fa-plus"></i></a></div>
                    <div class="panel-body" id="listLoad">
                        <ul class="list-group">
                          @foreach ($list as $item)
                            <li class="list-group-item listItem " data-id="{{$item->id}}" data-toggle="modal" data-target="#Modal">{{$item->todo}}</li>
                          @endforeach
                        </ul>
                    </div>
                  </div>
                </div>

                <div class="col-lg-2">
                  <input type="text" class="form-control" id="searchItem" name="search" placeholder="Search here...">
            
                </div>
            </div>
            
        </div>
        
    </div>

    


    <div class="container">
        <div class="modal" id="Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="title">Add new todo</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p><input type="text" id="addItem" name="todo" class="form-control" placeholder="Enter your task"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none">Delete</button>
                  <button type="button" class="btn btn-primary" id="saveChanges" style="display: none" data-dismiss="modal" >Save Changes</button>
                  <button type="button" class="btn btn-primary" id="addTask" data-dismiss="modal">Add Task</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
    </div>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>
</html>

<script>
    $(document).ready(function(){
      $(document).on('click','.listItem',function(){
                var text=$(this).text();
                $('#title').text('Edit Item');
                $('#Modal').data('recordId', $(this).data('id'));
                $('#addItem').val(text);
                $('#delete').show();
                $('#saveChanges').show();
                $('#addTask').hide();
        });

        $(document).on('click','#addNew',function(){
            $('#title').text('Add new todo');
            $('#addItem').val("");
            $('#delete').hide();
            $('#saveChanges').hide();
            $('#addTask').show();
        });

        $('#addTask').click(function(){
          var text=$('#addItem').val();
          console.log(text);
          var token = "{{ csrf_token() }}";
          var path = "{{route('addItem')}}";

          $.ajax({
              url: path,
              type: "POST",
              dataType: "JSON",
              data: {
                  text: text,
                  _token: token,
              },
              beforeSend: function() {
                  $('#addTask').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
              },
              complete:function(){
                $('#addTask').html('Add Task');

              },
              success: function(data){     
                console.log(data);  
                $('#listLoad').load(location.href + ' #listLoad' )  ;
                    
              }
          });
        });

        $(document).on('click','#delete',function(){
                var muid=$('#Modal').data('recordId');
                var token = "{{ csrf_token() }}";
                var path = "{{route('delete')}}";
                // alert(id)
                $.ajax({
                  url: path,
                  type: "POST",
                  dataType: "JSON",
                  data: {
                      id:muid,
                      _token: token,
                  },
                  success: function(data){     
                    console.log(data);  
                    $('#listLoad').load(location.href + ' #listLoad' )  ;
                        
                  }
              });
            
        });

        $(document).on('click','#saveChanges',function(){
                var muid=$('#Modal').data('recordId');
                var textt=$('#addItem').val();

                var token = "{{ csrf_token() }}";
                var path = "{{route('update')}}";
                // alert(id)
                $.ajax({
                  url: path,
                  type: "POST",
                  dataType: "JSON",
                  data: {
                      id:muid,
                      text:textt,
                      _token: token,
                  },
                  success: function(data){     
                    console.log(data);  
                    $('#listLoad').load(location.href + ' #listLoad' )  ;
                        
                  }
              });
            
        });
    });

    $( function() {
    $( "#searchItem" ).autocomplete({
      source: 'http://127.0.0.1:8000/search'
    });
  } );
</script>