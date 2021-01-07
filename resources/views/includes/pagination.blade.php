@if($totalPages > 1)
    @php($uri = \Illuminate\Support\Facades\URL::current())

    <nav class="mt-2">
        <ul class="pagination justify-content-center">

            <li class="page-item @if($currentPage<=1) disabled @endif">
                <a class="page-link"
                   href="{{url($uri.'?page='.($currentPage-1).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}"
                   tabindex="-1">Vorige</a>
            </li>

            @php($showEachSide = 2)

            @if($totalPages <= 5)
                @for($i = 1; $i <= $totalPages; $i++)
                    <li class="page-item @if($i==$currentPage) active @endif">
                        <a class="page-link"
                           href="{{url($uri.'?page='.($i).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$i}}@if($i==$currentPage)
                                <span class="sr-only">(current)</span> @endif</a>
                    </li>
                @endfor

            @else

                @for($i = 1; $i <= $showEachSide; $i++)
                    <li class="page-item @if($i==$currentPage) active @endif">
                        <a class="page-link"
                           href="{{url($uri.'?page='.($i).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$i}}@if($i==$currentPage)
                                <span class="sr-only">(current)</span> @endif</a>
                    </li>
                @endfor

                @if($currentPage > $showEachSide && $currentPage < ($totalPages-($showEachSide-1)))

                    @if(($currentPage - 1) > 3)
                        <li class="page-item disabled">
                            <a class="page-link" href="#">...</a>
                        </li>
                    @endif

                    @if(($currentPage - 1) > 2)

                        <li class="page-item">
                            <a class="page-link"
                               href="{{url($uri.'?page='.($currentPage-1).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$currentPage-1}}</a>
                        </li>

                    @endif

                    <li class="page-item active">
                        <a class="page-link"
                           href="{{url($uri.'?page='.($currentPage).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$currentPage}}
                            <span class="sr-only">(current)</span></a>
                    </li>

                    @if(($currentPage + 2) < $totalPages)

                        <li class="page-item">
                            <a class="page-link"
                               href="{{url($uri.'?page='.($currentPage+1).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$currentPage+1}}</a>
                        </li>

                    @endif

                    @if(($currentPage + 3) < $totalPages)
                        <li class="page-item disabled">
                            <a class="page-link" href="#">...</a>
                        </li>
                    @endif

                @else
                    <li class="page-item disabled">
                        <a class="page-link" href="#">...</a>
                    </li>
                @endif

                @for($i = $totalPages-($showEachSide-1); $i <= $totalPages; $i++)
                    <li class="page-item @if($i==$currentPage) active @endif">
                        <a class="page-link"
                           href="{{url($uri.'?page='.($i).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">{{$i}}@if($i==$currentPage)
                                <span class="sr-only">(current)</span> @endif</a>
                    </li>
                @endfor

            @endif

            <li class="page-item @if($currentPage>=$totalPages) disabled @endif">
                <a class="page-link"
                   href="{{url($uri.'?page='.($currentPage+1).(isset($_GET['search'])? '&search='.$_GET['search'] : ''))}}">Volgende</a>
            </li>

        </ul>
    </nav>

@endif
