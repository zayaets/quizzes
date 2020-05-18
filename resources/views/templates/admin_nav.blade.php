<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.index') }}">Admin panel</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/questions') ? 'active' : '' }}" href="{{ route('admin.questions') }}">Questions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ route('admin.users') }}">Users</a>
    </li>

    {{--<li class="nav-item">
        <a class="nav-link active" href="#">Active</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    </li>--}}
</ul>
