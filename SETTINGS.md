# Einstellungen - FSK Landing Warning

JTL Shop4 Plugin

- [Einstellungen - FSK Landing Warning](#einstellungen---fsk-landing-warning)
    - [Allgemein](#allgemein)
        - [Mindest Alter](#mindest-alter)
        - [Meta Tag einfügen](#meta-tag-einf%C3%BCgen)
        - [Header senden](#header-senden)
    - [Landing](#landing)
        - [Text](#text)
        - [Geburtsdatum prüfen](#geburtsdatum-pr%C3%BCfen)
        - [Ablehnen URL](#ablehnen-url)
        - [Bots erlauben](#bots-erlauben)
        - [Landing Page anzeigen](#landing-page-anzeigen)
        - [Landing Page - Seiten Header/Nav/Sidebar/Footer ausblenden](#landing-page---seiten-headernavsidebarfooter-ausblenden)
        - [Dialog anzeigen](#dialog-anzeigen)
        - [Dialog Ajax Submit](#dialog-ajax-submit)
    - [Exportformate anpassen](#exportformate-anpassen)
        - [Label-Z einfügen](#label-z-einf%C3%BCgen)
        - [Zusätzliche Domains](#zus%C3%A4tzliche-domains)
        - [Inhalt Beschreibungen](#inhalt-beschreibungen)
            - [Extra Inhalts Beschreibungen](#extra-inhalts-beschreibungen)
        - [Feature Beschreibungen](#feature-beschreibungen)
            - [Extra Feature Beschreibungen](#extra-feature-beschreibungen)
        - [Übeprüft von](#%C3%BCbepr%C3%BCft-von)

## Allgemein

### Mindest Alter

### Meta Tag einfügen

Fügt folgende zwei Meta Tags in den Header ein:

```html
<meta name="age-meta-label" content="age=[CONTENT_AGE]" />
<meta name="age-de-meta-label" content="age=[CONTENT_AGE] hash: [GENERATED_HASH] v=1.0 kind=sl protocol=all" />
```

### Header senden

Sie können mit zwei Optionen einstellen ob die Header "x-content-age" und/oder "x-age-hash" eingefügt werden sollen.

## Landing

Hier werden Einstellungen für die Landing Page und/oder den Landing Dialog angegeben.

### Text

Sie können hier die AGB oder die Option Sprachvariable verwenden. Um die Sprachvariablen anzupassen gehen Sie im Admin Bereich auf Pluginverwaltung und suchen Sie dort das FSK Plugin. Klicken Sie dort rechts auf den Button "Sprachvariablen anpassen". Der Text wird auf der Landing Page und im Dialog angezeigt.

### Geburtsdatum prüfen

Ist diese Option aktiv wird eine Eingabemöglichkeit für das Geburtsdatum angezeigt wo der Benutzer zuerst ein gültiges Datum eingeben muss bevor er bestätigen kann.

### Ablehnen URL

Wird hier eine URL angegeben so wird der Benutzer beim Ablehnen auf diese Seite weiter geleitet. Falls keine URL angegeben ist wird per JavaScript das Fenster geschlossen.

### Bots erlauben

Per Default wird für Suchmaschinen Bots kein Dialog und keine Landing Page angezeigt. Mit dieser Option können Sie es erlauben. 

### Landing Page anzeigen

Anzeigen einer eigenen HTML Seite bis dass der Benutzer bestätigt hat.

### Landing Page - Seiten Header/Nav/Sidebar/Footer ausblenden

Blenden Sie jeweillige Elemente auf der Landing Page aus.

### Dialog anzeigen

Anzeigen eines Dialoges wo der Hintergrund verschwommen dargestellt wird um keinen direkten Einblick auf den Shop zu geben.

### Dialog Ajax Submit

Ist diese Option aktiv so wird beim Bestätigen im Dialog die Seite nicht neu geladen sondern per AJAX bestätigt.

## Exportformate anpassen

Diverse Einstellungen die die age.xml, age-[country].xml und miracle.xml exporte betreffen.

### Label-Z einfügen

Fügt eine Label-Z Definition in age.xml und age-[country].xml Datein ein.

```xml
<labeltype-label-z-definition>
    <label class="default">
        <min-age>[CONTENT_AGE]</min-age>
    </label>
    <label class="label-z">
        <label-z-type>all</label-z-type>
        <scope>[SHOP_SCOPE(S)]</scope>
        <min-age>[CONTENT_AGE]</min-age>
    </label>
</labeltype-label-z-definition>
```

### Zusätzliche Domains

Wenn weiter Scopes angegeben werden sollen können Sie das hier mit Strichpunkt(;) getrennten Werten machen. Wichtig ist dass die Scopes mit abschliessendem Slash(/) und Stern(*) eingefügt werden.

Beispiel: shop.meinshop.de/*;shopx.meinshop.de/*

### Inhalt Beschreibungen

Für die age.xml und miracle.xml Dateien sollten ein paar Inhaltsbeschreibungen angegeben werden warum der Inhalt nicht jugendfrei ist.

#### Extra Inhalts Beschreibungen

Eigene Werte können hier wieder mit Strichpunkt(;) eingegeben werden.

### Feature Beschreibungen

Für die age.xml und miracle.xml Dateien sollten ein paar Feature Beschreibungen angegeben werden warum die Seite nicht jugendfrei ist.

#### Extra Feature Beschreibungen

Eigene Werte können hier wieder mit Strichpunkt(;) eingegeben werden.

### Übeprüft von

Falls Die Seite von einer Prüfstelle angesehen worden ist können Sie die hier eintragen. Ansonsten sind die Werte self-d bis self-a (im normalfall self-d oder self-c) empfohlen. Genaueres finden Sie unter [wiki.selfhtml.org/wiki/Altersklassifikation#age-issuer](https://wiki.selfhtml.org/wiki/Altersklassifikation#age-issuer).
