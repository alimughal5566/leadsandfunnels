@extends("layouts.leadpops")

@section('content')
    @php
    if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
        $firstkey = @$view->data->clickedkey;
    }else {
        $firstkey = "";
    }
    // debug(@$view->data->contact);
    @endphp
    <section id="page-contact-info">
        <div class="container">
            @php
                LP_Helper::getInstance()->getFunnelHeader($view);
                $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id, $firstkey);
            @endphp
            <form class="form-inline" id="contact-info" method="POST" action="@php echo LP_BASE_URL.LP_PATH."/popadmin/contactinfosave"; @endphp">
                {{ csrf_field() }}
                <input type="hidden" name="theselectiontype" id="theselectiontype"  value="contacteditoptions">
                <input type="hidden" name="client_id" id="client_id"  value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash" value="@php echo @$view->data->currenthash @endphp">

                <div class="lp-content-contact-div">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="textMsg" class="control-label lp-con-label">Company Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="lp-cont-textbox" name="companyname" id="companyname" value="@php if(isset($view->data->contact['companyname'])) echo @$view->data->contact['companyname']; @endphp" >
                        </div>
                        <div class=" col-md-2 custom-btn-toggle">


                            @php $checked="";
                            if(@$view->data->contact['companyname_active']=='y'){
                                $checked="checked";
                            }
                            @endphp
                            <input @php echo $checked; @endphp  data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE"  type="checkbox" class="conttogbtn companyname_tbt" data-lpkeys="@php echo @$view->data->lpkeys; @endphp~companyname_active" >
                        </div>
                    </div>
                </div>
                <div class="lp-content-contact-div">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="textMsg" class="control-label lp-con-label">Phone Number</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="lp-cont-textbox" name="phonenumber" id="phonenumber" value="@php if(isset($view->data->contact['phonenumber'])) echo @$view->data->contact['phonenumber']; @endphp">
                        </div>
                        <div class=" col-md-2 custom-btn-toggle">

                            @php $checked="";
                            if(@$view->data->contact['phonenumber_active']=='y'){
                                $checked="checked";
                            }
                            @endphp

                            <input @php echo $checked; @endphp data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE"  type="checkbox" class="conttogbtn phonenumber_tbt" data-lpkeys="@php echo @$view->data->lpkeys; @endphp~phonenumber_active">
                        </div>
                    </div>
                </div>
                <div class="lp-content-contact-div">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="textMsg" class="control-label lp-con-label">Email Address</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="lp-cont-textbox" name="email" id="email" value="@php if(isset($view->data->contact['email'])) echo @$view->data->contact['email']; @endphp" >
                        </div>
                        <div class=" col-md-2 custom-btn-toggle">

                            @php $checked="";
                            if(@$view->data->contact['email_active']=='y'){
                                $checked="checked";
                            }
                            @endphp
                            <input @php echo $checked; @endphp data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE"  type="checkbox" class="conttogbtn email_tbt" data-lpkeys="@php echo @$view->data->lpkeys; @endphp~email_active">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-save">
                            <div class="custom-btn-success">
                                <button type="submit" class="btn btn-success">SAVE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection