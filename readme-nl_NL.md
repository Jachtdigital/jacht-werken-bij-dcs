# Jacht - Werken bij DCS

**WordPress plugin voor vacaturebeheer.**

Deze WordPress plugin, ontwikkeld door [Jacht Digital Marketing](https://jacht.digital/), biedt een compleet systeem voor het beheren van vacatures op WordPress websites met geavanceerde functies zoals meertalige ondersteuning, Schema.org gestructureerde data en volledige aanpassingsmogelijkheden.

----------

## Beschrijving

### Vacaturebeheer

Deze plugin biedt een compleet vacaturebeheer systeem voor WordPress. Vacatures kunnen direct binnen WordPress worden aangemaakt en beheerd, met ondersteuning voor meerdere talen via Polylang integratie.

### Rich Snippets / Schema.org Gestructureerde Data

Ingebouwde JobPosting gestructureerde data gebaseerd op Schema.org specificaties voor betere SEO en Google Jobs integratie. De gestructureerde data bevat:

- Functietitel, beschrijving en vereisten
- Locatie-informatie (plaats, provincie, land)
- Type dienstverband (fulltime, parttime, stage, freelance)
- Salarisinformatie (min/max met valuta en periode)
- Thuiswerk opties
- Opleidings- en ervaringseisen
- Bedrijfsinformatie

De gestructureerde data kan worden aangepast of uitgebreid met het `rec_structured_data` filter.

----------

## Functies

- **Vacature custom post type**: Speciaal post type voor het beheren van vacatures
- **Advanced Custom Fields**: Uitgebreide meta velden voor vacature details (locatie, salaris, type dienstverband, etc.)
- **Dupliceer functionaliteit**: Eenvoudig vacatures dupliceren met alle velden en metadata
- **Meertalige ondersteuning**: Volledige integratie met Polylang voor meertalige vacature sites (Nederlands en Engels inbegrepen)
- **Schema.org JobPosting**: Automatische gestructureerde data voor betere SEO en Google Jobs
- **Afdelingen taxonomie**: Organiseer vacatures per afdeling
- **Logs en debugging**: Gedetailleerde logs voor probleemoplossing
- **Frontend templates**: Voorbeeld templates voor het tonen van vacatures (thema aanpassing vereist)
- **Gravity Forms integratie**: Placeholder voor custom sollicitatieformulier implementatie

----------

## Installatie

1. **Download de plugin**:
    - Download de laatste release ZIP van [GitHub Releases](https://github.com/Jachtdigital/jacht-werken-bij-dcs/releases)

2. **Installeren via WordPress**:
    - Ga naar WordPress Admin → Plugins → Nieuwe plugin → Plugin uploaden
    - Selecteer het gedownloade ZIP bestand
    - Klik op "Nu installeren" en vervolgens "Activeren"

3. **Handmatige installatie**:
    - Upload de plugin bestanden naar de `/wp-content/plugins/jacht-werken-bij-dcs` map
    - Activeer de plugin via het 'Plugins' scherm in WordPress

4. **Na activatie**:
    - Ga naar Instellingen → Permalinks en klik op "Wijzigingen opslaan" om rewrite rules te vernieuwen
    - Zorg ervoor dat Advanced Custom Fields Pro is geïnstalleerd en geactiveerd

----------

## Vereisten

- **WordPress**: Minimum 6.2 (getest tot 6.5)
- **PHP**: Minimum 8.1 (getest tot 8.3)
- **Advanced Custom Fields Pro**: Vereist voor meta veld beheer
- **Polylang Pro**: Optioneel, voor meertalige sites
- **Gravity Forms**: Optioneel, voor sollicitatieformulieren (minimum 2.5)

----------

## Configuratie

### Dashboard Instellingen

Ga naar plugin instellingen via **Vacatures → Instellingen** in WordPress admin.

**Beschikbare tabbladen**:
- **Instellingen**: Vacature overzicht en beheer
- **Logs**: Debug logs voor probleemoplossing
- **Over**: Plugin informatie en documentatie
- **Wijzigingslog**: Versie geschiedenis en updates

### Aanpassingsmogelijkheden

#### Labels en Slug

Pas post type labels aan met WordPress filters:

- **Meervoud/titel**: `rec_cpt_title` (standaard: "Vacatures")
- **Enkelvoud**: `rec_cpt_single` (standaard: "Vacature")
- **URL slug**: `rec_cpt_slug` (standaard: "jobs")

Voorbeeld:
```php
add_filter('rec_cpt_slug', function() {
    return 'careers';
});
```

#### Gestructureerde Data

Pas Schema.org gestructureerde data aan:

```php
add_filter('rec_structured_data', function($data) {
    // Wijzig $data array
    return $data;
});
```

----------

## Frontend Integratie

### Template Bestanden

De plugin bevat voorbeeld templates in de `examples/` map:

1. **archive-vacancy.php**: Vacature overzichtspagina template
2. **single-vacancy.php**: Individuele vacature detailpagina template
3. **functions.php**: Helper functies voor het ophalen en tonen van vacature data

### Templates Gebruiken

1. Kopieer de voorbeeld bestanden van `examples/` naar je thema map
2. Pas de templates aan om te matchen met je thema design
3. Gebruik de helper functies om vacature informatie te tonen

----------

## Taalondersteuning

De plugin ondersteunt meerdere talen:

- **Nederlands (nl_NL)**: Standaard taal
- **Engels (en_US)**: Beschikbaar als vertaling

Om van taal te wisselen:
1. Ga naar **Instellingen → Algemeen**
2. Wijzig **Sitetaal** naar je gewenste taal
3. Sla wijzigingen op

----------

## Probleemoplossing

### Veelvoorkomende Problemen

**Vacatures verschijnen niet**:
- Ga naar Instellingen → Permalinks en klik op "Wijzigingen opslaan"
- Zorg ervoor dat de plugin is geactiveerd
- Controleer dat ACF Pro is geïnstalleerd en geactiveerd

**404 fouten op vacature pagina's**:
- Vernieuw permalinks: Instellingen → Permalinks → Wijzigingen opslaan

**Vacatures gaan naar prullenbak bij aanmaken**:
- Deactiveer en heractiveer de plugin om rechten te vernieuwen

**Vertaling werkt niet**:
- Controleer of je WordPress site taal correct is ingesteld
- Controleer of vertaalbestanden bestaan in de `languages/` map

----------

## Ondersteuning

Voor ondersteuning, neem contact op met [Jacht Digital Marketing](https://jacht.digital):

- **E-mail**: [info@jacht.digital](mailto:info@jacht.digital)
- **Website**: [https://jacht.digital](https://jacht.digital)
- **GitHub Issues**: [Meld een bug](https://github.com/Jachtdigital/jacht-werken-bij-dcs/issues)

----------

## Licentie

Deze plugin is beschikbaar onder een licentieovereenkomst met Jacht Digital Marketing.

----------

## Wijzigingslog

Zie het [CHANGELOG.md](changelog.md) bestand voor gedetailleerde versie geschiedenis en updates.

----------

## Credits

Ontwikkeld door [Jacht Digital Marketing](https://jacht.digital/)

**Tags**: vacatures, vacancies, jobs, recruitment, schema.org, jobposting
