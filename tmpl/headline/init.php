<?php

$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/default.css');
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/headline.css');

$totalItemsPerSlide = $params->get('no_intro_items', 1) + $params->get('no_link_items', 4);
$index = 0;
$count = 0;
foreach ($items as $item)
{
    $list[$index][] = $item;
    $count++;
    if ($count == $totalItemsPerSlide)
    {
        $index++;
        $count = 0;
    }
}