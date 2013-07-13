Valve-KeyValue-parser
=====================

Fast Valve KeyValue format parser php


###Example usage
<pre><code>$url = 'http://media.steampowered.com/apps/816/scripts/items/items_game.494df2490af8d895d9ed9a7c320ed0cc8b083dbe.txt';

$parser = new KeyValueParser();
$parser->load($url);
$parser->parse();

$object = $parser->toObj();
</code></pre>
