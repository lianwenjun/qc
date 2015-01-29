@if ($paginator->getLastPage() > 1)
<ul class="pagination">
    <li><a class="{{ $paginator->getCurrentPage() < 2 ? 'disabled' : '' }}" href="{{ $paginator->getUrl(1) }}">首页</a></li>
    <li><a class="{{ $paginator->getCurrentPage() < 2 ? 'disabled' : '' }}" href="{{ $paginator->getUrl($paginator->getCurrentPage() - 1) }}">上一页</a></li> 
    <!--<li><span>...</span></li>-->
    <?php $pages = Helper::pageNum($paginator->getCurrentPage(), $paginator->getLastPage()); ?>
    @foreach ($pages as $page)
        @if ($page == $paginator->getCurrentPage())
            <li><span class="current">{{ $page }}</span></li>
        @else
            <li><a href="{{ $paginator->getUrl($page) }}">{{ $page }}</a></li>
        @endif
    @endforeach
    <li><a class="{{ $paginator->getCurrentPage() >  $paginator->getLastPage() - 1 ? 'disabled' : '' }}" href="{{ $paginator->getUrl($paginator->getCurrentPage() + 1) }}">下一页</a></li>
    <li><a class="{{ $paginator->getCurrentPage() >=  $paginator->getLastPage() ? 'disabled' : '' }}" href="{{ $paginator->getUrl($paginator->getLastPage()) }}">末页</a></li>
    <li>共<b>{{ $paginator->getLastPage() }}</b>页</li>
    <li>
        <form method="get" action="{{ $paginator->getUrl('') }}">
            <input type="text" value="" name="page" />
            <input type="submit" class="page" value="GO" />
        </form>
    </li>
</ul>
@endif