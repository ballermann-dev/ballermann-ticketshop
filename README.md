# 🍻 Ballermann Tickets

Offizielle Ticketing-Plattform für die Ballermann-Saison — Eventverwaltung, Ticketverkauf und (experimentell) ein dezentrales Ticketsystem auf Basis von Ethereum.

![status](https://img.shields.io/badge/status-active-brightgreen)
![license](https://img.shields.io/badge/license-proprietary-lightgrey)

---

## 📋 Über das Projekt

Diese Plattform verwaltet den Ticketverkauf für die Ballermann-Events. Das System basiert auf WordPress mit einem individuell entwickelten Ticketing-Plugin und bindet seit dieser Season zusätzlich ein experimentelles, anonymes Blockchain-Ticketing an (siehe [Blockchain-Ticketing](#-blockchain-ticketing-beta)).

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

Konfiguration erfolgt über `.env` (siehe `.env.example`). Für die CI/CD-Pipeline wird zusätzlich das Secret `WP_APP_PASSWORD` benötigt (Application Password des Deploy-Users) — hinterlegt in den Repository-Secrets, **nicht** im Code.

---

## 🛠️ Deployment

Das Deployment läuft über GitHub Actions (`.github/workflows/deploy.yml`). Jeder Push auf `main` deployed automatisch auf den Produktivserver. Der `dev`-Branch dient als Staging-Umgebung für neue Features — aktuell in Arbeit: Umbau des Registrierungsformulars sowie die Blockchain-Integration.

> ⚠️ **Hinweis an alle Devs:** Bitte keine Secrets/Credentials in Commits packen, auch nicht in `.env`-Dateien, die ihr "nur kurz zum Testen" committed und danach wieder löscht — die Git-History vergisst nichts. (ja, das ist uns schon mal passiert 🙈)

---

## 🔗 Blockchain-Ticketing (Beta)

Für Besucher, die ihr Ticket anonym kaufen möchten, testen wir ein NFT-basiertes Ticketsystem auf dem Ethereum-Testnet (Sepolia). Ein Ticket entspricht einem NFT, das beim Kauf über `buyTicket()` gegen 0.1 (Test-)ETH gemintet wird und beim Einlass gegen die Wallet-Adresse verifiziert wird.

**Contract-Adresse:** siehe Projektseite „Infos zum anonymen Ticketingsystem" auf der Website

**Für Entwickler, die lokal gegen den Contract testen wollen:**

```bash
cast send <CONTRACT_ADDRESS> "buyTicket(uint256)" <TICKET_ID> \
  --value 0.1ether \
  --private-key <YOUR_PRIVATE_KEY> \
  --rpc-url <SEPOLIA_RPC_URL>

cast call <CONTRACT_ADDRESS> "ownerOf(uint256)" <TICKET_ID> \
  --rpc-url <SEPOLIA_RPC_URL>
```

Der Contract ist auf Etherscan verifiziert — Quellcode ist also öffentlich einsehbar. Sponsoren-Freitickets werden intern über eine separate Funktion ausgestellt; das ist nicht Teil des öffentlichen Kaufflows.

---

## 🤝 Contributing

Internes Projekt — Pull Requests bitte über den `dev`-Branch, Review durch mind. ein Teammitglied vor Merge in `main`.

## 📄 Lizenz

Proprietär — © Ballermann Events. Alle Rechte vorbehalten.
