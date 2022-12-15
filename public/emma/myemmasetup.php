<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
    <style type="text/css">
        .form-wrapper {
            padding: 30px;
            margin: auto;
            position: relative;
        }
        p,
        label {
            font: 1rem 'Fira Sans', sans-serif;
        }

        input {
            margin: .4rem;
        }
        button {
            margin-top:20px;
        }
        #countdown {
            font-size: 30px;
            text-align: center;
            animation: auto;
            margin: 20px 0;
            float: left;
        }
        .active_emma {
            display: inline-block;
            position: absolute;
            text-align: center;
            margin: auto;
            right: 30px;
            bottom: -20px;
        }

    </style>
</head>
<body>
    <div class="container">
      <div class="row">
        <div class="form-wrapper">
            <div class="col-sm-12">
              <!-- Default form login -->
                <form action="#" method="get" name="myemmaform" onclick="return false" class="f-form text-center border border-light p-5" id="myemmaform">

                    <h1>Please enter the Client ID</h1>

                    <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="emma_clientid" name="emma_clientid" placeholder="">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-around">
                    </div>
                    <!-- Sign in button -->
                    <button class="btn btn-info btn my-4 myemma" type="submit">Create Emma</button>
                </form>
                <!-- Default form login -->
                <!-- Small modal -->
                <div class="modal fade bd-example-modal-sm id-valiation-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-body">
                          <p>Please enter the client ID</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal warning-modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-body">
                        <p></p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary create-now">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>    
        </div>
        
      </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.id-valiation-modal').modal('hide');
            jQuery('.warning-modal').modal('hide');
            jQuery(".myemma").click(function (e) {
                var cid = jQuery("#emma_clientid").val();
                var stripped = cid.replace(/[\-\ ]/g, '');

                if (jQuery("#emma_clientid").val() == '') {
                    jQuery('.id-valiation-modal').modal('show');
                    return;
                } else if (isNaN(parseInt(stripped))) {
                    jQuery('.id-valiation-modal .modal-body p').html("Please enter a valid Client ID");
                    jQuery('.id-valiation-modal').modal('show');
                    return;
                } else {
                    jQuery('.warning-modal .modal-body p').html("Please click 'Create' to launch Emma for #"+jQuery("#emma_clientid").val());
                    jQuery('.warning-modal').modal('show');
                }
                var formfields = jQuery('#myemmaform').serializeArray();
                // $.ajax({
                //     type: "POST",
                //     url: 'emma_setup.php',
                //     data: formfields,
                //     success: function (data) {
                //         jQuery(".form-wrapper").html(data);
                //     },
                //     cache: false,
                //     async: false
                // });
            });
        });
        jQuery(".create-now").click(function (e) {
            var formfields = jQuery('#myemmaform').serializeArray();
            jQuery('.warning-modal').modal('hide');
            $.ajax({
                type: "POST",
                url: 'emma_setup.php',
                data: formfields,
                success: function (data) {
                    jQuery(".form-wrapper").html(data);
                },
                cache: false,
                async: false
            });
        });
        function renderContent(){
            $.ajax({
                type: "POST",
                url: 'renderemma.php',
                data: "client_id=" + jQuery(".render_emma").attr('data-id'),
                success: function (data) {
                    jQuery(".form-wrapper").html(data);
                },
                cache: false,
                async: false
            });
        }
        function activatestatus(){
            // _client_id = jQuery("#emma_clientid").val();
            // if (_client_id == '') {
            //     _client_id = jQuery(".activatestatus").attr('data-id');
            // }
            $.ajax({
                type: "POST",
                url: 'activateemmastatus.php',
                data: "client_id=" + jQuery(".activatestatus").attr('data-id'),
                success: function (data) {
                    jQuery(".form-wrapper").html(data);
                },
                cache: false,
                async: false
            });
        }
        jQuery(".render_emma").click(function (e) {
            console.info(jQuery(".render_emma").attr('data-id'));
            $.ajax({
                type: "POST",
                url: 'renderemma.php',
                data: "client_id=" + jQuery(".render_emma").attr('data-id'),
                success: function (data) {
                    jQuery(".form-wrapper").html(data);
                },
                cache: false,
                async: false
            });
        });
    </script>
</body>
</html>