<?php
function regions_nav($regions){
  echo '<nav class="border-b bg-white sticky top-0 z-50 shadow-sm"><div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap gap-3">';
  echo '<div class="w-full sm:w-auto text-sm font-medium text-gray-900 mb-2 sm:mb-0">SWFL Regions:</div>';
  foreach($regions as $r){
    echo '<a class="text-sm text-blue-600 hover:underline hover:text-blue-800" href="/regions/'.$r['slug'].'/">'.esc($r['region']).'</a>';
  }
  echo '</div></nav>';
}
