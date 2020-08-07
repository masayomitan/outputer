

    <div class="tab-info-box">
        <div class="tab-info-box-num-list">
            @foreach($tab_info_list as $tab_text => $tab_info)
            <div class="tab-info-box-num-list-each">
                    <a href="{{ $tab_info['link'] }}" class="tab-info-button">
                    <div class="tab-info-num">{{$tab_text}}</div>
                    </a>
            </div>
            @endforeach
        </div>
    <div>
