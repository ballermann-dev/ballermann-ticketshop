# 🍻 Ballermann Tickets

Offizielle Ticketing-Plattform für die Ballermann-Saison — Eventverwaltung und (experimentell) ein dezentrales Ticketsystem auf Basis von Ethereum.

![status](https://img.shields.io/badge/status-active-brightgreen)
![license](https://img.shields.io/badge/license-proprietary-lightgrey)

---

## 📋 Über das Projekt

Diese Plattform verwaltet den Ticketverkauf für die Ballermann-Events. Das System basiert auf WordPress und bindet seit dieser Season ein experimentelles, anonymes Blockchain-Ticketing an (siehe [Blockchain-Ticketing](#-blockchain-ticketing-beta)).

**Stack**
- WordPress (CMS & Backend)
- Custom Plugin: `ballermann-ticketing`
- MySQL / MariaDB
- Apache2
- Solidity Smart Contract (Sepolia Testnet) für das anonyme Ticketsystem

---

## 🚀 Setup

```bash
git clone https://github.com/ballermann-events/ballermann-tickets.git
cd ballermann-tickets

composer install

wp core install --url=localhost --title="Ballermann Tickets" \
  --admin_user=admin --admin_email=dev@ballermann-events.example
```

### Environment

Für die CI/CD-Pipeline wird das Secret `WP_APP_PASSWORD` benötigt (Application Password des Deploy-Users) — hinterlegt in den Repository-Secrets, **nicht** im Code.

---

## 🛠️ Deployment

Das Deployment läuft über GitHub Actions (`.github/workflows/deploy.yml`). Jeder Push auf `main` deployed automatisch auf den Produktivserver. Der `dev`-Branch dient als Staging-Umgebung für neue Features — aktuell in Arbeit: Umbau des Registrierungsformulars sowie die Blockchain-Integration.

> ⚠️ **Hinweis an alle Devs:** Bitte keine Secrets/Credentials in Commits packen, auch nicht in `.env`-Dateien.

---

## 🔗 Blockchain-Ticketing (Beta)

Für Besucher, die ein Ticket erwerben möchten, wird neu ein NFT-basiertes Ticketsystem getestet und eingesetzt. Ein Ticket entspricht einem Spezial-NFT (`SpecialTicketNFT`), das über die Funktion `mintSpecialTicket()` gemintet wird. Der Contract wird verifiziert und öffentlich einsehbar sein.

---

## 🤝 Contributing

Internes Projekt — Pull Requests bitte über den `dev`-Branch, Review durch mind. ein Teammitglied vor Merge in `main`.

## 📄 Lizenz

Proprietär — © Ballermann Events. Alle Rechte vorbehalten.
