<?php
require_once __DIR__ . '/inc/bootstrap.php';
$lang = LANG;
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/menu.php';

$translations = [
  'cs' => "<h1>Naše služby</h1>
  <p>Chceš koupit nemovitost ve Scalee, ale nechceš naletět zprostředkovatelům? Pomůžeme ti projít celým procesem – transparentně, lidsky a bez zbytečných poplatků.</p>
  <h2>🔍 Balíček „Průzkumník“ – pro ty, kdo ještě pátrají</h2>
  <ul>
    <li>Konzultace zdarma (telefon, e-mail, zprávy)</li>
    <li>Poradíme, jak vybírat nemovitosti, co si zjistit předem</li>
    <li>Vysvětíme reálné ceny, rozdíly mezi oblastmi a časté triky</li>
    <li>Doporučíme důvěryhodné realitky, se kterými jsme spolupracovali</li>
  </ul>
  <p><strong>Vhodné pro:</strong> všechny, kdo teprve přemýšlejí a nechtějí se spálit.</p>

  <h2>📹 Balíček „Na dálku“ – když se nechceš hned hnát do Itálie</h2>
  <ul>
    <li>Pomůžeme ti vybrat aktuální nemovitosti podle tvých kritérií</li>
    <li>Na místo za tebe pošleme Martina – náš „hodinový manžel“</li>
    <li>Provede detailní prohlídku, natočí video, otestuje vodu, vlhkost, realitu</li>
    <li>Vše bez tlaku a bez nátlaku – ty rozhodneš, jestli chceš pokračovat</li>
  </ul>
  <p><strong>Vhodné pro:</strong> ty, kdo chtějí ušetřit čas a peníze, ale mít jistotu.</p>

  <h2>📁 Balíček „Komfort“ – když se rozhodneš koupit</h2>
  <ul>
    <li>Pomoc s výběrem konkrétní nemovitosti a jednáním s realitkou</li>
    <li>Překlad smluv a dokumentace, výklad právních kroků</li>
    <li>Asistence při podpisu rezervační smlouvy</li>
    <li>Doporučíme notáře, otevřeme ti eurový účet, zajistíme codice fiscale</li>
  </ul>
  <p><strong>Vhodné pro:</strong> ty, kdo už jsou rozhodnutí a chtějí vše správně a klidně.</p>

  <h2>🏠 Balíček „Full servis“ – od A do Z</h2>
  <ul>
    <li>Vše z předchozích balíčků</li>
    <li>Osobní doprovod v Itálii (možnost pobytu v našem apartmánu)</li>
    <li>Po koupi: předání klíčů, převod energií, pojištění</li>
    <li>Doporučení na rekonstrukci, vybavení a správu nemovitosti</li>
  </ul>
  <p><strong>Vhodné pro:</strong> ty, kdo chtějí úplňý klid a profesionální zajištění.</p>

  <h2>💬 Ceny a forma spolupráce</h2>
  <p>Každá služba je naceněna férově a jasně. Za většinu úkonů platíš jen v případě, že se rozhodneš pro nákup. Naše odměna je buď:</p>
  <ul>
    <li>přímo od realitní kanceláře (jsme v oficiální spolupráci),</li>
    <li>nebo formou předem dohodnutého servisního poplatku (např. za prohlídku bytu s videem).</li>
  </ul>
  <p>Žádné skryté poplatky. Vždy víte, co dostanete a kolik to stojí.</p>
  <div class=\"cta\" style=\"margin-top: 40px;\">
    <a href=\"/contact.php\" class=\"cta-btn\">Chci nezávaznou konzultaci</a>
  </div>",
'en' => "  <h1>Our Services</h1>
  <p>Do you want to buy a property in Scalea but avoid falling into the trap of intermediaries? We will guide you through the entire process – transparently, personally, and without unnecessary fees.</p>

  <h2>🔍 ‚Explorer‘ Package – for those still searching</h2>
  <ul>
    <li>Free consultation (phone, email, messages)</li>
    <li>Advice on how to choose properties and what to check beforehand</li>
    <li>Explanation of real prices, area differences, and common tricks</li>
    <li>Recommendations for trustworthy agencies we have worked with</li>
  </ul>
  <p><strong>Ideal for:</strong> everyone who is just considering and wants to avoid costly mistakes.</p>

  <h2>📹 ‚Remote‘ Package – if you don‚t want to rush to Italy</h2>
  <ul>
    <li>We help you select current listings based on your criteria</li>
    <li>We send Martin – our ‚handyman‘ – on-site for you</li>
    <li>He does a detailed inspection, records a video, tests water, humidity, and reality</li>
    <li>No pressure, no obligations – you decide whether to proceed</li>
  </ul>
  <p><strong>Ideal for:</strong> those who want to save time and money but still be sure.</p>

  <h2>📁 ‚Comfort‘ Package – when you decide to buy</h2>
  <ul>
    <li>Help with selecting the property and communicating with the agency</li>
    <li>Translation of contracts and documentation, legal step explanation</li>
    <li>Assistance during the signing of the reservation contract</li>
    <li>We recommend a notary, help open a euro account, and obtain a tax number (codice fiscale)</li>
  </ul>
  <p><strong>Ideal for:</strong> those who have decided and want things done right and calmly.</p>

  <h2>🏠 ‚Full Service‘ Package – from A to Z</h2>
  <ul>
    <li>Everything from the previous packages</li>
    <li>Personal accompaniment in Italy (possibility to stay in our apartment)</li>
    <li>After purchase: handover of keys, utility transfers, insurance</li>
    <li>Recommendations for renovation, furnishing, and property management</li>
  </ul>
  <p><strong>Ideal for:</strong> those who want full peace of mind and professional support.</p>

  <h2>💬 Prices and cooperation</h2>
  <p>Every service is priced fairly and clearly. Most services are only paid if you decide to proceed with the purchase. Our fee is either:</p>
  <ul>
    <li>paid by the real estate agency (official cooperation),</li>
    <li>or a pre-agreed service fee (e.g., for an apartment video tour).</li>
  </ul>
  <p>No hidden fees. You always know what you get and how much it costs.</p>

  <div class=\"cta\" style=\"margin-top: 40px;\">
    <a href=\"/contact.php\" class=\"cta-btn\">Request a free consultation</a>
  </div>",

'de' => "  <h1>Unsere Dienstleistungen</h1>
  <p>Möchten Sie eine Immobilie in Scalea kaufen, aber nicht auf Vermittler hereinfallen? Wir begleiten Sie durch den gesamten Prozess – transparent, persönlich und ohne unnötige Gebühren.</p>

  <h2>🔍 ‚Explorer‘-Paket – für alle, die noch suchen</h2>
  <ul>
    <li>Kostenlose Beratung (Telefon, E-Mail, Nachrichten)</li>
    <li>Tipps zur Auswahl von Immobilien und worauf man im Voraus achten sollte</li>
    <li>Erklärung zu realen Preisen, regionalen Unterschieden und gängigen Tricks</li>
    <li>Empfehlung von vertrauenswürdigen Agenturen, mit denen wir zusammengearbeitet haben</li>
  </ul>
  <p><strong>Geeignet für:</strong> alle, die erst nachdenken und keine Fehler machen möchten.</p>

  <h2>📹 ‚Remote‘-Paket – wenn Sie nicht sofort nach Italien reisen möchten</h2>
  <ul>
    <li>Wir helfen Ihnen bei der Auswahl aktueller Angebote nach Ihren Kriterien</li>
    <li>Wir schicken Martin – unseren ‚Hausmeister‘ – an den Ort</li>
    <li>Er führt eine gründliche Besichtigung durch, filmt ein Video, prüft Wasser, Feuchtigkeit und Zustand</li>
    <li>Ohne Druck – Sie entscheiden selbst, ob Sie fortfahren möchten</li>
  </ul>
  <p><strong>Geeignet für:</strong> alle, die Zeit und Geld sparen, aber dennoch sicher sein wollen.</p>

  <h2>📁 ‚Komfort‘-Paket – wenn Sie sich für einen Kauf entscheiden</h2>
  <ul>
    <li>Hilfe bei der Auswahl einer bestimmten Immobilie und Kommunikation mit der Agentur</li>
    <li>Übersetzung der Verträge und Unterlagen, Erklärung der rechtlichen Schritte</li>
    <li>Begleitung bei der Unterzeichnung des Reservierungsvertrags</li>
    <li>Empfehlung eines Notars, Eröffnung eines Euro-Kontos, Beantragung der Steuernummer (Codice Fiscale)</li>
  </ul>
  <p><strong>Geeignet für:</strong> alle, die sich bereits entschieden haben und alles richtig machen möchten.</p>

  <h2>🏠 ‚Full-Service‘-Paket – von A bis Z</h2>
  <ul>
    <li>Alles aus den vorherigen Paketen</li>
    <li>Persönliche Begleitung in Italien (mit Unterkunft in unserer Wohnung möglich)</li>
    <li>Nach dem Kauf: Schlüsselübergabe, Energieübertragungen, Versicherungen</li>
    <li>Empfehlungen für Renovierung, Einrichtung und Verwaltung</li>
  </ul>
  <p><strong>Geeignet für:</strong> alle, die vollständige Sicherheit und professionelle Betreuung wünschen.</p>

  <h2>💬 Preise und Art der Zusammenarbeit</h2>
  <p>Jede Dienstleistung ist fair und klar bepreist. Die meisten Leistungen zahlen Sie nur, wenn Sie sich zum Kauf entscheiden. Unsere Vergütung erfolgt entweder:</p>
  <ul>
    <li>direkt durch die Immobilienagentur (offizielle Zusammenarbeit),</li>
    <li>oder als vorher vereinbarte Servicegebühr (z. B. für eine Video-Besichtigung).</li>
  </ul>
  <p>Keine versteckten Gebühren. Sie wissen immer, was Sie bekommen und was es kostet.</p>

  <div class=\"cta\" style=\"margin-top: 40px;\">
    <a href=\"/contact.php\" class=\"cta-btn\">Kostenlose Beratung anfordern</a>
  </div>",

'it' => "  <h1>I nostri servizi</h1>
  <p>Vuoi acquistare una proprietà a Scalea ma non vuoi cadere nelle trappole degli intermediari? Ti aiutiamo a superare l‚intero processo – con trasparenza, umanità e senza costi inutili.</p>

  <h2>🔍 Pacchetto ‚Esploratore‘ – per chi sta ancora cercando</h2>
  <ul>
    <li>Consulenza gratuita (telefono, email, messaggi)</li>
    <li>Consigli su come scegliere gli immobili, cosa controllare in anticipo</li>
    <li>Spiegazione dei prezzi reali, differenze tra le zone e trucchi comuni</li>
    <li>Raccomandazione di agenzie affidabili con cui abbiamo collaborato</li>
  </ul>
  <p><strong>Adatto a:</strong> chi sta solo valutando e non vuole sbagliare.</p>

  <h2>📹 Pacchetto ‚A distanza‘ – se non vuoi partire subito per l‚Italia</h2>
  <ul>
    <li>Ti aiutiamo a selezionare immobili attuali in base ai tuoi criteri</li>
    <li>Mandiamo Martin – il nostro ‚factotum‘ – a fare il sopralluogo</li>
    <li>Effettua una visita dettagliata, registra un video, controlla acqua, umidità e condizioni reali</li>
    <li>Senza pressioni – decidi tu se continuare</li>
  </ul>
  <p><strong>Adatto a:</strong> chi vuole risparmiare tempo e denaro ma avere certezza.</p>

  <h2>📁 Pacchetto ‚Comfort‘ – quando decidi di acquistare</h2>
  <ul>
    <li>Assistenza nella scelta dell‚immobile specifico e trattative con l‚agenzia</li>
    <li>Traduzione dei contratti e documentazione, spiegazione dei passaggi legali</li>
    <li>Assistenza alla firma del contratto di prenotazione</li>
    <li>Raccomandazione di un notaio, apertura di un conto in euro, ottenimento del codice fiscale</li>
  </ul>
  <p><strong>Adatto a:</strong> chi ha deciso e vuole fare tutto bene e serenamente.</p>

  <h2>🏠 Pacchetto ‚Full service‘ – dalla A alla Z</h2>
  <ul>
    <li>Tutti i servizi dei pacchetti precedenti</li>
    <li>Accompagnamento personale in Italia (possibilità di soggiorno nel nostro appartamento)</li>
    <li>Dopo l‚acquisto: consegna delle chiavi, voltura utenze, assicurazione</li>
    <li>Consigli per ristrutturazione, arredamento e gestione dell‚immobile</li>
  </ul>
  <p><strong>Adatto a:</strong> chi desidera massima tranquillità e supporto professionale.</p>

  <h2>💬 Prezzi e modalità di collaborazione</h2>
  <p>Ogni servizio ha un prezzo equo e trasparente. La maggior parte dei servizi si paga solo se decidi di acquistare. Il nostro compenso avviene:</p>
  <ul>
    <li>direttamente dall‚agenzia immobiliare (collaborazione ufficiale),</li>
    <li>oppure come tariffa di servizio concordata (ad es. per video-visita).</li>
  </ul>
  <p>Nessun costo nascosto. Saprai sempre cosa ricevi e quanto costa.</p>

  <div class=\"cta\" style=\"margin-top: 40px;\">
    <a href=\"/contact.php\" class=\"cta-btn\">Richiedi una consulenza gratuita</a>
  </div>",

];
?>

<section class="main-content">
  <?= $translations[$lang] ?>
</section>

<?php include __DIR__ . '/inc/footer.php'; ?>
