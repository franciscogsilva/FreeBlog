<!-- For Facebook -->
<meta name="og:image" 			content="{{ $meta->image->image }}" />
<meta name="og:url" 			content="{{ $route }}" />
<meta name="og:type" 			content="article" />
<meta name="og:title" 			content="{{ $meta->title }}" />
<meta name="og:description" 	content="{{ $content }}" />

<!-- For Google -->
<meta name="description" content="{{ $content }}"/>
<meta name="keywords" content="" />

<meta name="author" content="{{ $meta->user->name }}" />
<meta name="copyright" content="" />
<meta name="application-name" content="{{ env('APP_NAME') }}" />

<!-- For Twitter -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{{ $meta->title }}" />
<meta name="twitter:description" content="{{ $content }}"/>
<meta name="twitter:image" content="{{ $meta->image->image }}" />