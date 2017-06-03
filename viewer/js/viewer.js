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
      $(icon).css('border-color', 'rgba(49,140,18,0.57)');
    }else {
      $(icon).css('border-color', 'rgb(238, 238, 238)');
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
      $('#swich_html2txt').css('border-color', 'rgba(49,140,18,0.57)');
    });
  } else {
    $('#mainTXT').fadeToggle("slow", function(){
      $('#mainHTML').fadeToggle("slow");
      $('#swich_html2txt').css('border-color', 'rgb(238, 238, 238)');
    });
  }
}