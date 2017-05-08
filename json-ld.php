<?php

function get_post_data()
{
    
    global $post;
    return $post;
    
}

// stuff for any page 

$payload["@context"] = "http://schema.org/";

// this has all the data of the post/page etc 

$post_data = get_post_data();

// stuff for any page, if it exists 

$category = get_the_category();

// stuff for specific pages 

$post_meta = get_post_meta();

if (is_single()) {
    
    
    $author_data = get_post_meta(get_the_ID(), 'author', true);
    
    $post_url   = get_permalink();
    $post_thumb = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    
    $payload["@type"]            = "NewsArticle";
    $payload["url"]              = $post_url;
    $payload["author"]           = array(
        "@type" => "Person",
        "name" => $author_data
    );
    $payload["headline"]         = $post_data->post_title;
    $payload["datePublished"]    = $post_data->post_date;
    $payload["dateModified"]     = $post_data->post_date;
    $payload["mainEntityOfPage"] = $post->post_content;
    
    
    list($width, $height) = getimagesize($post_thumb);
    $payload["image"] = array(
        "@type" => "ImageObject",
        "url" => $post_thumb,
        "height" => $height,
        "width" => $width
    );
    
    $payload["ArticleSection"] = $category[0]->cat_name;
    
    $payload["publisher"] = array(
        "@type" => "Organization",
        "name" => "Iran International News",
        "logo" => array(
            "@type" => "ImageObject",
            "url" => "http://globalcyberit.wpengine.com/wp-content/themes/herald/assets/images/logo-google-need.png",
            "width" => 320,
            "height" => 60
        )
    );
}

// we do all this separately so we keep the right things for organization together 

if (is_front_page()) {
    
    $payload["@type"]        = "Organization";
    $payload["name"]         = "Iran International News";
    $payload["legalName"]    = "INN LLC";
    $payload["foundingDate"] = "2017";
    $payload["Founder"]      = array(
        "@type" => "Person",
        "name" => "INI Founder"
    );
    $payload["logo"]         = "http://globalcyberit.wpengine.com/wp-content/themes/herald/assets/images/logo-google-need.png";
    $payload["url"]          = "http://globalcyberit.wpengine.com/";
    $payload["sameAs"]       = array(
        "https://twitter.com/",
        "https://www.facebook.com/",
        "https://www.linkedin.com/company/",
        "https://plus.google.com/"
    );
    
    $payload["contactPoint"] = array(
        array(
            
            "@type" => "ContactPoint",
            "telephone" => "+1 704 706 4492",
            "email" => "globalcyberit@gmail.com",
            "contactType" => "customer service"
        )
    );
    
}
if (is_author()) {
    
    $author_data      = get_userdata($post_data->post_author);
    $twitter_url      = " https://twitter.com/";
    $twitterHandle    = get_the_author_meta('twitter');
    $twitterHandleURL = $twitter_url . $twitterHandle;
    $websiteHandle    = get_the_author_meta('url');
    $facebookHandle   = get_the_author_meta('facebook');
    $gplusHandle      = get_the_author_meta('googleplus');
    $linkedinHandle   = get_the_author_meta('linkedin');
    $slideshareHandle = get_the_author_meta('slideshare');
    
    $payload["@type"]  = "Person";
    $payload["name"]   = $author_data->display_name;
    $payload["email"]  = $author_data->user_email;
    $payload["sameAs"] = array(
        $twitterHandleURL,
        $websiteHandle,
        $facebookHandle,
        $gplusHandle,
        $linkedinHandle,
        $slideshareHandle
    );
    
    
}


?>
