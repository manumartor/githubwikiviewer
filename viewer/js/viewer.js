/* File: js/viewer.js v.1.0.0 */
/*
 * Github/Bitbucket Wiki Smarty HTML browser viewer JS
 */
$(document).ready(function(){
  //show pages list
  $('#see_allwikipages').click(showAllWikiPages);  
  //show page index
  $('#see_pageindex').click(showPageIndex);
  //show debug lof
  $('#see_debuglog').click(showDebugLog);
  $('#debug').click(showDebugLog);
  $('#debug_content').click(function(){ return false;});
  //switch html to txt
  $('#swich_html2txt').click(switchHtmlToTxt);
});

function showPageIndex(){
  hideAllLayouts('#mainIndex');
  toggleLayout('#mainIndex', '#see_pageindex');
}

function showAllWikiPages(){
  hideAllLayouts('#mainAllWikiPages');
  toggleLayout('#mainAllWikiPages', '#see_allwikipages');
}

function toggleLayout(layout, icon){
  $(layout).fadeToggle("slow", function(){
    if ($(layout).css('display') != 'none'){
      $(icon).addClass('icon_border_selected');
    }else {
      $(icon).removeClass('icon_border_selected');
    }
  });
}

function hideAllLayouts(instead){
  var layouts = [{"l": "#mainIndex", "b": "#see_pageindex"}, {"l": "#mainAllWikiPages", "b": "#see_allwikipages"}];
  for (var layout in layouts){
    layout = layouts[layout];
    if (instead !== '' && instead == layout.l){
      continue;
    }
    if ($(layout.l).css('display') != 'none'){
      toggleLayout(layout.l, layout.b);  
    }
  }
}

function showDebugLog(){
  hideAllLayouts('');
  toggleLayout('#debug', '#see_debuglog');
}

function switchHtmlToTxt(){
  hideAllLayouts('');
  if ($('#mainTXT').css('display') == 'none'){
    $('#mainHTML').fadeToggle("slow", function(){
      $('#mainTXT').fadeToggle("slow");
      $('#swich_html2txt').addClass('icon_border_selected');;
    });
  } else {
    $('#mainTXT').fadeToggle("slow", function(){
      $('#mainHTML').fadeToggle("slow");
      $('#swich_html2txt').removeClass('icon_border_selected');;
    });
  }
}