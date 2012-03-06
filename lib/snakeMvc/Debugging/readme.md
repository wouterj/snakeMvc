# Debugging

Welkom op het debugging onderdeel van snakeMvc. Dit onderdeel wordt alleen gebruikt als je je site in develop of production mode staat. Hier staan alle tools in waarmee snakeMvc jou errors laat zien, maar ook waarmee jij heel makkelijk je code kan debuggen en testen.

## Debug

Dit is het bestand voor jou. In de Debug klasse vind je allemaal static methods waarmee je dingen kunt debuggen. Veel van deze methods zijn afgeleid van wat je krijgt met xdebug, maar natuurlijk altijd met een eigen snakeMvc tintje eraan :)

### Debug::dump()

De dump method is de vervanging van [`var_dump`][1]. `Var_dump` laat de code een beetje slecht zien. Het is eigenlijk een functie een `var` te laten zien zoals het systeem het ziet. Dit is natuurlijk erg leuk, maar niet heel leuk om te lezen. 
Met `Debug::dump()` heb ik daar verandering in proberen te brengen. Laat zien wat het systeem ziet, maar dan wel op zo'n manier dat wij als developers het begrijpen. Ik heb geprobeerd om een beetje de source code van PHP na te apen. Als je bijv. een object in deze method stopt krijg je de code van een klasse te zien met de gegevens van dat object erin verwerkt. Het wordt daardoor allemaal stukken duidelijker.

    Debug::dump( mixed $var1, mixed $var2, $..., bool $return = false )

Je kunt zoveel variabele in de functie stoppen als je maar wilt. Maar zodra je meer dan 1 variabele in de functie plaatst zien we de laatste variabele als een return variabele. Als de laatste dus `true` is zal deze method het niet echoën, maar returnen. Let hier op. Als je dus meer dan 1 waarde wilt echoën moet je zorgen dat je als laatste argument false meegeeft.

  [1]: http://php.net/var-dump
