@if($totalPages > 1)
    <nav aria-label="..." class="mt-2">
        <ul class="pagination justify-content-center">
            <li class="page-item @if($currentPage<=1) disabled @endif">
                <a class="page-link" href="{{url('/admin/categories/?page='.($currentPage-1).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}" tabindex="-1">Vorige</a>
            </li>
            @php($showEachSide = 2)
            @if($totalPages <= 5)
                @for($i = 1; $i <= $totalPages; $i++)
                    <li class="page-item @if($i==$currentPage) active @endif">
                        <a class="page-link" href="{{url('/admin/categories/?page='.($i).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$i}}@if($i==$currentPage) <span class="sr-only">(current)</span> @endif</a>
                    </li>
                @endfor
            @else
                @for($i = 1; $i <= $showEachSide; $i++)
                    <li class="page-item @if($i==$currentPage) active @endif">
                        <a class="page-link" href="{{url('/admin/categories/?page='.($i).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$i}}@if($i==$currentPage) <span class="sr-only">(current)</span> @endif</a>
                    </li>
                @endfor

                @if($currentPage > $showEachSide && $currentPage < ($totalPages-($showEachSide-1)))
                        <li class="page-item disabled">
                            <a class="page-link" href="#">...</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="{{url('/admin/categories/?page='.($currentPage).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$currentPage}} <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">...</a>
                        </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link" href="#">...</a>
                    </li>
                @endif

                @for($i = $totalPages-($showEachSide-1); $i <= $totalPages; $i++)
                    <li class="page-item @if($i==$currentPage) active @endif">
                        <a class="page-link" href="{{url('/admin/categories/?page='.($i).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$i}}@if($i==$currentPage) <span class="sr-only">(current)</span> @endif</a>
                    </li>
                @endfor
            @endif

            <li class="page-item @if($currentPage>=$totalPages) disabled @endif">
                <a class="page-link" href="{{url('/admin/categories/?page='.($currentPage+1).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">Volgende</a>
            </li>
        </ul>
    </nav>
@endif
