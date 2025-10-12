<?php

namespace AuditLib;

class Report
{
    public static function score(array $weights, array $parts): int
    {
        $sum = 0;
        
        foreach ($parts as $k => $ok) {
            $sum += ($ok ? $weights[$k] ?? 0 : 0);
        }
        
        return $sum;
    }

    public static function csv(string $path, array $rows): void
    {
        if (!$rows) return;
        
        $fp = fopen($path, 'w');
        fputcsv($fp, array_keys($rows[0]), ',', '"', '\\');
        
        foreach ($rows as $r) {
            fputcsv($fp, $r, ',', '"', '\\');
        }
        
        fclose($fp);
    }

    public static function md(string $path, array $summary, array $rows): void
    {
        $out = "# SEO Audit Report\n\n";
        $out .= "*Comprehensive site audit - all URLs validated*\n\n";
        
        foreach ($summary as $k => $v) {
            $out .= "- **$k:** $v\n";
        }
        
        $out .= "\n## Summary Statistics\n\n";
        
        // Calculate stats
        $totalScore = 0;
        $perfectScores = 0;
        $failing = [];
        
        foreach ($rows as $r) {
            $totalScore += $r['score'];
            if ($r['score'] >= 90) $perfectScores++;
            if ($r['score'] < 70) $failing[] = $r;
        }
        
        $avgScore = count($rows) > 0 ? round($totalScore / count($rows), 1) : 0;
        
        $out .= "| Metric | Value |\n";
        $out .= "|--------|-------|\n";
        $out .= "| Total URLs | " . count($rows) . " |\n";
        $out .= "| Average Score | {$avgScore}/100 |\n";
        $out .= "| Scores ≥90 | $perfectScores |\n";
        $out .= "| Scores <70 | " . count($failing) . " |\n\n";
        
        if (!empty($failing)) {
            $out .= "## Pages Needing Attention (Score <70)\n\n";
            $out .= "| URL | Score | Issues |\n";
            $out .= "|-----|-------|--------|\n";
            
            foreach (array_slice($failing, 0, 20) as $r) {
                $url = self::esc(str_replace('https://floodbarrierpros.com', '', $r['url']));
                $out .= "| $url | {$r['score']} | " . self::esc($r['notes']) . " |\n";
            }
            
            $out .= "\n";
        }
        
        $out .= "## All URLs\n\n";
        $out .= "| URL | Score | Title | Meta | Canon | Content | Schema | URL | Notes |\n";
        $out .= "|-----|------:|:-----:|:----:|:-----:|:-------:|:------:|:---:|-------|\n";
        
        foreach ($rows as $r) {
            $url = self::esc(str_replace('https://floodbarrierpros.com', '', $r['url']));
            $out .= "| $url | {$r['score']} | ";
            $out .= self::ok($r['ok_title']) . " | ";
            $out .= self::ok($r['ok_meta']) . " | ";
            $out .= self::ok($r['ok_canonical']) . " | ";
            $out .= self::ok($r['ok_content']) . " | ";
            $out .= self::ok($r['ok_schema']) . " | ";
            $out .= self::ok($r['ok_url']) . " | ";
            $out .= self::esc(substr($r['notes'], 0, 100)) . " |\n";
        }
        
        file_put_contents($path, $out);
    }

    private static function ok($b): string
    {
        return $b ? "✔" : "✗";
    }

    private static function esc($s): string
    {
        return str_replace('|', '\|', $s);
    }
}

