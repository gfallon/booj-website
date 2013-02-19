@layout('blog::layouts.layout')

@section('page_title')
@if (!empty($data['post']))
~ {{ $data['post']->title }}
@endif
@endsection

@section('page_description')
@if (!empty($page_data->meta_description))
{{ $page_data->meta_description }}
@endif
@endsection

@section('page_keywords')
@if (!empty($page_data->meta_keyword))
{{ $page_data->meta_keyword }}
@endif
@endsection

@section('opengraph')
@if (!empty($data['post']))
<meta property="og:title" content="<?=$data['post']->truncated_content(75);?>">
<meta property="og:url" content="http://www.booj.com<?=$action_urls['blog'];?>/<?=$data['post']->slug;?>">
<meta property="og:image" content="http://www.booj.com<?=$data['post']->main_photo;?>">
@endif
@endsection

@section('content')	
<div class="row-fluid">
	<div class="span9" id="post-page">
		@if (!empty($data['post']))
			<div class="shadow-box white-box margin-bottom-30">
				<div class="title-bar">
					<div class="post-next-prev">
						@if (!empty($data['previous_post']) || !empty($data['next_post']) || !empty($data['']))
							@if (!empty($data['previous_post']))
								<a class="bicon-previous" href="<?=$action_urls['blog']; ?>/<?=$data['previous_post']->slug; ?>" title="Previous Post">Previous</a>
							@endif

							@if (!empty($data['random_post']))
								<a class="bicon-shuffle margin-left-30" href="<?=$action_urls['blog']; ?>/<?=$data['random_post']->slug; ?>" title="Random Post">Random</a>
							@endif

							@if (!empty($data['next_post']))
								<a class="bicon-next margin-left-30" href="<?=$action_urls['blog']; ?>/<?=$data['next_post']->slug; ?>" title="Next Post">Next</a>
							@endif
						@endif
					</div>
					@if (!empty($data['post']->category))
						<a href="<?=$action_urls['category']; ?>/<?=$data['post']->category->slug; ?>" title="<?=$data['post']->category->title;?>"><?=$data['post']->category->title;?></a>
					@endif
				</div>
				<div class="post-page-content-wrapper">
					@if (!empty($data['post']->main_photo))
						<img src="<?=$data['post']->main_photo;?>" alt="<?=$data['post']->title; ?>">
					@endif
					<div class="post-page-content">
						
						<h1 class="font-30 margin-0">{{ $data['post']->title }}</h1>
						
						<div class="post-top-meta">
							<? echo date('n/j/Y', strtotime($data['post']->created_at)); ?>
							<? if (!empty($data['post']->user)): ?>
								 // by <a href="<?=$action_urls['author'];?>/<?=$data['post']->user->slug;?>" title="View profile for <?=$data['post']->user->first_name;?> <?=$data['post']->user->last_name;?>">+<?=$data['post']->user->first_name;?> <?=$data['post']->user->last_name;?></a>
							<? endif; ?>
						</div>

						<div class="post-content">
							{{ $data['post']->content }}
						</div>

						@if (!empty($data['post']->tags))
							<div class="post-tags">
								<?
									$m = count($data['post']->tags) - 1; $i=0;
									foreach ($data['post']->tags as $rel) {
										echo '<a href="' . $action_urls['tag'] . '/' . $rel->slug . '" title="' . $rel->title . '">' . $rel->title . '</a>';
										if ($i < $m) echo ', ';
										$i++;
									}
								?>
							</div>
						@endif

					</div>
				</div>
			</div>

			@if (!empty($data['post']->user))
				<div class="post-author-section shadow-box white-box margin-bottom-30">
					<a href="<?=$action_urls['author'];?>/<?=$data['post']->user->slug;?>" title="View profile for <?=$data['post']->user->first_name; ?> <?=$data['post']->user->last_name; ?>">
							<img class="post-author-img" src="<?=$data['post']->user->avatar;?>" alt="photo of <?=$data['post']->user->first_name; ?> <?=$data['post']->user->last_name; ?>">
						</a>
					<h2 class="font-30">
						<a href="<?=$action_urls['author'];?>/<?=$data['post']->user->slug;?>" class="caps" title="View profile for <?=$data['post']->user->first_name; ?> <?=$data['post']->user->last_name; ?>"><?=$data['post']->user->first_name; ?> <?=$data['post']->user->last_name; ?></a>
						<? if (!empty($data['post']->user->facebook_id)) echo '<a href="' . $action_urls['facebook'] . $data['post']->user->facebook_id . '" rel="nofollow" target="_blank" title="My Facebook Page"><i class="bicon-red-facebook margin-top-5">Facebook</i></a>'; ?>
						<? if (!empty($data['post']->user->google_plus_id)) echo '<a href="' . $action_urls['google_plus'] . $data['post']->user->google_plus_id . '" rel="nofollow" target="_blank" title="My Google Plus Page"><i class="bicon-red-google-plus margin-top-5">Google Plus</i></a>'; ?>
						<? if (!empty($data['post']->user->twitter_handle)) echo '<a href="' . $action_urls['twitter'] . $data['post']->user->twitter_handle . '" rel="nofollow" target="_blank" title="My Twitter Page"><i class="bicon-red-twitter margin-top-5">Twitter</i></a>'; ?>
					</h2>
					<span class="block author-title"><?=$data['post']->user->title; ?></span>
					<p><?=$data['post']->user->bio;?></p>
				</div>
			@endif
			@if (!empty($data['similar_posts']))
				<div class="post-similar-section">
					<h2 class="font-30">You May Also Like</h2>
					<div class="row-fluid">
						<? foreach ($data['similar_posts'] as $post): ?>
							<div class="span6 post-landing shadow-box white-box">
								<div class="post-landing-photo">
									<a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>" title="<?=$post->short_title;?>"><img src="<?=$post->small_photo;?>" alt="<?=$post->short_title;?>"></a>
									<? if (!empty($post->category)): ?>
										<a class="category-button" href="<?=$action_urls['category'];?>/<?=$post->category->slug;?>" title="<?=$post->category->title;?>"><?=$post->category->title;?></a>
									<? endif; ?>
								</div>
								<div class="post-landing-outer">
									<div class="post-landing-inner-short">
										<h2 class="font-18">
											<a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>" title="<?=$post->short_title;?>"><?=$post->short_title;?></a>
										</h2>
									</div>
								</div>
							</div>
						<? endforeach; ?>
					</div>
				</div>
			@endif
			<div id="disqus_thread" class="margin-bottom-30 shadow-box white-box"></div>

			<div class="addthis_toolbox addthis_floating_style addthis_counter_style" addthis:url="http://booj.com<?=$action_urls['blog'];?>/<?=$data['post']->slug;?>" addthis:title="<?=$data['post']->title;?>"">
				<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
				<a class="addthis_button_tweet" tw:count="vertical"></a>
				<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
				<a class="addthis_button_linkedin_counter" li:counter="top"></a> 
				<a class="addthis_button_pinterest_pinit" pi:pinit:url="http://www.booj.com<?=$action_urls['blog'];?>/<?=$data['post']->slug;?>" pi:pinit:media="http://www.booj.com<?=$data['post']->main_photo;?>" pi:pinit:layout="vertical"></a>
			</div>
		@else
			<div class="alert alert-error alert-block">No post found</div>
		@endif
	</div>
	<div class="span3">
		@include('blog::sidebar')
	</div>
</div>
@endsection

@section('scripts')
<? if (!empty($data['post'])): ?>
<script>
var disqus_shortname = 'booj';
var disqus_identifier = '<?=$data['post']->id;?>';
var disqus_url = 'http://www.booj.com<?=$action_urls['blog']; ?>/<?=$data['post']->slug;?>';
/* * * DON'T EDIT BELOW THIS LINE * * */
(function() {
    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
    dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
})();
</script>
<? endif; ?>
@endsection
