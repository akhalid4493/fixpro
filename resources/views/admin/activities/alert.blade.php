<a href="javascript:;" class="dropdown-toggle notifications" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    <i class="icon-bell"></i>
    <span class="badge badge-default">{{ count($activities)}}</span>
</a>
<ul class="dropdown-menu">
    <li>
        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
            @foreach ($activities as $activity)
            <li>
                <a href="javascript:;">
                    <span class="time">
                        {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                    </span>
                    <span class="details"> 
                        {{ getFromJson($activity->properties,makeTrans('description')) }}.
                    </span>
                </a>
            </li>
            @endforeach
        </ul>
    </li>
</ul>