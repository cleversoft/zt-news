<?php

$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/default.css');
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/headline.css');

$articles = $ztNews->getProducts($listCategories);
$totalArticlePerSlide = $params->get('no_intro_items', 1) + $params->get('no_link_items', 4);
$index = 0;
$count = 0;
foreach ($articles as $article)
{
    
    $article[0]->cat = $ztNews->getCategoryDetail($article[1]);
    $list[$index][] = $article[0];
    $count++;
    if ($count == $totalArticlePerSlide)
    {
        $index++;
        $count = 0;
    }
}