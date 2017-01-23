<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Client</title>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
    <h1>Add Client</h1>
    <input id="clientname" type="text" value="testwebsite" />
    <input id="addclient" type="button" name="addclient" value="Add Client" />
    {{csrf_token()}}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <script>
        $('#addclient').click(function()
            {
                var formData = {
                    'name'      : $('#clientname').val(),
                    
                };

                console.log(formData);
                //make a request to the server for the matching places

                $.ajax({
                    type: 'post',
                    url: '/oauth',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'requestData': formData
                    },
                    success: function(results)
                    {
                        console.log('stored:', results);
                    },
                    error: function (data)
                    {
                        console.log('Error in store:', data);
                        //document.write(data.responseText);
                    }
                });
            });
    </script>

</body>


<html>