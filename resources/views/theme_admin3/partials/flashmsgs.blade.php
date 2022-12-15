@push('footerScripts')
<script>
    function extractMessage(message){
        if(typeof message === "object") {
            //As discussed, we need to display only first error in toast
            if(message[0]) {
                message = message[0]
            }
            // var messageObject = message,
            //     numOfErrors = messageObject.length,
            //     message = "";
            // for (var i in messageObject) {
            //     message += messageObject[i];
            //
            //     if(i < numOfErrors) {
            //         message += " \n";
            //     }
            //     message += messageObject[i];
            // }
        } else {
            var message_array = message.split('</strong>');
            if (message_array.length > 1) {
                message = message_array[1];
            } else {
                message = message_array[0];
            }
        }
        console.log("Message", message);

        return message;
    }
    $(document).ready(function () {
    @if(Session::has('success'))
    lptoast.cogoToast.success(extractMessage("{!! Session::get('success')  !!}"), { position: 'top-center', heading: 'Success' });
    @endif
    @if(Session::has('error'))
        @php
            $error = Session::get('error');
            if(is_array($error)) {
                $error = json_encode($error);
                echo  "lptoast.cogoToast.error(extractMessage($error), { position: 'top-center', heading: 'Error', hideAfter:5 })";
            } else {
                echo  "lptoast.cogoToast.error(extractMessage('$error'), { position: 'top-center', heading: 'Error', hideAfter:5 })";
            }
        @endphp
    @endif
    @if(Session::has('warning'))
    lptoast.cogoToast.warn(extractMessage("{!! Session::get('warning') !!}"), { position: 'top-center', heading: 'Warning' });
    @endif
    @if(Session::has('info'))
    lptoast.cogoToast.info(extractMessage("{!! Session::get('info') !!}"), { position: 'top-center', heading: 'Info' });
    @endif
    })
</script>
@endpush
