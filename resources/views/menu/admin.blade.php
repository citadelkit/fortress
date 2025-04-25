<x-nav-container>
    @slot('brand')
        <span class="text-white">
            FORTRESS
        </span>
    @endslot
    @slot('content')
        <x-nav-menu-item title="Home" href="/" icon="home" />
        <x-nav-menu-item title="Post" href="{{ route('post.index') }}" icon="clipboard" />
    @endslot
</x-nav-container>
