<ul id="side-nav" class="side-nav">

    <li class="@yield('review')">
        <a href="{{route('mpsactual.index')}}"><i class="fa fa-table"></i>MPS VS ACTUAL</a></li>
    </li>
    <li class="@yield('defect')">
        <a href="{{route('defect.index')}}"><i class="fa fa-table"></i> DEFECT</a></li>
    </li>

</ul>
