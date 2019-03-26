<div class="container list">
    <div class="row">
        <ul class="list-unstyled col-md-10 offset-md-1">
            @forelse($articles as $article)
            <li class="media">
                @if($article->page_image)
                <a class="media-left mr-3" href="{{ url($article->slug) }}">
                    <img class='article-img' alt="{{ $article->slug }}" src="{{ $article->page_image }}" data-holder-rendered="true">
                </a>
                @endif
                <div class="media-body">
                    <h3 class="media-heading">
                        <a href="{{ url($article->slug) }}">
                            {{ $article->title }}
                        </a>
                    </h3>
                    <div class="meta">
                        <h5>{{ $article->subtitle }}</h5>
                    </div>
                    {{-- <div class="description">
                        {{ $article->meta_description }}
                    </div> --}}
                    <div class="extra">

                        <div class="info">
                            <i class="fas fa-user"></i>{{ $article->user->name ?? 'null' }}&nbsp;,&nbsp;
                            <i class="fas fa-clock"></i>{{ $article->published_at->diffForHumans() }}&nbsp;,&nbsp;
                            <i class="fas fa-eye"></i>{{ $article->view_count }}
                            <a href="{{ url($article->slug) }}" class="float-right">
                                Read More <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            @empty
                <h3 class="text-center">{{ lang('Nothing') }}</h3>
            @endforelse
        </ul>
    </div>
</div>
