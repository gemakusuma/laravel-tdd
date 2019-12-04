<ul>
    @foreach ($blogs as $blog)
        <li> <a href="/blog/{{$blog->slug}}"> {{ $blog->title }} </a> </li>
    @endforeach
</ul>
