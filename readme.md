# Welkom bij snakeMvc

Welkom bij snakeMvc, dit is een HTTP framework. In tegenstelling tot het populaire Zend framework is dit geen MVC framework. Het is gebasseerd op het Symfony Framework, wat ook een HTTP framework is.

## Wat is een HTTP framework

Een HTTP framework werkt via hoe een pagina opgevraagt wordt. Dit betekend dat als de bezoeker een url intypt hij een HTTP Request stuurt naar de server en de server zoekt de pagina, vraag eventuele extra pagina's aan en geeft een HTTP Response terug, met daarin onder anderen de pagina content. Een browser handelt het dan verder af.
Dit proberen we zo goed mogelijk te interpeteren in snakeMvc. Per request wordt er een Request object gemaakt, met daarin alle headers, sessies, cookies, get/post variabelen, kortom alles van de gebruiker. In de Controller die je maakt worden deze gegevens van de gebruiker samengevoegd met die van de server, dus van de DB en de templates. Deze hele samenvoeging en eventuele headers sturen we dan via een Response object terug naar de browser die er vervolgens een mooie en leesbare pagina van maakt.
