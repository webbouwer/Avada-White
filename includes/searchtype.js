// Add search type variable to form url
jQuery(document).ready(function($){
$(‘<input>’).attr({type: ‘hidden’,name: ‘post_type’,value : ‘travel’ }).appendTo(‘.searchform’);
//$(‘<input>’).attr({type: ‘hidden’,name: ‘post_type’,value : ‘travel’ }).appendTo(‘.widget_search form’);
//$(‘<input>’).attr({type: ‘hidden’,name: ‘post_type’,value : ‘travel’ }).appendTo(‘.et_search_form_container form’);
});
