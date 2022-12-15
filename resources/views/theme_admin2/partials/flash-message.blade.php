<div class="container">
    <div class="row">
        <div class="col-md-12 top-message">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {!!  Session::get('success') !!}
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    @if( is_array(Session::get('error')) )
                        @foreach (Session::get('error') as $msg)
                            - {!! $msg !!} <br />
                        @endforeach
                    @else
                        {!!  Session::get('error') !!}
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
