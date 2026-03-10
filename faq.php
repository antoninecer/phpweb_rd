<?php
require_once __DIR__ . '/inc/bootstrap.php';
$lang = LANG;
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/menu.php';
?>
<section class="main-content">

<?php
$translations = [
  'cs' => '  <h1>Často kladené dotazy (FAQ) ❓</h1>
  <article class="faq-item">
    <h2>🔹 Kdo jste a co nabízíte?</h2>
    <p>Jsme společnost <strong>Right Done s.r.o.</strong>, která se specializuje na prodej a zprostředkování nemovitostí v Kalábrii – krásném a stále cenově dostupném regionu na jihu Itálie. Pomáháme českým i slovenským klientům najít vysněný apartmán u moře, ať už pro rekreaci, investici, nebo trvalé bydlení.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Proč právě Kalábrie?</h2>
    <p>Kalábrie je jedním z posledních míst v Itálii, kde můžete koupit nemovitost blízko moře za rozumnou cenu. Nabízí krásné pláže, historická města, přátelské obyvatelstvo a typickou jižanskou atmosféru – bez masového turismu.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Jsou ceny opravdu tak nízké?</h2>
    <p>Ano. V Kalábrii lze koupit plně funkční apartmán již od cca 20 000 €. Nejde o opuštěné domy „za euro“, ale o reálné byty v obydlených lokalitách, často s výhledem na moře nebo v docházkové vzdálenosti od pláže.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Co všechno mi pomůžete zařídit?</h2>
    <p>Zajišťujeme kompletní servis:</p>
    <ul>
      <li>výběr vhodné nemovitosti,</li>
      <li>právní prověření a překlady smluv,</li>
      <li>jednání s notářem,</li>
      <li>registraci na katastru a daňovém úřadě,</li>
      <li>převody energií,</li>
      <li>případně i rekonstrukci nebo správu nemovitosti.</li>
    </ul>
  </article>
  <article class="faq-item">
    <h2>🔹 Musím umět italsky?</h2>
    <p>Ne. Vše probíhá v češtině nebo slovenštině. Komunikaci s italskými úřady a partnery zařídíme za vás.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Je možné si nemovitost před koupí prohlédnout?</h2>
    <p>Ano. Nabízíme dvě možnosti:</p>
    <ol>
      <li>Osobní prohlídka – pomůžeme vám s organizací cesty a prohlídek na místě.</li>
      <li>Videoprohlídka na dálku – pokud se nemůžete dostavit osobně, natočíme nebo zprostředkujeme podrobnou prohlídku nemovitosti na videu (nebo online hovor přímo z místa).</li>
    </ol>
  </article>
  <article class="faq-item">
    <h2>🔹 Kolik stojí celý proces nákupu?</h2>
    <p>Kromě kupní ceny je třeba počítat s:</p>
    <ul>
      <li>notářskými a úředními poplatky,</li>
      <li>daní z převodu nemovitosti,</li>
      <li>přepisem a službami souvisejícími s převodem (cca 5 000–9 000 € dle konkrétní situace).</li>
    </ul>
    <p>Naše provize je předem dohodnutá a transparentní.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Lze koupit na dálku?</h2>
    <p>Ano. Nemovitost lze koupit i zcela na dálku. Veškeré dokumenty zašleme elektronicky, a pokud je potřeba, zajistíme i zastupování na základě plné moci. Tento postup využívá řada klientů, kteří nemohou cestovat.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Pomůžete i s pronájmem?</h2>
    <p>Ano. Pokud kupujete nemovitost jako investici, umíme zajistit:</p>
    <ul>
      <li>správu pronájmu,</li>
      <li>komunikaci s hosty,</li>
      <li>úklid a údržbu,</li>
      <li>případné sezónní inzerce na Airbnb a Booking.</li>
    </ul>
  </article>
  <article class="faq-item">
    <h2>🔹 Jak začít?</h2>
    <p>Stačí nás kontaktovat přes webový formulář, e-mail nebo telefon. Sdělte nám svou představu a rozpočet, a my vám navrhneme konkrétní nabídky a další kroky. S námi je nákup nemovitosti v Itálii jednoduchý, bezpečný a bez jazykových bariér.</p>
  </article>
',
  'en' => '  <h1>Frequently Asked Questions (FAQ) ❓</h1>
  <article class="faq-item">
    <h2>🔹 Who are you and what do you offer?</h2>
    <p>We are <strong>Right Done s.r.o.</strong>, a company specializing in the sale and mediation of real estate in Calabria – a beautiful and still affordable region in southern Italy. We help Czech and Slovak clients find their dream seaside apartment, whether for vacation, investment, or permanent residence.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Why Calabria?</h2>
    <p>Calabria is one of the last places in Italy where you can buy property close to the sea at a reasonable price. It offers beautiful beaches, historic towns, friendly locals, and a typical southern atmosphere – without mass tourism.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Are the prices really that low?</h2>
    <p>Yes. In Calabria, you can buy a fully functional apartment starting at around €20,000. These are not abandoned houses “for one euro”, but real apartments in populated areas, often with sea views or within walking distance of the beach.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 What can you help me with?</h2>
    <p>We provide full service:</p>
    <ul>
      <li>selection of a suitable property,</li>
      <li>legal checks and contract translations,</li>
      <li>notary arrangements,</li>
      <li>land registry and tax office registration,</li>
      <li>utility transfers,</li>
      <li>renovation or property management if needed.</li>
    </ul>
  </article>
  <article class="faq-item">
    <h2>🔹 Do I need to speak Italian?</h2>
    <p>No. Everything is handled in Czech or Slovak. We handle communication with Italian authorities and partners for you.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Can I view the property before buying?</h2>
    <p>Yes. We offer two options:</p>
    <ol>
      <li>Personal viewing – we help you arrange the trip and property tours on-site.</li>
      <li>Remote video tour – if you can’t be there in person, we will film or arrange a detailed video tour of the property (or a live video call directly from the location).</li>
    </ol>
  </article>
  <article class="faq-item">
    <h2>🔹 How much does the whole purchase process cost?</h2>
    <p>In addition to the purchase price, you should expect:</p>
    <ul>
      <li>notary and administrative fees,</li>
      <li>real estate transfer tax,</li>
      <li>transfer and related services (about €5,000–9,000 depending on the situation).</li>
    </ul>
    <p>Our commission is pre-agreed and transparent.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Can I buy remotely?</h2>
    <p>Yes. The property can be purchased completely remotely. All documents are sent electronically, and if needed, we can provide representation based on a power of attorney. Many clients who cannot travel use this method.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Do you help with rentals?</h2>
    <p>Yes. If you are buying a property as an investment, we can provide:</p>
    <ul>
      <li>rental management,</li>
      <li>guest communication,</li>
      <li>cleaning and maintenance,</li>
      <li>seasonal listings on Airbnb and Booking if needed.</li>
    </ul>
  </article>
  <article class="faq-item">
    <h2>🔹 How do I start?</h2>
    <p>Just contact us via the web form, email or phone. Tell us your idea and budget, and we will suggest specific offers and next steps. With us, buying real estate in Italy is easy, safe, and without language barriers.</p>
  </article>',
  'de' => '  <h1>Häufig gestellte Fragen (FAQ) ❓</h1>
  <article class="faq-item">
    <h2>🔹 Wer sind Sie und was bieten Sie an?</h2>
    <p>Wir sind die Firma <strong>Right Done s.r.o.</strong>, spezialisiert auf den Verkauf und die Vermittlung von Immobilien in Kalabrien – einer wunderschönen und immer noch erschwinglichen Region im Süden Italiens. Wir helfen tschechischen und slowakischen Kunden, ihre Traumwohnung am Meer zu finden – sei es zur Erholung, als Investition oder für einen dauerhaften Aufenthalt.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Warum gerade Kalabrien?</h2>
    <p>Kalabrien ist einer der letzten Orte in Italien, wo Sie Immobilien in Meeresnähe zu vernünftigen Preisen kaufen können. Es bietet wunderschöne Strände, historische Städte, freundliche Einwohner und ein typisch südliches Ambiente – ganz ohne Massentourismus.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Sind die Preise wirklich so niedrig?</h2>
    <p>Ja. In Kalabrien kann man eine voll funktionsfähige Wohnung bereits ab ca. 20.000 € erwerben. Es handelt sich dabei nicht um verlassene Häuser für „einen Euro“, sondern um echte Wohnungen in bewohnten Gegenden, oft mit Meerblick oder fußläufig zum Strand.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Wobei helfen Sie mir konkret?</h2>
    <p>Wir bieten einen Rundum-Service:</p>
    <ul>
      <li>Auswahl einer geeigneten Immobilie,</li>
      <li>rechtliche Prüfung und Vertragsübersetzungen,</li>
      <li>Notarverhandlungen,</li>
      <li>Eintragungen beim Grundbuch- und Finanzamt,</li>
      <li>Ummeldung von Energieversorgern,</li>
      <li>ggf. auch Renovierung oder Hausverwaltung.</li>
    </ul>
  </article>
  <article class="faq-item">
    <h2>🔹 Muss ich Italienisch können?</h2>
    <p>Nein. Alles erfolgt auf Tschechisch oder Slowakisch. Die Kommunikation mit italienischen Behörden und Partnern übernehmen wir für Sie.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Kann ich die Immobilie vor dem Kauf besichtigen?</h2>
    <p>Ja. Wir bieten zwei Möglichkeiten:</p>
    <ol>
      <li>Persönliche Besichtigung – wir helfen Ihnen bei der Organisation von Reise und Besichtigungen vor Ort.</li>
      <li>Videobesichtigung – wenn Sie nicht persönlich anreisen können, filmen oder organisieren wir eine detaillierte Besichtigung als Video oder Videocall direkt vor Ort.</li>
    </ol>
  </article>
  <article class="faq-item">
    <h2>🔹 Was kostet der gesamte Kaufprozess?</h2>
    <p>Zusätzlich zum Kaufpreis sind zu rechnen mit:</p>
    <ul>
      <li>Notar- und Verwaltungsgebühren,</li>
      <li>Grunderwerbssteuer,</li>
      <li>Ummeldung und Dienstleistungen rund um den Eigentumswechsel (ca. 5.000–9.000 €, je nach Fall).</li>
    </ul>
    <p>Unsere Provision ist im Voraus vereinbart und transparent.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Ist ein Kauf aus der Ferne möglich?</h2>
    <p>Ja. Die Immobilie kann auch vollständig aus der Ferne erworben werden. Alle Unterlagen senden wir elektronisch zu, und wenn nötig, organisieren wir eine Vertretung per Vollmacht. Viele unserer Kunden nutzen diese Option.</p>
  </article>
  <article class="faq-item">
    <h2>🔹 Helfen Sie auch bei der Vermietung?</h2>
    <p>Ja. Wenn Sie die Immobilie als Investition kaufen, bieten wir:</p>
    <ul>
      <li>Vermietungsmanagement,</li>
      <li>Kommunikation mit Gästen,</li>
      <li>Reinigung und Instandhaltung,</li>
      <li>ggf. saisonale Inserate bei Airbnb und Booking.</li>
    </ul>
  </article>
  <article class="faq-item">
    <h2>🔹 Wie beginne ich?</h2>
    <p>Kontaktieren Sie uns einfach über das Webformular, per E-Mail oder Telefon. Teilen Sie uns Ihre Vorstellungen und Ihr Budget mit, und wir unterbreiten Ihnen konkrete Angebote und nächste Schritte. Mit uns ist der Immobilienkauf in Italien einfach, sicher und sprachlich barrierefrei.</p>
  </article>',
  'it' => "  <h1>Domande frequenti (FAQ) ❓</h1>
  <article class=\"faq-item\">
    <h2>🔹 Chi siete e cosa offrite?</h2>
    <p>Siamo la società <strong>Right Done s.r.o.</strong>, specializzata nella vendita e mediazione di immobili in Calabria – una splendida e ancora accessibile regione del sud Italia. Aiutiamo clienti cechi e slovacchi a trovare l'appartamento dei loro sogni al mare, sia per vacanze, investimento o residenza permanente.</p>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 Perché proprio la Calabria?</h2>
    <p>La Calabria è una delle ultime regioni in Italia dove si può acquistare una proprietà vicino al mare a un prezzo ragionevole. Offre spiagge meravigliose, città storiche, persone amichevoli e un'atmosfera meridionale autentica – senza il turismo di massa.</p>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 I prezzi sono davvero così bassi?</h2>
    <p>Sì. In Calabria si può acquistare un appartamento pienamente funzionale a partire da circa 20.000 €. Non si tratta di case abbandonate a 1 €, ma di appartamenti reali in zone abitate, spesso con vista mare o a pochi passi dalla spiaggia.</p>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 Cosa mi aiutate a organizzare?</h2>
    <p>Forniamo un servizio completo:</p>
    <ul>
      <li>selezione della proprietà adatta,</li>
      <li>verifica legale e traduzione dei contratti,</li>
      <li>trattativa con il notaio,</li>
      <li>registrazione al catasto e all'ufficio delle imposte,</li>
      <li>trasferimento delle utenze,</li>
      <li>eventualmente ristrutturazione o gestione della proprietà.</li>
    </ul>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 Devo sapere l'italiano?</h2>
    <p>No. Tutto avviene in ceco o slovacco. Ci occupiamo noi della comunicazione con le autorità e i partner italiani.</p>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 È possibile vedere l'immobile prima dell'acquisto?</h2>
    <p>Sì. Offriamo due opzioni:</p>
    <ol>
      <li>Visita personale – vi aiutiamo a organizzare il viaggio e le visite sul posto.</li>
      <li>Visita video a distanza – se non potete venire di persona, registreremo o organizzeremo una visita dettagliata in video (oppure una chiamata online direttamente dal luogo).</li>
    </ol>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 Quanto costa l'intero processo di acquisto?</h2>
    <p>Oltre al prezzo di acquisto, è necessario considerare:</p>
    <ul>
      <li>tasse notarili e amministrative,</li>
      <li>imposta di trasferimento,</li>
      <li>trascrizione e servizi collegati al trasferimento (circa 5.000–9.000 € a seconda della situazione specifica).</li>
    </ul>
    <p>La nostra commissione è concordata in anticipo ed è trasparente.</p>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 È possibile acquistare a distanza?</h2>
    <p>Sì. È possibile acquistare la proprietà completamente a distanza. Invieremo tutti i documenti elettronicamente e, se necessario, organizzeremo anche la rappresentanza tramite procura. Questo metodo è utilizzato da molti clienti che non possono viaggiare.</p>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 Aiutate anche con l'affitto?</h2>
    <p>Sì. Se acquistate l'immobile come investimento, possiamo offrire:</p>
    <ul>
      <li>gestione dell'affitto,</li>
      <li>comunicazione con gli ospiti,</li>
      <li>pulizia e manutenzione,</li>
      <li>eventuali inserzioni stagionali su Airbnb e Booking.</li>
    </ul>
  </article>
  <article class=\"faq-item\">
    <h2>🔹 Come iniziare?</h2>
    <p>È sufficiente contattarci tramite il modulo sul sito, via e-mail o telefono. Comunicateci la vostra idea e il vostro budget, e noi vi proporremo offerte concrete e i passi successivi. Con noi, acquistare una proprietà in Italia è semplice, sicuro e senza barriere linguistiche.</p>
  </article>"

 
// ostatní jazyky budou následovat jako 'en' => '...', 'de' => '...', 'it' => '...'
];
?>

  <?= $translations[$lang] ?>
  <div class="cta" style="margin-top: 40px;">
    <a href="/contact.php" class="cta-btn">
      <?= [
        'cs' => 'Chci nezávaznou konzultaci',
        'en' => 'Request a free consultation',
        'de' => 'Kostenlose Beratung anfordern',
        'it' => 'Richiedi una consulenza gratuita'
      ][$lang] ?>
    </a>
  </div>
</section>




<?php include __DIR__ . '/inc/footer.php'; ?>
