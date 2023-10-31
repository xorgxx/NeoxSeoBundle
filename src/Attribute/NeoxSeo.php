<?php
    
    namespace NeoxSeo\NeoxSeoBundle\Attribute;
    
    use Attribute;
    use NeoxSeo\NeoxSeoBundle\Model\SeoBag;
    
    /**
     *  https://www.geeksforgeeks.org/html-meta-tag/
     *
     *  This attribute is used to define the name of the property.
     *  name        : <meta name="keywords" content="Meta Tags, Metadata" />
     *
     *  This attribute is used to get the HTTP response message header.
     *  http-equiv  : <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     *
     *  This attribute is used to specify properties value.
     *  content     : <meta content="width=device-width, initial-scale=1, maximum-scale=1">
     *
     *  This attribute is used to specify a character encoding for an HTML file.
     *  charset     : <meta charset="character_set">
     *
     *  Determines a scheme to be utilized to decipher the value of the substance attribute.
     *  scheme: <meta name="keywords" content="Meta Tags, Metadata" scheme="ISBN" />
     *
     *
     *      <html {{ neox_seo_html_attributes() }}>
     *      <head {{ neox_seo_head_attributes() }}>
     *          {{ neox_seo_title() }}
     *          {{ neox_seo_metadatas() }}
     *          {{ neox_seo_link_canonical() }}
     *          {{ neox_seo_lang_alternates() }}
     */
    
    #[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
    class NeoxSeo extends SeoBag
    {
        public function __construct(
            public ?string       $title          = null,
            public ?string       $preFixTitle    = null,
            public ?string       $surFixTitle    = null,
            public ?string       $charset        = null,
            public ?array        $link           = [],
            public ?array        $metasHttpEquiv = [],
            public ?array        $metasName      = [],
            public ?array        $metasProperty  = [],
            public ?array        $metasItemprop  = [],
        ) {}
    }