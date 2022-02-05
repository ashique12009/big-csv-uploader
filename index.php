<!DOCTYPE html>
<html>
    <head>
        <title>How to Import Large CSV File in Multiple Mysql table</title>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
<body>
    <br />
    <br />
    <div class="container">
        <h1 align="center">How to Import Large CSV File in Multiple Mysql table</h1>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Import Large CSV File Data into Multiple Table</h3>
            </div>
            <div class="panel-body">
                <span id="message"></span>
                <form id="sample_form" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group">
                    <label class="col-md-4 control-label">Select CSV File</label>
                    <input type="file" name="file" id="file" accept=".csv" />
                    </div>
                    <div class="form-group" align="center">
                    <input type="hidden" name="hidden_field" value="1" />
                    <input type="submit" name="import" id="import" class="btn btn-info" value="Import" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
$(document).ready(function() {
    $('#sample_form').on('submit', function(event) { 
        $('#message').html('');
        event.preventDefault();
        $.ajax({
            url: "import.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#message').html('<div class="alert alert-success">'+data.success+'</div>');
                $('#sample_form')[0].reset();
            }
        });
    });
});
</script>