@php
     $blueBarRoutes = config('routes.blueBarRoutes');
@endphp
@if(in_array($currentRoute, array_merge($globalRoutes, $blueBarRoutes)))

    <div class="global global_mode-unavailable">
        {{--@if($globalMode)--}}
            @if(in_array($currentRoute, $blueBarRoutes))
                <div class="global__bar" id="global-settings-ist-bar">
                    <p></p>
                </div>
            @endif

        {{--@endif--}}

    </div>
    @if(!in_array($currentRoute, $blueBarRoutes))
        <div class="global" id="global_checkbox_bar">
            <div class="global__bar" style="display: none;">
                <p>GLOBAL SETTINGS MODE IS OFF</p>
                <div class="switcher-min">
                    <input id="global_mode_bar" name="global_mode_bar" data-toggle="toggle min" class="global_mode_chkbox" data-onstyle="active" data-offstyle="inactive" data-width="115" data-height="26" data-on="switch ON" data-off="switch OFF" type="checkbox">
                </div>
            </div>
        </div>
    @endif
@endif


