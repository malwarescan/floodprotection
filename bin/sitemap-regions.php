<?php
$host = 'https://floodbarrierpros.com';
$csv = __DIR__.'/../data/swfl_regions.csv';
$rows=[]; 
if(($h=fopen($csv,'r'))!==false){ 
  $head=fgetcsv($h, 0, ',', '"', "\\"); 
  while(($r=fgetcsv($h, 0, ',', '"', "\\"))!==false){ 
    if(count($r) === count($head)) {
      $rows[]=array_combine($head,$r);
    }
  }
  fclose($h);
}

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
$xml->addAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');
$urls = ['/regions/'];
foreach($rows as $r){ $urls[] = '/regions/'.$r['slug'].'/'; }
foreach($urls as $u){
  $n = $xml->addChild('url');
  $n->addChild('loc',$host.$u);
  $n->addChild('changefreq','weekly');
  $n->addChild('priority','0.7');
}
file_put_contents(__DIR__.'/../public/sitemaps/sitemap-regions.xml',$xml->asXML());
echo "sitemap-regions.xml written\n";
