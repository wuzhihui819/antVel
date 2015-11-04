<meta name="description" content="{{$description}}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@<?=$main_company['twitter']?>">
<meta name="twitter:title" content="{{$title}}">
<meta name="twitter:image" content="{{$image}}">
<meta name="twitter:description" content="{{$description}}">

<meta property="og:title" content="{{$title}}" />
<meta property="og:description" content="{{$description}}" />
<meta property="og:image" content="{{$image}}" >
<meta property="og:type" content="og:product" />
<meta property="og:url" content="{{Request::url()}}" />

<meta property="fb:app_id" content="<?=$main_company['facebook_app_id']?>" />
<script type="application/ld+json">
    {
      "@context": "http://schema.org/",
      "@type": "Product",
      "name": "{{$title}}",
      "image": "{{$image}}",
      "description": "{{$description}}",
      "mpn": "{{$id}}",
      "brand": {
        "@type": "Thing",
        "name": "{{$brand}}"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{$rate_val}}",
        "reviewCount": "{{$rate_count}}"
      }
    }
</script>