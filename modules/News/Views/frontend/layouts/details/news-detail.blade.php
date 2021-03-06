<div class="article">
    <div class="header">
        @if($image_url = get_file_url($row->image_id, 'full'))
            <header class="post-header">
                <img src="{{ $image_url  }}" alt="{{$translation->title}}">
            </header>
            <div class="cate">
                @php $category = $row->getCategory; @endphp
                @if(!empty($category))
                    @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
                    <ul>
                        <li>
                            <a href="{{$category->getDetailUrl(app()->getLocale())}}">
                                {{$t->name ?? ''}}
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        @endif
    </div>
    <h2 class="title">{!! clean($translation->title) !!}</h2>
    <div class="post-info">
        <ul>
            @if(!empty($row->getAuthor))
                <li>
                    <img class="avatar" src="{{$row->getAuthor->getAvatarUrl()}}" alt="{{$row->getAuthor->getDisplayName()}}">
                    <span> {{ __('By ')}} </span>
                    <a href="{{route('user.profile',['id'=>$row->getAuthor->id])}}" target="_blank">{{$row->getAuthor->getDisplayName() ?? ''}}</a>
                </li>
            @endif
            {{--<li> <span class="fa fa-calendar"></span> {{ display_date($row->updated_at, 'F d, Y')}}  </li>--}}
        </ul>
    </div>
    <div class="post-content" style="font-size: 13pt; font-family: verdana, serif; border-top: solid 2px #1a2b48; padding:20px 40px; background-color: #f8f9fa; line-height: 20pt;"> {!! $translation->content !!}</div>
    <div class="space-between">
        @if (!empty($tags = $row->getTags()) and count($tags) > 0)
            <div class="tags">
                {{__("Tags:")}}
                @foreach($tags as $tag)
                    @php $t = $tag->translateOrOrigin(app()->getLocale()); @endphp
                    <a href="{{ $tag->getDetailUrl(app()->getLocale()) }}" class="tag-item"> {{$t->name ?? ''}} </a>
                @endforeach
            </div>
        @endif
        <div class="share"> {{__("Share")}}
            <a class="facebook share-item" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" original-title="{{__("Facebook")}}"><i class="fa fa-facebook fa-lg"></i></a>
            <a class="twitter share-item" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" original-title="{{__("Twitter")}}"><i class="fa fa-twitter fa-lg"></i></a>
        </div>
    </div>
</div>

