<?php
function jsonld_service($r){
  $name = $r['region'].' Flood Barriers & Perimeter Systems';
  $url  = 'https://'.$_SERVER['HTTP_HOST'].'/regions/'.$r['slug'].'/';
  $area = $r['region'].', '.$r['county'].' County, '.$r['state'];
  return [
    "@context"=>"https://schema.org",
    "@type"=>"Service",
    "name"=>$name,
    "provider"=>[
      "@type"=>"LocalBusiness",
      "name"=>"Flood Barrier Pros — Southwest Florida",
      "areaServed"=>$area,
      "address"=>[
        "@type"=>"PostalAddress",
        "addressRegion"=>"FL",
        "addressCountry"=>"US"
      ],
      "telephone"=>"+1-239-425-6722",
      "url"=>"https://".$_SERVER['HTTP_HOST']."/"
    ],
    "areaServed"=>$area,
    "serviceType"=>"Residential flood protection",
    "url"=>$url
  ];
}

function jsonld_breadcrumb($r){
  $url  = 'https://'.$_SERVER['HTTP_HOST'].'/regions/'.$r['slug'].'/';
  return [
    "@context"=>"https://schema.org",
    "@type"=>"BreadcrumbList",
    "itemListElement"=>[
      ["@type"=>"ListItem","position"=>1,"name"=>"Regions","item"=>"https://".$_SERVER['HTTP_HOST']."/regions/"],
      ["@type"=>"ListItem","position"=>2,"name"=>$r['region'],"item"=>$url]
    ]
  ];
}

function jsonld_faq(){
  return [
    "@context"=>"https://schema.org",
    "@type"=>"FAQPage",
    "mainEntity"=>[
      ["@type"=>"Question","name"=>"Do door barriers stop slab uplift?","acceptedAnswer"=>["@type"=>"Answer","text"=>"Barriers concentrate load at openings; we address uplift with slab assessment, joint sealing, and—when conditions warrant—perimeter systems that keep surge off the slab."]],
      ["@type"=>"Question","name"=>"How flat must my threshold be?","acceptedAnswer"=>["@type"=>"Answer","text"=>"We require ≤3 mm variance across the span; we shim/machine and verify with a timed hose test until seepage is within spec."]],
      ["@type"=>"Question","name"=>"Do I need pumps?","acceptedAnswer"=>["@type"=>"Answer","text"=>"Yes. Pumps clear seepage and rainfall inside protected zones. We size GPM to the opening area and head, with backup power and check valves."]]
    ]
  ];
}

function print_jsonld($arr){ 
  echo '<script type="application/ld+json">'.json_encode($arr,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n"; 
}
