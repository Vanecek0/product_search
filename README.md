<h1>Vyhledání informací o produktu</h1>
<p>Cílem bylo vytvořit API pro získání informací o
    produktu s podporou cache, přepínání mezi datovými zdroji (ElasticSearch / MySQL) a počítáním zobrazení produktu.
</p>
<h2>Funkce</h2>
<ul>
    <li>Získání detailu produktu podle id (<code>/products/{id}</code>)</li>
    <li>Automatické cachování produktů</li>
    <li>Přepínání mezi datovými zdroji (ElasticSearch / MySQL)</li>
    <li>Získání počtu zobrazení (<code>/products/{id}/views</code>)</li>
    <li>Konfigurace v <code>/config/services.yaml</code> a <code>/config/packeges/cache.yaml</code></li>
</ul>
<h2>Architektura</h2>
<ul>
    <li><strong>Controller</strong> – vstupní bod</li>
    <li><strong>Service layer</strong> – business logika (ProductService, CounterService)</li>
    <li><strong>Repository</strong> – abstrakce nad datovým zdrojem</li>
    <li><strong>Drivers</strong> – ElasticSearch, MySQL, ...</li>
    <li><strong>Cache layer</strong> – Symfony Cache (filesystem, Redis, ...)</li>
    <li><strong>KeyBuilder</strong> – generování konzistentních cache klíčů</li>
</ul>
<h2>Použité technologie</h2>
<ul>
    <li><a href="https://symfony.com/">Symfony 8.0.7</a></li>
    <li><a href="https://www.php.net/">PHP 8.4+</a></li>
    <li><a href="https://symfony.com/doc/current/components/cache.html">Symfony Cache</a></li>
</ul>
<h2>API endpointy</h2>
<h3>GET /products/{id}</h3>
<p>Vrátí detail produktu a zároveň inkrementuje počet zobrazení.</p>
<pre> { "data": { "id": 1, "name": "Wireless Mouse", ... } } </pre>
<h3>GET /products/{id}/views</h3>
<p>Vrátí počet zobrazení produktu.</p>
<pre> { "views": 12 } </pre>
<h2>Cache</h2>
<ul>
    <li>Produkty jsou cachovány pomocí Symfony Cache</li>
    <li>Možnost přepnutí mezi: <ul>
            <li>Filesystem cache</li>
            <li>Redis (doporučeno pro production)</li>
            <li>další podporované adaptéry Symfony Cache</li>
        </ul>
    </li>
</ul>
<h2>Počítání zobrazení</h2>
<ul>
    <li>Implementováno pomocí cache</li>
    <li>Každý request na produkt zvýší counter</li>
    <li>Připraveno na budoucí přechod na Redis (atomic increment), aktuální stav neřeší problém s race conditions!</li>
</ul>
<h2>Doporučené požadavky</h2>
<ul>
    <li><strong>PHP</strong> verze 8.4+</li>
    <li><strong>Composer</strong> verze 2.8+</li>
    <li><strong>Symfony CLI</strong> (volitelné)</li>
    <li><strong>Redis</strong> (volitelné, pro production)</li>
</ul>
<h2>Instalace</h2>
<ol>
    <li>Naklonujte repozitář</li>
    <li>Vytvořte .env soubor nebo přejmenujte .env.example na .env v rootu</li>
    <li>Spusťte <code>composer install</code></li>
    <li>Spusťte server: <ul>
            <li><code>symfony server:start</code></li>
            <li>nebo <code>php -S localhost:8000 -t public</code></li>
        </ul>
    </li>
    <li>Otevřete např. <a href="http://localhost:8000/products/1">http://localhost:8000/products/1</a></li>
</ol>

<h2>Konfigurace driveru</h2>
<p>Pro změnu driveru stačí odkomentovat např.</p>
<pre>
    # ElasticSearch driver
    #App\Driver\ProductDriverInterface:
    #    class: App\Driver\ElasticSearchDriver
</pre>
<p>A zakomentovat např.</p>
<pre>
    # MySQL driver
    App\Driver\ProductDriverInterface:
        class: App\Driver\MySQLDriver
</pre>

<h2>Konfigurace cache</h2>
<p>Ukázka konfigurace (filesystem):</p>
<pre>
    framework: 
        cache: 
            pools: 
                product_cache: 
                    adapters: 
                        - cache.adapter.filesystem
                        #- cache.adapter.redis
                    default_lifetime: 0
                counter_cache: 
                    adapters: 
                        - cache.adapter.filesystem 
                        #- cache.adapter.redis
                    default_lifetime: 0
</pre>
<p>Pro Redis stačí odkomentovat adapter:</p>
<pre>#-cache.adapter.redis</pre>
<p>Pokud budou odkomentovány oba adaptery, Symfony zkusí cache položku získat sekvenčně (nejprve z prvního definovaného adapteru)</p>

<h2>Poznámky</h2>
<ul>
    <li>Jednoduchá rozšiřitelnost (nový driver, jiný cache backend)</li>
    <li>Race conditions u počítadla lze řešit pomocí Redis (INCR)</li>
</ul>
