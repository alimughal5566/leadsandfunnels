@extends("layouts.leadpops")

@section('content')
    <section id="leadpopovery">
        <div id="overlay">
            <i class="fa fa-spinner fa-spin spin-big"></i>
        </div>
    </section>
    @php
           $noimage = "noimage";
           $funnel_data = LP_Helper::getInstance()->getFunnelData();
           if($funnel_data){
           $imagesrc = \View_Helper::getInstance()->getCurrentFrontImageSource($view->data->client_id,$funnel_data['funnel']);
           if($imagesrc){
           list($imagestatus,$theimage, $noimage) = explode("~",$imagesrc);
           }
           }
           $_class = 'homepage_on';
           if($noimage=="noimage"){
               $featured_image_active="n";
               $_class = 'homepage_off';
           }
           else {
               $featured_image_active="y";
           }
           if(isset($view->data->clickedkey) && $view->data->clickedkey != "") {
               $firstkey = $view->data->clickedkey;
           }else {
               $firstkey = "";
           }
    @endphp
    <section id="page-cta">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" id="success-alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Success:</strong>
                        <span></span>
                    </div>

                </div>
            </div>

            @php
                LP_Helper::getInstance()->getFunnelHeader($view);
                $treecookie = \View_Helper::getInstance()->getTreeCookie($view->data->client_id,$firstkey);
            @endphp
            <form class="form-inline" name="ctaform" id="ctaform" method="POST" action="{{ LP_BASE_URL.LP_PATH."/popadmin/calltoactionsave" }}">
                {{ csrf_field() }}
                <input name="saved" id="saved" value="{{ @$view->saved }}" type="hidden">
                <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
                <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
                <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
                <input type="hidden" name="mlineheight" id="mlineheight" value="">
                <input type="hidden" name="dlineheight" id="dlineheight" value="">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ $view->data->currenthash }}">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="featured_image_active" id="featured_image_active" value="{{ $featured_image_active }}">
                <div class="lp-cta" id="cta_main_message">
                    <div class="lp-cta-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-left"><h2 class="lp-heading-2">Main Message</h2></div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-right"><a href="#" id="mresetbutton" onclick="return resethomepagemessage('1');" ><i class="fa fa-rotate-left"></i>RESET</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-input-area">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-left">

                                    <label for="" class="control-label cta-font-label">
                                        Font Type
                                    </label>
                                    @php
                                        $scfont="";
                                        if(isset($view->data->fontfamily))
                                        $scfont = str_replace(" ", "_", strtolower($view->data->fontfamily ));
                                    @endphp
                                    <select class="lp-select2-with-custom-optclass cta-font-type {{ $scfont }}" data-width="220px" name="mthefont" id="msgfonttype" onchange="changefont('mthefont',this.value)">
                                        @php
                                            foreach ($view->data->fontfamilies as $font){
                                                $cfont = str_replace(" ", "_", strtolower($font));
                                        @endphp
                                        <option class="{{ $cfont }}" value='{{ $font }}' {{ (isset($view->data->fontfamily) && $view->data->fontfamily==$font?'selected="selected"':'') }}>{{ $font }}</option>
                                        @php
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div class="col-center">
                                    <label for="" class="control-label cta-font-label">
                                        Font Size
                                    </label>
                                    <select name="mthefontsize" id="msgfonttype" class="lp-select2 cta-font-size" data-width="90px" onchange="changefontsize('mthefontsize',this.value)">
                                        <option value="10px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='10px'?'selected="selected"':"") }}>10 px</option>
                                        <option value="11px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='11px'?'selected="selected"':"") }}>11 px</option>
                                        <option value="12px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='12px'?'selected="selected"':"") }}>12 px</option>
                                        <option value="13px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='13px'?'selected="selected"':"") }}>13 px</option>
                                        <option value="14px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='14px'?'selected="selected"':"") }}>14 px</option>
                                        <option value="15px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='15px'?'selected="selected"':"") }}>15 px</option>
                                        <option value="16px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='16px'?'selected="selected"':"") }}>16 px</option>
                                        <option value="17px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='17px'?'selected="selected"':"") }}>17 px</option>
                                        <option value="18px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='18px'?'selected="selected"':"") }}>18 px</option>
                                        <option value="19px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='19px'?'selected="selected"':"") }}>19 px</option>
                                        <option value="20px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='20px'?'selected="selected"':"") }}>20 px</option>
                                        <option value="21px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='21px'?'selected="selected"':"") }}>21 px</option>
                                        <option value="22px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='22px'?'selected="selected"':"") }}>22 px</option>
                                        <option value="23px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='23px'?'selected="selected"':"") }}>23 px</option>
                                        <option value="24px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='24px'?'selected="selected"':"") }}>24 px</option>
                                        <option value="25px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='25px'?'selected="selected"':"") }}>25 px</option>
                                        <option value="26px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='26px'?'selected="selected"':"") }}>26 px</option>
                                        <option value="27px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='27px'?'selected="selected"':"") }}>27 px</option>
                                        <option value="28px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='28px'?'selected="selected"':"") }}>28 px</option>
                                        <option value="29px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='29px'?'selected="selected"':"") }}>29 px</option>
                                        <option value="30px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='30px'?'selected="selected"':"") }}>30 px</option>
                                        <option value="31px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='31px'?'selected="selected"':"") }}>31 px</option>
                                        <option value="32px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='32px'?'selected="selected"':"") }}>32 px</option>
                                        <option value="33px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='33px'?'selected="selected"':"") }}>33 px</option>
                                        <option value="34px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='34px'?'selected="selected"':"") }}>34 px</option>
                                        <option value="35px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='35px'?'selected="selected"':"") }}>35 px</option>
                                        <option value="36px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='36px'?'selected="selected"':"") }}>36 px</option>
                                        <option value="37px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='37px'?'selected="selected"':"") }}>37 px</option>
                                        <option value="38px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='38px'?'selected="selected"':"") }}>38 px</option>
                                        <option value="39px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='39px'?'selected="selected"':"") }}>39 px</option>
                                        <option value="40px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='40px'?'selected="selected"':"") }}>40 px</option>
                                        <option value="41px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='41px'?'selected="selected"':"") }}>41 px</option>
                                        <option value="42px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='42px'?'selected="selected"':"") }}>42 px</option>
                                        <option value="43px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='43px'?'selected="selected"':"") }}>43 px</option>
                                        <option value="44px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='44px'?'selected="selected"':"") }}>44 px</option>
                                        <option value="45px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='45px'?'selected="selected"':"") }}>45 px</option>
                                        <option value="46px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='46px'?'selected="selected"':"") }}>46 px</option>
                                        <option value="47px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='47px'?'selected="selected"':"") }}>47 px</option>
                                        <option value="48px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='48px'?'selected="selected"':"") }}>48 px</option>
                                    </select>
                                </div>
                                <div class="col-right">
                                    <label for="" class="control-label cta-font-label">
                                        Text Color
                                    </label>
                                    <div id="colorSelector" class="colorSelector-mmessagecp cta-color-selector " data-ctaid="mmessagecpval" data-ctavalue="mmainheadingval" style="{{ ($view->data->color!="") ? "background-color:".$view->data->color: "\"background-color:\"#FFFFFF" }}"></div>
                                    <input type="hidden" name="mmessagecpval" id="mmessagecpval" value="@php if(isset($view->data->color) && ($view->data->color)) echo $view->data->color @endphp">
                                </div>

                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="lp-cta-textarea">
                                    <textarea type="text" class="cta-text cta-text-format {{ $_class }}" name="mmainheadingval" id="mmainheadingval" style="{{ $view->data->messageStyle }}" >@php if(isset($view->data->homePageMessageMainMessage)){ echo trim(textCleaner($view->data->homePageMessageMainMessage));} @endphp</textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-cta" id="cta_descrption">
                    <div class="lp-cta-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-left"><h2 class="lp-heading-2">Description</h2></div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-right"><a href="#" id="dresetbutton" onclick="return resethomepagemessage('2');" ><i class="fa fa-rotate-left"></i>RESET</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-input-area">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-left">
                                    <label for="" class="control-label cta-font-label">
                                        Font Type
                                    </label>
                                    @php
                                        $scfont = str_replace(" ", "_", strtolower($view->data->dfontfamily ));
                                    @endphp
                                    <select class="lp-select2-with-custom-optclass cta-font-type {{ $scfont }}" data-width="220px" name="dthefont" id="dthefont" onchange="changefont('dthefont',this.value)">
                                        @php
                                            foreach ($view->data->fontfamilies as $font){
                                                $cfont = str_replace(" ", "_", strtolower($font));
                                        @endphp
                                        <option class="{{ $cfont }}" value='{{ $font }}' {{ ($view->data->dfontfamily==$font?'selected="selected"':'') }}>{{ $font }}</option>
                                        @php
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div class="col-center">
                                    <label for="" class="control-label cta-font-label">
                                        Font Size
                                    </label>
                                    <select name="dthefontsize" id="dthefontsize" class="lp-select2 cta-font-size" data-width="90px" onchange="changefontsize('dthefontsize',this.value)">
                                        <option value="10px" {{ ($view->data->dfontsize=='10px'?'selected="selected"':"") }}>10 px</option>
                                        <option value="11px" {{ ($view->data->dfontsize=='11px'?'selected="selected"':"") }}>11 px</option>
                                        <option value="12px" {{ ($view->data->dfontsize=='12px'?'selected="selected"':"") }}>12 px</option>
                                        <option value="13px" {{ ($view->data->dfontsize=='13px'?'selected="selected"':"") }}>13 px</option>
                                        <option value="14px" {{ ($view->data->dfontsize=='14px'?'selected="selected"':"") }}>14 px</option>
                                        <option value="15px" {{ ($view->data->dfontsize=='15px'?'selected="selected"':"") }}>15 px</option>
                                        <option value="16px" {{ ($view->data->dfontsize=='16px'?'selected="selected"':"") }}>16 px</option>
                                        <option value="17px" {{ ($view->data->dfontsize=='17px'?'selected="selected"':"") }}>17 px</option>
                                        <option value="18px" {{ ($view->data->dfontsize=='18px'?'selected="selected"':"") }}>18 px</option>
                                        <option value="19px" {{ ($view->data->dfontsize=='19px'?'selected="selected"':"") }}>19 px</option>
                                        <option value="20px" {{ ($view->data->dfontsize=='20px'?'selected="selected"':"") }}>20 px</option>
                                        <option value="21px" {{ ($view->data->dfontsize=='21px'?'selected="selected"':"") }}>21 px</option>
                                        <option value="22px" {{ ($view->data->dfontsize=='22px'?'selected="selected"':"") }}>22 px</option>
                                        <option value="23px" {{ ($view->data->dfontsize=='23px'?'selected="selected"':"") }}>23 px</option>
                                        <option value="24px" {{ ($view->data->dfontsize=='24px'?'selected="selected"':"") }}>24 px</option>
                                        <option value="25px" {{ ($view->data->dfontsize=='25px'?'selected="selected"':"") }}>25 px</option>
                                        <option value="26px" {{ ($view->data->dfontsize=='26px'?'selected="selected"':"") }}>26 px</option>
                                        <option value="27px" {{ ($view->data->dfontsize=='27px'?'selected="selected"':"") }}>27 px</option>
                                        <option value="28px" {{ ($view->data->dfontsize=='28px'?'selected="selected"':"") }}>28 px</option>
                                        <option value="29px" {{ ($view->data->dfontsize=='29px'?'selected="selected"':"") }}>29 px</option>
                                        <option value="30px" {{ ($view->data->dfontsize=='30px'?'selected="selected"':"") }}>30 px</option>
                                        <option value="31px" {{ ($view->data->dfontsize=='31px'?'selected="selected"':"") }}>31 px</option>
                                        <option value="32px" {{ ($view->data->dfontsize=='32px'?'selected="selected"':"") }}>32 px</option>
                                        <option value="33px" {{ ($view->data->dfontsize=='33px'?'selected="selected"':"") }}>33 px</option>
                                        <option value="34px" {{ ($view->data->dfontsize=='34px'?'selected="selected"':"") }}>34 px</option>
                                        <option value="35px" {{ ($view->data->dfontsize=='35px'?'selected="selected"':"") }}>35 px</option>
                                        <option value="36px" {{ ($view->data->dfontsize=='36px'?'selected="selected"':"") }}>36 px</option>
                                        <option value="37px" {{ ($view->data->dfontsize=='37px'?'selected="selected"':"") }}>37 px</option>
                                        <option value="38px" {{ ($view->data->dfontsize=='38px'?'selected="selected"':"") }}>38 px</option>
                                        <option value="39px" {{ ($view->data->dfontsize=='39px'?'selected="selected"':"") }}>39 px</option>
                                        <option value="40px" {{ ($view->data->dfontsize=='40px'?'selected="selected"':"") }}>40 px</option>
                                        <option value="41px" {{ ($view->data->dfontsize=='41px'?'selected="selected"':"") }}>41 px</option>
                                        <option value="42px" {{ ($view->data->dfontsize=='42px'?'selected="selected"':"") }}>42 px</option>
                                        <option value="43px" {{ ($view->data->dfontsize=='43px'?'selected="selected"':"") }}>43 px</option>
                                        <option value="44px" {{ ($view->data->dfontsize=='44px'?'selected="selected"':"") }}>44 px</option>
                                        <option value="45px" {{ ($view->data->dfontsize=='45px'?'selected="selected"':"") }}>45 px</option>
                                        <option value="46px" {{ ($view->data->dfontsize=='46px'?'selected="selected"':"") }}>46 px</option>
                                        <option value="47px" {{ ($view->data->dfontsize=='47px'?'selected="selected"':"") }}>47 px</option>
                                        <option value="48px" {{ ($view->data->dfontsize=='48px'?'selected="selected"':"") }}>48 px</option>
                                    </select>
                                </div>
                                <div class="col-right">
                                    <label for="" class="control-label cta-font-label">
                                        Text Color
                                    </label>
                                    <div id="colorSelector" class="colorSelector-mdescp cta-color-selector" data-ctaid="dmessagecpval" data-ctavalue="dmainheadingval" style="{{ ($view->data->dcolor!="") ? "background-color:".$view->data->dcolor: "\"background-color:\"#FFFFFF" }}"></div>
                                    <input type="hidden" name="dmessagecpval" id="dmessagecpval" value="@php if(isset($view->data->dcolor) && ($view->data->dcolor)) echo $view->data->dcolor; @endphp">
                                </div>

                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12" >
                                <div class="lp-cta-textarea">
                                    <textarea class="cta-textarea cta-text-format {{ $_class }}" id="dmainheadingval" name="dmainheadingval" style="{{ $view->data->dmessageStyle }}">@php if(isset($view->data->homePageMessageDescription)){  echo trim($view->data->homePageMessageDescription); } @endphp</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-save">
                            <div class="custom-btn-success">
                                <button type="submit" class="btn btn-success"><strong>SAVE</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection
