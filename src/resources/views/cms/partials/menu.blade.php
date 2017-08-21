<div class="menu menu-vertical">
    
            
    <?php
        $sites = Cms::getSites();
    ?>

    @if(count($sites) > 1)
        <div class="brand chevron">
            <select id="site-selector">
                @foreach($sites as $site)
                    @if(Cms::site()->id == $site->id)
                        <option value="{{ $site->protocol.$site->domain }}/cms/panel" selected>{{ $site->title }}</option>
                    @else
                        <option value="{{ $site->protocol.$site->domain }}/cms/panel">{{ $site->title }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    @else
        <div class="brand single">
            {{ $sites[0]->title }}
        </div>
    @endif
    
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">

            @foreach(config('menu') as $menu)

                @if(@$menu['route'] && (Cms::hasPermission(Cms::site('id').'.'.$menu['route']) || @$menu['verified']))

                    <?php
                        $route = route($menu['route']);
                    ?>

                    <li @if(strpos(Request::url(), $route) !== false) class="active" @endif>
                        <a @if(Request::url() == $route) href="javascript:void(0)" @else href="{{ $route }}" @endif>
                            <i class="fa {{ $menu['icon'] }} fa-lg"></i> 
                            {{ trans('hack::'.$menu['label']) }}
                        </a>
                    </li>

                @elseif(@$menu['children'])
                    @include('hack::partials.collapse')
                @endif

            @endforeach
        </ul>
    </div>

{{--     <div class="quick">
        <a href="{{ route('cms.auth.destroy') }}">
            <i class="fa fa-power-off fa-2x"></i>
        </a>
        <a href="{{ route('cms.auth.show') }}">
            <i class="fa fa-lock fa-2x"></i>
        </a>
        <a href="{{ route('cms.panel.index') }}">
            <i class="fa fa-gear fa-2x"></i>
        </a>
    </div> --}}
</div>