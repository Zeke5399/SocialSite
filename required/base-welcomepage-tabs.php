<?php

$posts = postDB::getAllPublicPosts();
$count = 0;
$itemsPerPage = 10;
$pageCount = 0;
$pages = 1;
$currentPage = filter_input(INPUT_GET, 'page');
if ($currentPage == null) {
    $currentPage = 1;
}
//Determines how many pages are needed.
foreach ($posts as $post) {
    $count += 1;
    $pageCount += 1;
    if ($pageCount >= $itemsPerPage) {
        $pages += 1;
        $pageCount = 0;
    }
}
$filteredPosts = postDB::getAllPublicPostsByPage($currentPage, $itemsPerPage);
